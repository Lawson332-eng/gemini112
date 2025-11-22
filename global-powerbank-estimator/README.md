# 全球共享充电宝市场容量预估工具

> 基于城市人口、经济与场景的智能预估系统

[![Version](https://img.shields.io/badge/version-1.0.0-blue.svg)](https://github.com/yourusername/powerbank-estimator)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](LICENSE)

[English](README_EN.md) | 简体中文

## 📋 目录

- [功能特性](#功能特性)
- [演示截图](#演示截图)
- [快速开始](#快速开始)
- [计算模型](#计算模型)
- [WordPress集成](#wordpress集成)
- [文件说明](#文件说明)
- [测试用例](#测试用例)
- [浏览器兼容性](#浏览器兼容性)
- [技术栈](#技术栈)
- [常见问题](#常见问题)
- [更新日志](#更新日志)
- [许可证](#许可证)

## ✨ 功能特性

### 核心功能
- ✅ **智能预估算法** - 基于6大系数的综合计算模型
- ✅ **分步骤表单** - 直观的4步输入流程
- ✅ **参考城市数据** - 10+全球主要城市快速填充
- ✅ **可视化图表** - 雷达图和柱状图分析
- ✅ **多语言支持** - 中文/英文界面切换
- ✅ **响应式设计** - 完美适配移动端和桌面端
- ✅ **数据导出** - PDF报告、Excel、链接分享
- ✅ **纯前端实现** - 无需后端，数据本地计算

### 技术亮点
- 🚀 **零依赖安装** - 所有库通过CDN加载
- 🎨 **自定义主题** - 支持品牌色定制 (#070346, #FE714C, #E6F0EC)
- 📱 **PWA就绪** - 可作为Web App安装
- 🔒 **隐私保护** - 所有计算本地完成，不上传数据
- ⚡ **高性能** - 首屏加载 < 2秒，计算响应 < 100ms

## 📸 演示截图

### 桌面端
```
┌─────────────────────────────────────────┐
│  全球共享充电宝市场容量预估工具         │
│  [中文] [EN]                            │
├─────────────────────────────────────────┤
│  参考城市: [深圳 ▼]                     │
│                                         │
│  步骤 1: 基础信息                        │
│  城市名称: [________]                   │
│  国家/地区: [中国 ▼]                    │
│                                         │
│  [下一步]                               │
└─────────────────────────────────────────┘
```

### 计算结果
```
┌─────────────────────────────────────────┐
│  预估设备总量                           │
│  30.25 万台                             │
│  (302,500 台)                           │
└─────────────────────────────────────────┘

┌─────────────────────────────────────────┐
│  设备密度                               │
│  60 人/台                               │
│  全球基准: 212人/台 (中国)              │
│  ⭐⭐⭐⭐⭐                              │
└─────────────────────────────────────────┘
```

## 🚀 快速开始

### 方式1: 独立网页使用

1. **下载文件**
   ```bash
   git clone https://github.com/yourusername/powerbank-estimator.git
   cd global-powerbank-estimator
   ```

2. **直接打开**
   - 双击 `index.html` 或
   - 使用本地服务器：
   ```bash
   python -m http.server 8000
   # 访问 http://localhost:8000
   ```

3. **开始使用**
   - 选择参考城市快速填充，或手动输入数据
   - 按步骤完成表单
   - 点击"开始计算"查看结果

### 方式2: WordPress集成

#### 选项A: 短代码嵌入

1. **上传文件**
   将以下文件上传到主题目录：
   ```
   /wp-content/themes/your-theme/powerbank-calculator/
   ├── embed.html
   ├── script.js
   └── data.json
   ```

2. **添加短代码**
   在 `functions.php` 中添加：
   ```php
   function powerbank_calculator_shortcode() {
       wp_enqueue_script('chartjs', 'https://cdn.jsdelivr.net/npm/chart.js@4');
       wp_enqueue_script('jspdf', 'https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js');

       ob_start();
       include(get_template_directory() . '/powerbank-calculator/embed.html');
       return ob_get_clean();
   }
   add_shortcode('powerbank_calculator', 'powerbank_calculator_shortcode');
   ```

3. **使用短代码**
   在任意页面或文章中添加：
   ```
   [powerbank_calculator]
   ```

#### 选项B: 页面模板

1. **创建模板文件**
   在主题目录创建 `page-calculator.php`：
   ```php
   <?php
   /*
   Template Name: Powerbank Calculator
   */
   get_header();
   include 'powerbank-calculator/embed.html';
   get_footer();
   ?>
   ```

2. **创建页面**
   - 在WordPress后台创建新页面
   - 选择模板 "Powerbank Calculator"
   - 发布

#### 选项C: Elementor/其他页面构建器

1. 添加HTML小部件
2. 粘贴 `embed.html` 的内容
3. 确保CDN链接正常加载

## 🧮 计算模型

### 核心公式

```
预估设备容量(万台) = 城区人口(万) ÷ (基准密度 ÷ 综合系数)

综合系数 = 城市等级系数 × 经济系数 × 人口密度系数 ×
          商业场景系数 × 移动支付系数 × 气候系数
```

### 系数详解

#### 1. 城市等级系数 (City Level Coefficient)
根据人口规模自动判断：

| 等级 | 人口范围 | 系数范围 | 默认值 |
|------|---------|---------|--------|
| 超大城市 | > 1000万 | 3.0 - 4.5 | 3.8 |
| 特大城市 | 500-1000万 | 2.5 - 3.5 | 3.0 |
| 大城市 | 300-500万 | 2.0 - 2.8 | 2.4 |
| 中等城市 | 100-300万 | 1.5 - 2.2 | 1.8 |
| 小城市 | 50-100万 | 1.0 - 1.5 | 1.2 |
| 微型城市 | < 50万 | 0.6 - 1.0 | 0.8 |

#### 2. 经济系数 (Economic Coefficient)
根据人均GDP (USD)：

| 等级 | GDP范围 | 系数 |
|------|---------|------|
| 极高收入 | > $50k | 1.5 |
| 高收入 | $30k-50k | 1.3 |
| 中高收入 | $15k-30k | 1.1 |
| 中等收入 | $8k-15k | 1.0 |
| 低收入 | < $8k | 0.8 |

#### 3. 人口密度系数 (Density Coefficient)
根据实际城区密度 (人/km²)：

| 等级 | 密度范围 | 系数 |
|------|---------|------|
| 超高密度 | ≥ 10000 | 1.4 |
| 高密度 | 5000-10000 | 1.25 |
| 中高密度 | 3000-5000 | 1.15 |
| 标准密度 | 1500-3000 | 1.0 |
| 低密度 | < 1500 | 0.8 |

#### 4. 商业场景系数 (Commercial Coefficient)
根据大型商业综合体数量：

| 等级 | 数量 | 系数 |
|------|------|------|
| 极高 | > 10个 | 1.4 |
| 高 | 6-10个 | 1.25 |
| 中 | 3-5个 | 1.1 |
| 低 | 1-3个 | 0.9 |
| 极低 | < 1个 | 0.6 |

#### 5. 移动支付系数 (Mobile Payment Coefficient)
根据普及率 (%)：

| 等级 | 普及率 | 系数 |
|------|--------|------|
| 极高 | > 80% | 1.4 |
| 高 | 60-80% | 1.2 |
| 中 | 40-60% | 1.05 |
| 低 | 20-40% | 0.9 |
| 极低 | < 20% | 0.65 |

#### 6. 气候系数 (Climate Coefficient)

| 气候类型 | 系数 | 说明 |
|---------|------|------|
| 热带/亚热带 | 1.2 | 高温环境，手机耗电快 |
| 温带 | 1.05 | 标准气候 |
| 寒带/高原 | 0.95 | 低温影响电池性能 |

### 基准密度 (Baseline Density)

不同地区的基准密度（人/台）：

| 地区 | 基准密度 | 说明 |
|------|---------|------|
| 中国 | 212 | 市场最成熟 |
| 日本 | 250 | 高收入市场 |
| 韩国 | 250 | 高收入市场 |
| 东南亚 | 180 | 新兴市场 |
| 欧洲 | 300 | 移动支付普及率低 |
| 北美 | 300 | 移动支付普及率低 |
| 中东 | 350 | 高收入但需求较低 |
| 其他 | 320 | 全球平均 |

## 📁 文件说明

```
global-powerbank-estimator/
├── index.html          # 独立网页版本（完整HTML）
├── embed.html          # WordPress嵌入版本（无header/footer）
├── script.js           # 核心计算逻辑和UI交互
├── data.json           # 参考城市数据和系数配置
├── README.md           # 中文使用文档
├── README_EN.md        # 英文使用文档
└── LICENSE             # MIT许可证
```

### 文件依赖关系

```
index.html
  ├── script.js (必需)
  ├── data.json (必需)
  ├── Tailwind CSS (CDN)
  ├── Chart.js (CDN)
  └── jsPDF (CDN)

embed.html (同上)
```

## ✅ 测试用例

### 测试1: 深圳
```
输入:
- 人口: 1798万
- 面积: 1997 km²
- GDP: $28,000
- 商业体: 12个

预期输出:
- 设备容量: ~30万台
- 密度: ~60人/台
- 评级: ⭐⭐⭐⭐⭐
```

### 测试2: 东京
```
输入:
- 人口: 1396万
- 面积: 2194 km²
- GDP: $52,000
- 商业体: 15个

预期输出:
- 设备容量: ~18万台
- 密度: ~78人/台
- 评级: ⭐⭐⭐⭐⭐
```

### 测试3: 新加坡
```
输入:
- 人口: 564万
- 面积: 733 km²
- GDP: $72,000
- 商业体: 8个

预期输出:
- 设备容量: ~10万台
- 密度: ~56人/台
- 评级: ⭐⭐⭐⭐⭐
```

## 🌐 浏览器兼容性

| 浏览器 | 最低版本 | 测试状态 |
|--------|---------|---------|
| Chrome | 90+ | ✅ 通过 |
| Firefox | 88+ | ✅ 通过 |
| Safari | 14+ | ✅ 通过 |
| Edge | 90+ | ✅ 通过 |
| IE11 | - | ⚠️ 部分支持 |

## 🛠 技术栈

- **前端框架**: Vanilla JavaScript (ES6+)
- **CSS框架**: Tailwind CSS 3.x (CDN)
- **图表库**: Chart.js 4.4.0
- **PDF生成**: jsPDF 2.5.1
- **数据格式**: JSON
- **响应式**: Mobile-first Design

## ❓ 常见问题

### Q1: 如何修改主题颜色？

**A**: 在 `index.html` 或 `embed.html` 中修改CSS变量：

```css
:root {
    --primary: #070346;    /* 主色 */
    --secondary: #FE714C;  /* 强调色 */
    --accent: #E6F0EC;     /* 辅助色 */
}
```

### Q2: 如何添加新的参考城市？

**A**: 编辑 `data.json` 文件的 `referenceCities` 数组：

```json
{
  "name_zh": "北京",
  "name_en": "Beijing",
  "country": "china",
  "population": 2189,
  "area": 16410,
  "gdp": 25000,
  "malls": 20,
  "urbanRatio": 86,
  "mobilePay": 87
}
```

### Q3: 计算结果不准确怎么办？

**A**: 可以调整以下参数：
1. 检查输入数据的准确性（尤其是城区面积）
2. 调整 `data.json` 中的系数范围
3. 修改国家基准密度

### Q4: 如何禁用某个语言？

**A**: 在 `script.js` 中删除对应语言的翻译对象，并移除语言切换按钮。

### Q5: 能否离线使用？

**A**: 需要下载CDN依赖到本地：
1. 下载 Tailwind CSS、Chart.js、jsPDF
2. 修改HTML中的script/link标签指向本地文件
3. 使用Service Worker实现PWA缓存

### Q6: WordPress集成后样式冲突怎么办？

**A**: 使用 `embed.html` 版本，所有样式都限定在 `#powerbank-estimator-app` 容器内。

### Q7: 如何添加新的国家？

**A**: 在 `data.json` 的 `countryDefaults` 中添加：

```json
"india": {
  "baseline": 250,
  "mobilePay": 45,
  "climate": "tropical",
  "urbanRatio": 35,
  "name_zh": "印度",
  "name_en": "India"
}
```

### Q8: 如何自定义计算公式？

**A**: 修改 `script.js` 中的 `performCalculation()` 方法和各系数计算函数。

## 📝 更新日志

### v1.0.0 (2025-01-15)
- ✨ 初始版本发布
- ✅ 6大系数计算模型
- ✅ 10+参考城市数据
- ✅ 中英文双语支持
- ✅ PDF/Excel导出功能
- ✅ WordPress集成支持
- ✅ 响应式设计

## 🤝 贡献

欢迎提交Issue和Pull Request！

1. Fork 本仓库
2. 创建特性分支 (`git checkout -b feature/AmazingFeature`)
3. 提交更改 (`git commit -m 'Add some AmazingFeature'`)
4. 推送到分支 (`git push origin feature/AmazingFeature`)
5. 开启Pull Request

## 📄 许可证

本项目采用 MIT 许可证 - 详见 [LICENSE](LICENSE) 文件

## 📧 联系方式

- 项目主页: https://github.com/yourusername/powerbank-estimator
- 问题反馈: https://github.com/yourusername/powerbank-estimator/issues
- Email: your.email@example.com

## 🙏 鸣谢

- [Tailwind CSS](https://tailwindcss.com/)
- [Chart.js](https://www.chartjs.org/)
- [jsPDF](https://github.com/parallax/jsPDF)
- 参考城市数据来源: Wikipedia

---

**⭐ 如果这个项目对您有帮助，请给我们一个Star！**
