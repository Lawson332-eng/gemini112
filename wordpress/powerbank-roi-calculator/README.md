# Powerbank ROI Calculator - WordPress Plugin

专业的共享充电宝投资回报率(ROI)计算器WordPress插件。

## 📦 插件信息

- **版本**: 1.0.0
- **需要WordPress版本**: 5.0 或更高
- **测试通过WordPress版本**: 6.4
- **需要PHP版本**: 7.4 或更高
- **许可**: MIT

## ✨ 功能特性

- ✅ **短代码支持** - 在任何页面/文章中使用 `[roi_calculator]`
- ✅ **Gutenberg块** - 可视化编辑器块
- ✅ **完全响应式** - 完美支持手机、平板、PC
- ✅ **主题自定义** - 可自定义品牌颜色
- ✅ **参数配置** - 支持短代码参数传递
- ✅ **无冲突设计** - 与主题样式完美兼容
- ✅ **轻量级** - 按需加载资源

## 🚀 快速安装

### 方法一：WordPress后台安装

1. 下载插件zip文件
2. 登录WordPress后台
3. 进入 `插件` → `安装插件`
4. 点击 `上传插件` 按钮
5. 选择下载的zip文件
6. 点击 `立即安装`
7. 安装完成后点击 `激活插件`

### 方法二：FTP上传

1. 解压插件zip文件
2. 通过FTP上传 `powerbank-roi-calculator` 文件夹到 `/wp-content/plugins/` 目录
3. 登录WordPress后台
4. 进入 `插件` 页面
5. 找到 "Powerbank ROI Calculator" 并点击 `激活`

### 方法三：WP-CLI安装

```bash
wp plugin install powerbank-roi-calculator.zip --activate
```

## 📖 使用方法

### 1. 基础短代码

在页面或文章中插入：

```
[roi_calculator]
```

### 2. 带参数的短代码

预设初始值：

```
[roi_calculator sites="100" orders="2.5" price="18"]
```

所有可用参数：

```
[roi_calculator
    sites="100"           // 站点数量
    orders="2.5"          // 每站点日均订单
    price="18"            // 单次租赁价格
    device_cost="2500"    // 单站设备成本
    venue_commission="20" // 场地分成比例
    width="100%"          // 宽度
    height="auto"         // 高度
    theme="default"       // 主题: default/light/dark
]
```

### 3. Gutenberg块编辑器

1. 在编辑器中点击 `+` 添加块
2. 搜索 "ROI计算器" 或 "Powerbank"
3. 插入块
4. 在右侧面板配置参数
5. 预览和发布

### 4. 页面构建器

**Elementor**
1. 添加 "HTML" 小工具
2. 粘贴短代码
3. 调整容器宽度

**Divi**
1. 添加 "代码" 模块
2. 插入短代码

**Beaver Builder**
1. 添加 "HTML" 模块
2. 粘贴短代码

## ⚙️ 插件设置

### 访问设置页面

`WordPress后台` → `设置` → `ROI计算器`

### 可配置选项

1. **主题色** - 自定义品牌主色调
2. **次要色** - 自定义渐变次色
3. **默认参数** - 设置全局默认值（即将推出）
4. **显示选项** - 控制功能显示/隐藏（即将推出）

## 🎨 自定义样式

### 覆盖插件CSS

在主题的 `style.css` 或 `custom.css` 中添加：

```css
/* 自定义计算器容器 */
.powerbank-roi-calculator-wrapper {
    background: #f9fafb;
    padding: 20px;
    border-radius: 15px;
}

/* 自定义按钮颜色 */
.powerbank-roi-calculator-wrapper button {
    background: #your-color !important;
}

/* 自定义卡片样式 */
.powerbank-roi-calculator-wrapper .metric-card {
    border: 2px solid #your-color;
}
```

### 使用CSS类

给容器添加自定义类：

```html
<div class="my-custom-class">
    [roi_calculator]
</div>
```

## 🔧 高级集成

### PHP函数调用

在主题模板文件中：

```php
<?php
if (function_exists('powerbank_roi_calculator_init')) {
    echo do_shortcode('[roi_calculator sites="100"]');
}
?>
```

### 条件加载

只在特定页面加载：

```php
<?php
if (is_page('roi-calculator')) {
    echo do_shortcode('[roi_calculator]');
}
?>
```

### 自定义模板

创建专属计算器页面模板：

```php
<?php
/**
 * Template Name: ROI Calculator Page
 */
get_header();
?>

<div class="calculator-page-wrapper">
    <h1>投资回报计算器</h1>
    <?php echo do_shortcode('[roi_calculator]'); ?>
</div>

<?php get_footer(); ?>
```

## 🐛 故障排除

### 计算器不显示

**检查清单**:
1. 插件是否已激活？
2. 短代码拼写是否正确？
3. 浏览器控制台是否有错误？
4. 主题是否与jQuery冲突？

**解决方案**:
```php
// 在functions.php中添加
function fix_jquery_conflict() {
    wp_deregister_script('jquery');
    wp_register_script('jquery', 'https://code.jquery.com/jquery-3.6.0.min.js', array(), '3.6.0', true);
}
add_action('wp_enqueue_scripts', 'fix_jquery_conflict', 1);
```

### 样式显示异常

**原因**: 主题CSS覆盖

**解决方案**:
```css
/* 强制应用插件样式 */
.powerbank-roi-calculator-wrapper * {
    all: revert !important;
}
```

### 移动端显示不完整

**解决方案**:
```html
<!-- 确保页面有viewport meta标签 -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
```

### 图表不显示

**原因**: Chart.js未加载

**检查**: 浏览器控制台是否有 "Chart is not defined" 错误

**解决方案**: 清除缓存并重新加载页面

## 📊 性能优化

### 延迟加载

只在可见时加载计算器：

```javascript
// 添加到主题JS
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            // 加载计算器
            entry.target.classList.add('load-calculator');
        }
    });
});

document.querySelectorAll('.powerbank-roi-calculator-wrapper').forEach(el => {
    observer.observe(el);
});
```

### CDN缓存

使用国内CDN加速（在插件设置中配置）：

```php
// 即将支持的功能
- BootCDN
- jsDelivr
- Staticfile CDN
```

### 条件加载

只在需要的页面加载：

```php
// 在functions.php中
function load_calculator_conditionally() {
    if (!is_page('calculator') && !is_single()) {
        wp_dequeue_script('pbrc-calculator');
    }
}
add_action('wp_enqueue_scripts', 'load_calculator_conditionally', 100);
```

## 🔒 安全性

### 数据隐私

- ✅ 所有计算在客户端完成
- ✅ 不收集用户输入数据
- ✅ 不向服务器发送敏感信息
- ✅ 符合GDPR合规要求

### 代码安全

- ✅ 所有输入经过转义和验证
- ✅ 防止XSS攻击
- ✅ 防止SQL注入
- ✅ 遵循WordPress编码标准

## 🌍 多语言支持

### 翻译插件

插件已准备好翻译：

```bash
wp-content/plugins/powerbank-roi-calculator/languages/
├── powerbank-roi-calculator-zh_CN.po
├── powerbank-roi-calculator-zh_CN.mo
└── powerbank-roi-calculator.pot
```

### 添加翻译

1. 使用Poedit打开 `.pot` 文件
2. 创建新的语言翻译
3. 保存为 `powerbank-roi-calculator-{locale}.po` 和 `.mo`
4. 上传到 `languages/` 目录

### 支持的语言

- 🇨🇳 简体中文 (zh_CN) - 默认
- 🇺🇸 英语 (en_US) - 即将推出
- 🇭🇰 繁体中文 (zh_TW) - 即将推出

## 📝 更新日志

### 1.0.0 (2025-01-06)
- ✨ 首次发布
- ✅ 基础短代码功能
- ✅ Gutenberg块支持
- ✅ 响应式设计
- ✅ 主题自定义
- ✅ Excel导出功能

### 即将推出 (1.1.0)
- [ ] PDF报告导出
- [ ] 方案对比功能
- [ ] 数据统计追踪
- [ ] 更多主题选项
- [ ] 国内CDN支持

## 🤝 贡献

欢迎贡献代码！

### 开发环境

```bash
# 克隆仓库
git clone https://github.com/yourusername/powerbank-roi-calculator.git

# 进入插件目录
cd powerbank-roi-calculator

# 安装依赖（如果有）
npm install

# 开发构建
npm run dev
```

### 提交规范

- 遵循WordPress编码标准
- 添加适当的注释
- 更新文档
- 通过所有测试

## 📄 许可证

本插件采用 MIT 许可证。详见 [LICENSE](LICENSE) 文件。

## 📞 支持

### 文档
- [完整文档](../INTEGRATION.md)
- [使用指南](../../public/USAGE.md)
- [API文档](../../public/README.md)

### 获取帮助
- [GitHub Issues](https://github.com/yourusername/repo/issues)
- [WordPress.org支持论坛](https://wordpress.org/support/plugin/powerbank-roi-calculator/)
- 邮件: support@yourdomain.com

## 🙏 鸣谢

- React - UI框架
- Tailwind CSS - 样式框架
- Chart.js - 图表库
- WordPress社区

---

**开发者**: Your Name
**网站**: https://yourdomain.com
**版本**: 1.0.0
**最后更新**: 2025-01-06
