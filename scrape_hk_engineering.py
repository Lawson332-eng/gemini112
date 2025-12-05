#!/usr/bin/env python3
"""
Google Maps爬虫 - 提取香港工程公司信息
"""
import asyncio
import json
from datetime import datetime
from playwright.async_api import async_playwright
import time

class GoogleMapsScraper:
    def __init__(self):
        self.companies = []
        self.seen_names = set()

    async def scroll_results(self, page, max_scrolls=20):
        """滚动加载更多结果"""
        print("开始滚动加载结果...")

        # 等待结果列表加载
        try:
            await page.wait_for_selector('div[role="feed"]', timeout=10000)
        except:
            print("未找到结果列表")
            return

        last_height = 0
        scroll_count = 0
        no_change_count = 0

        while scroll_count < max_scrolls and no_change_count < 3:
            # 滚动结果面板
            await page.evaluate('''
                const feed = document.querySelector('div[role="feed"]');
                if (feed) {
                    feed.scrollTo(0, feed.scrollHeight);
                }
            ''')

            await asyncio.sleep(2)  # 等待加载

            # 检查高度变化
            current_height = await page.evaluate('''
                const feed = document.querySelector('div[role="feed"]');
                return feed ? feed.scrollHeight : 0;
            ''')

            if current_height == last_height:
                no_change_count += 1
            else:
                no_change_count = 0

            last_height = current_height
            scroll_count += 1

            # 获取当前加载的结果数
            items = await page.query_selector_all('div[role="feed"] > div > div > a')
            print(f"滚动 {scroll_count}/{max_scrolls}, 当前结果数: {len(items)}")

    async def extract_company_info(self, page, result_item):
        """提取单个公司的详细信息"""
        try:
            # 点击结果项
            await result_item.click()
            await asyncio.sleep(1.5)  # 等待详情加载

            company_data = {}

            # 提取公司名称
            try:
                name_element = await page.query_selector('h1')
                if name_element:
                    company_data['name'] = await name_element.inner_text()
                else:
                    return None
            except:
                return None

            # 如果已经提取过这个公司，跳过
            if company_data['name'] in self.seen_names:
                return None

            # 提取地址
            try:
                address_button = await page.query_selector('button[data-item-id="address"]')
                if address_button:
                    address_text = await address_button.inner_text()
                    # 清理地址文本
                    lines = address_text.strip().split('\n')
                    company_data['address'] = lines[-1] if lines else ''
                else:
                    company_data['address'] = ''
            except:
                company_data['address'] = ''

            # 提取电话
            try:
                phone_button = await page.query_selector('button[data-item-id^="phone:tel:"]')
                if phone_button:
                    phone_text = await phone_button.inner_text()
                    # 清理电话文本
                    lines = phone_text.strip().split('\n')
                    company_data['phone'] = lines[-1] if lines else ''
                else:
                    company_data['phone'] = ''
            except:
                company_data['phone'] = ''

            return company_data

        except Exception as e:
            print(f"提取信息时出错: {e}")
            return None

    async def search_keyword(self, page, keyword):
        """搜索单个关键词"""
        print(f"\n{'='*60}")
        print(f"搜索关键词: {keyword}")
        print(f"{'='*60}")

        # 构建Google Maps搜索URL
        search_url = f"https://www.google.com/maps/search/{keyword}"

        try:
            await page.goto(search_url, wait_until='domcontentloaded', timeout=30000)
            await asyncio.sleep(3)

            # 滚动加载更多结果
            await self.scroll_results(page, max_scrolls=15)

            # 获取所有结果项
            result_items = await page.query_selector_all('div[role="feed"] > div > div > a')
            print(f"找到 {len(result_items)} 个结果")

            # 限制提取数量（每个关键词最多提取100个）
            max_items = min(len(result_items), 100)

            for i, item in enumerate(result_items[:max_items]):
                print(f"处理 {i+1}/{max_items}...", end='\r')

                company_data = await self.extract_company_info(page, item)

                if company_data and company_data['name'] not in self.seen_names:
                    self.companies.append(company_data)
                    self.seen_names.add(company_data['name'])
                    print(f"✓ 提取: {company_data['name'][:30]}... (总计: {len(self.companies)})")

                # 返回结果列表
                try:
                    back_button = await page.query_selector('button[aria-label*="返回"]')
                    if not back_button:
                        back_button = await page.query_selector('button[aria-label*="Back"]')
                    if back_button:
                        await back_button.click()
                        await asyncio.sleep(0.5)
                except:
                    # 如果找不到返回按钮，重新加载搜索页面
                    await page.goto(search_url, wait_until='domcontentloaded')
                    await asyncio.sleep(2)

        except Exception as e:
            print(f"搜索关键词 '{keyword}' 时出错: {e}")

    async def scrape(self, keywords):
        """主爬取函数"""
        async with async_playwright() as p:
            # 启动浏览器
            print("启动浏览器...")
            browser = await p.chromium.launch(
                headless=True,
                args=['--no-sandbox', '--disable-setuid-sandbox']
            )

            context = await browser.new_context(
                viewport={'width': 1280, 'height': 720},
                locale='zh-HK',
                user_agent='Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
            )

            page = await context.new_page()

            # 搜索每个关键词
            for keyword in keywords:
                await self.search_keyword(page, keyword)
                await asyncio.sleep(2)  # 关键词之间的延迟

            await browser.close()

        return self.companies

def generate_markdown(companies, output_file):
    """生成Markdown文件"""
    timestamp = datetime.now().strftime("%Y-%m-%d %H:%M:%S")

    content = f"""# 香港工程公司列表

**提取时间**: {timestamp}
**总数**: {len(companies)} 家公司

| 序号 | 公司名称 | 地址 | 联系电话 |
|------|----------|------|----------|
"""

    for i, company in enumerate(companies, 1):
        name = company.get('name', '').replace('|', '\\|')
        address = company.get('address', '').replace('|', '\\|')
        phone = company.get('phone', '').replace('|', '\\|')

        content += f"| {i} | {name} | {address} | {phone} |\n"

    with open(output_file, 'w', encoding='utf-8') as f:
        f.write(content)

    print(f"\n✓ Markdown文件已生成: {output_file}")

async def main():
    keywords = [
        "工程公司 香港",
        "建筑工程 香港",
        "机电工程 香港",
        "土木工程 香港",
        "装修工程 香港"
    ]

    scraper = GoogleMapsScraper()

    print("="*60)
    print("Google Maps 香港工程公司爬虫")
    print("="*60)
    print(f"搜索关键词: {len(keywords)} 个")
    print(f"目标: 每个关键词提取至少100个结果\n")

    # 开始爬取
    companies = await scraper.scrape(keywords)

    print("\n" + "="*60)
    print(f"爬取完成！总计提取 {len(companies)} 家公司")
    print("="*60)

    # 生成Markdown文件
    output_file = "香港工程公司列表.md"
    generate_markdown(companies, output_file)

    # 保存JSON备份
    json_file = "香港工程公司列表.json"
    with open(json_file, 'w', encoding='utf-8') as f:
        json.dump(companies, f, ensure_ascii=False, indent=2)
    print(f"✓ JSON备份已生成: {json_file}")

    # 显示前10条预览
    print("\n" + "="*60)
    print("前10条数据预览:")
    print("="*60)
    for i, company in enumerate(companies[:10], 1):
        print(f"\n{i}. {company.get('name', 'N/A')}")
        print(f"   地址: {company.get('address', 'N/A')}")
        print(f"   电话: {company.get('phone', 'N/A')}")

if __name__ == "__main__":
    asyncio.run(main())
