# WordPress集成指南

将共享充电宝ROI计算器集成到WordPress网站的完整指南。

## 📋 目录

1. [方案对比](#方案对比)
2. [方案一：短代码集成（推荐）](#方案一短代码集成推荐)
3. [方案二：WordPress插件](#方案二wordpress插件)
4. [方案三：iframe嵌入](#方案三iframe嵌入)
5. [方案四：Gutenberg块](#方案四gutenberg块)
6. [方案五：页面模板](#方案五页面模板)
7. [常见问题](#常见问题)

---

## 方案对比

| 方案 | 难度 | 推荐度 | 优点 | 缺点 |
|------|------|--------|------|------|
| **短代码** | ⭐ | ⭐⭐⭐⭐⭐ | 简单快速、灵活 | 需修改主题文件 |
| **插件** | ⭐⭐ | ⭐⭐⭐⭐⭐ | 专业、易管理 | 需上传插件 |
| **iframe** | ⭐ | ⭐⭐⭐ | 最简单 | 性能略差、样式隔离 |
| **Gutenberg块** | ⭐⭐⭐ | ⭐⭐⭐⭐ | 编辑器友好 | 需要开发 |
| **页面模板** | ⭐⭐ | ⭐⭐⭐ | 完全控制 | 仅适用单页面 |

---

## 方案一：短代码集成（推荐）

### 优点
- ✅ 快速实现（5分钟）
- ✅ 可在任何页面/文章使用
- ✅ 与主题完美融合
- ✅ 支持参数自定义

### 实现步骤

#### 1. 上传计算器文件

将以下文件上传到WordPress：

**方式A：上传到主题目录（推荐）**
```bash
wp-content/themes/你的主题名/roi-calculator/
├── calculator.html
└── assets/
    └── (可选的自定义资源)
```

**方式B：上传到uploads目录**
```bash
wp-content/uploads/roi-calculator/
└── calculator.html
```

#### 2. 添加短代码到functions.php

打开主题的 `functions.php` 文件，添加以下代码：

```php
<?php
/**
 * 共享充电宝ROI计算器短代码
 * 使用方法: [roi_calculator] 或 [roi_calculator height="800"]
 */
function powerbank_roi_calculator_shortcode($atts) {
    // 解析短代码参数
    $atts = shortcode_atts(array(
        'height' => '1200', // 默认高度
        'width' => '100%',  // 默认宽度
    ), $atts);

    // 计算器HTML内容（内联方式）
    ob_start();
    ?>
    <div id="roi-calculator-container" style="width: <?php echo esc_attr($atts['width']); ?>; max-width: 100%; margin: 0 auto;">
        <div id="roi-calculator-app"></div>
    </div>

    <script>
        // 确保只加载一次依赖
        if (typeof window.roiCalculatorLoaded === 'undefined') {
            window.roiCalculatorLoaded = true;

            // 加载依赖库
            const scripts = [
                'https://cdn.tailwindcss.com',
                'https://unpkg.com/react@18/umd/react.production.min.js',
                'https://unpkg.com/react-dom@18/umd/react-dom.production.min.js',
                'https://unpkg.com/@babel/standalone/babel.min.js',
                'https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js',
                'https://cdn.sheetjs.com/xlsx-0.20.0/package/dist/xlsx.full.min.js'
            ];

            let loadedCount = 0;
            scripts.forEach(src => {
                const script = document.createElement('script');
                script.src = src;
                script.onload = () => {
                    loadedCount++;
                    if (loadedCount === scripts.length) {
                        loadCalculatorApp();
                    }
                };
                document.head.appendChild(script);
            });
        } else {
            // 如果已加载，直接初始化
            setTimeout(loadCalculatorApp, 500);
        }

        function loadCalculatorApp() {
            // 从主文件中提取并加载计算器代码
            fetch('<?php echo get_template_directory_uri(); ?>/roi-calculator/calculator-inline.js')
                .then(response => response.text())
                .then(code => {
                    const script = document.createElement('script');
                    script.type = 'text/babel';
                    script.textContent = code;
                    document.body.appendChild(script);
                });
        }
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('roi_calculator', 'powerbank_roi_calculator_shortcode');
```

#### 3. 使用短代码

在任何页面或文章中插入：

```
[roi_calculator]
```

带参数：
```
[roi_calculator height="1000" width="100%"]
```

---

## 方案二：WordPress插件

### 使用现成插件

我们提供了一个完整的WordPress插件，包含所有功能。

#### 安装步骤

1. **下载插件文件**
   - 下载 `wordpress/powerbank-roi-calculator.zip`

2. **上传安装**
   - 登录WordPress后台
   - 进入 `插件` → `安装插件`
   - 点击 `上传插件`
   - 选择zip文件上传
   - 点击 `立即安装`
   - 激活插件

3. **使用插件**
   - 在编辑器中使用短代码：`[roi_calculator]`
   - 或在Gutenberg编辑器中搜索"ROI计算器"块

4. **插件设置**
   - 进入 `设置` → `ROI计算器`
   - 配置默认参数
   - 自定义颜色主题
   - 设置品牌Logo

#### 插件功能
- ✅ 短代码支持
- ✅ Gutenberg块编辑器
- ✅ 可视化参数配置
- ✅ 多语言支持
- ✅ 自定义主题色
- ✅ 数据统计追踪
- ✅ 自动更新

---

## 方案三：iframe嵌入

### 最简单方案，适合快速测试

#### 步骤1：托管计算器文件

**选项A：使用子域名（推荐）**
```
https://calculator.yourdomain.com
```

**选项B：使用子目录**
```
https://yourdomain.com/calculator/
```

#### 步骤2：创建iframe代码

在WordPress页面中切换到"代码编辑器"，插入：

```html
<div style="width: 100%; max-width: 1200px; margin: 0 auto;">
    <iframe
        src="https://calculator.yourdomain.com/index.html"
        width="100%"
        height="1200px"
        frameborder="0"
        scrolling="auto"
        style="border: none; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);"
        title="共享充电宝ROI计算器"
    ></iframe>
</div>
```

#### 步骤3：响应式高度调整（可选）

添加自动高度调整脚本：

```html
<script>
// 自动调整iframe高度
window.addEventListener('message', function(e) {
    if (e.data.type === 'resize') {
        document.getElementById('roi-iframe').style.height = e.data.height + 'px';
    }
});
</script>

<iframe
    id="roi-iframe"
    src="https://calculator.yourdomain.com/index.html"
    width="100%"
    height="1200px"
    frameborder="0"
></iframe>
```

### iframe优缺点

**优点**
- ✅ 实现最简单
- ✅ 样式完全隔离
- ✅ 不影响主站性能
- ✅ 可独立更新

**缺点**
- ❌ SEO不友好
- ❌ 加载速度略慢
- ❌ 跨域限制
- ❌ 移动端体验略差

---

## 方案四：Gutenberg块

### 适合WordPress 5.0+

自定义Gutenberg块提供最佳编辑体验。

#### 使用插件中的块

安装插件后，在编辑器中：

1. 点击 `+` 添加块
2. 搜索 "ROI计算器"
3. 插入块
4. 在右侧面板配置参数：
   - 默认站点数
   - 默认订单量
   - 默认价格
   - 主题颜色
   - 显示/隐藏高级参数

#### 块设置面板

```javascript
// 可配置项
- 显示模式：完整/精简
- 默认场景：保守/标准/乐观
- 主题色：自定义品牌色
- 显示选项：隐藏某些标签页
```

---

## 方案五：页面模板

### 创建专属计算器页面

#### 步骤1：创建页面模板

在主题目录创建 `template-calculator.php`：

```php
<?php
/**
 * Template Name: ROI Calculator Full Page
 * Description: 全屏ROI计算器页面模板
 */

get_header();
?>

<div id="roi-calculator-fullpage" style="min-height: 100vh;">
    <?php
    // 直接包含计算器HTML
    include(get_template_directory() . '/roi-calculator/calculator.html');
    ?>
</div>

<?php
// 可选：隐藏侧边栏和页脚
// get_footer();
?>
```

#### 步骤2：使用模板

1. 创建新页面
2. 页面属性 → 模板 → 选择 "ROI Calculator Full Page"
3. 发布页面

---

## 样式兼容性处理

### WordPress主题可能的样式冲突

#### 1. CSS Reset冲突

在计算器容器上添加样式隔离：

```css
/* 添加到主题的 style.css 或自定义CSS */
.roi-calculator-wrapper {
    all: initial;
    display: block;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important;
}

.roi-calculator-wrapper * {
    box-sizing: border-box;
}
```

#### 2. 颜色冲突

如果计算器颜色与主题冲突：

```php
// 在短代码中添加颜色参数
[roi_calculator primary_color="#667EEA" secondary_color="#764BA2"]
```

#### 3. 字体冲突

确保加载独立字体：

```html
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
```

---

## 性能优化

### 1. 延迟加载

仅在可见时加载计算器：

```javascript
// 使用Intersection Observer
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            loadCalculator();
            observer.disconnect();
        }
    });
});

observer.observe(document.getElementById('roi-calculator-container'));
```

### 2. 缓存优化

```php
// 在functions.php中添加
function roi_calculator_cache_scripts() {
    // 设置缓存时间为7天
    header('Cache-Control: public, max-age=604800');
}
add_action('wp_enqueue_scripts', 'roi_calculator_cache_scripts');
```

### 3. CDN加速

使用国内CDN替代：

```javascript
// 替换CDN地址
const cdnMirrors = {
    react: 'https://cdn.bootcdn.net/ajax/libs/react/18.2.0/umd/react.production.min.js',
    reactDom: 'https://cdn.bootcdn.net/ajax/libs/react-dom/18.2.0/umd/react-dom.production.min.js',
    chartjs: 'https://cdn.bootcdn.net/ajax/libs/Chart.js/4.4.0/chart.umd.min.js'
};
```

---

## 常见问题

### Q1: 计算器不显示怎么办？

**检查清单**
1. ✅ 是否正确上传了文件？
2. ✅ 短代码拼写是否正确？
3. ✅ 浏览器控制台是否有错误？
4. ✅ 主题是否加载了jQuery冲突？

**解决方案**
```php
// 在functions.php中添加
wp_deregister_script('jquery');
```

### Q2: 样式显示异常？

**原因**：主题CSS覆盖了计算器样式

**解决方案**：添加CSS优先级
```css
#roi-calculator-container * {
    all: revert;
}
```

### Q3: 移动端显示不完整？

**解决方案**：添加viewport调整
```html
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
```

### Q4: 如何自定义颜色？

**方式1：修改Tailwind配置**
```javascript
tailwind.config = {
    theme: {
        extend: {
            colors: {
                primary: '#YOUR_COLOR',
                secondary: '#YOUR_COLOR',
            }
        }
    }
}
```

**方式2：使用CSS变量**
```css
:root {
    --roi-primary: #667EEA;
    --roi-secondary: #764BA2;
}
```

### Q5: 如何追踪用户使用数据？

**集成Google Analytics**
```javascript
// 在导出按钮点击时
gtag('event', 'export', {
    'event_category': 'ROI Calculator',
    'event_label': 'Excel Export'
});
```

### Q6: 可以设置默认参数吗？

**可以！在短代码中传递参数**
```php
[roi_calculator sites="100" orders="2.5" price="18"]
```

### Q7: 如何集成到Elementor？

1. 使用"HTML"小工具
2. 粘贴iframe代码或短代码
3. 调整容器宽度

### Q8: 如何在Divi主题中使用？

1. 添加"代码"模块
2. 插入短代码：`[roi_calculator]`
3. 或使用iframe嵌入方式

---

## 技术支持

### 开发文档
- 详细API文档: `public/README.md`
- 使用指南: `public/USAGE.md`

### 联系方式
- GitHub Issues: [提交问题](https://github.com/yourusername/repo/issues)
- 邮件支持: support@yourdomain.com

### 更新日志
- v1.0.0 (2025-01-06) - 初始版本
- v1.1.0 (计划中) - WordPress插件优化

---

## 下一步

选择最适合您的集成方案：

- 🚀 **快速测试** → 使用方案三（iframe）
- 💼 **生产环境** → 使用方案二（插件）
- 🎨 **深度定制** → 使用方案一（短代码）
- ✨ **最佳体验** → 使用方案四（Gutenberg块）

**推荐路径**：iframe测试 → 插件安装 → 深度定制
