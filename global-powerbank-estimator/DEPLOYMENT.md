# 部署指南 / Deployment Guide

本文档提供完整的部署说明，包括独立部署和WordPress集成。

[English Version](#english-version) | [中文版本](#中文版本)

---

## 中文版本

### 📦 部署前准备

#### 1. 文件清单
确保您拥有以下文件：
- `index.html` - 独立网页版本
- `embed.html` - WordPress嵌入版本
- `script.js` - 核心JavaScript文件
- `data.json` - 数据配置文件
- `wordpress-integration.php` - WordPress集成示例（可选）

#### 2. 服务器要求
- **独立部署**: 任何支持静态HTML的Web服务器
- **WordPress**: WordPress 5.0+ (推荐 6.0+)
- **浏览器**: Chrome 90+, Firefox 88+, Safari 14+, Edge 90+

---

### 🚀 方式一：独立网站部署

#### 选项A: 静态托管服务

**适用于**: Netlify, Vercel, GitHub Pages, Cloudflare Pages

1. **上传文件**
   ```bash
   # 创建项目文件夹
   mkdir powerbank-estimator
   cd powerbank-estimator

   # 复制所有文件
   # index.html, script.js, data.json
   ```

2. **配置部署**
   - **Netlify**: 拖放文件夹到 netlify.com/drop
   - **Vercel**: `vercel --prod`
   - **GitHub Pages**: 推送到 `gh-pages` 分支
   - **Cloudflare Pages**: 连接Git仓库

3. **自定义域名**（可选）
   - 在托管服务中添加自定义域名
   - 配置DNS CNAME记录

#### 选项B: 传统Web服务器

**适用于**: Apache, Nginx, IIS

1. **上传文件到服务器**
   ```bash
   # 使用FTP/SFTP上传到网站根目录
   /var/www/html/powerbank-estimator/
   ```

2. **配置服务器（可选）**

   **Apache (.htaccess)**
   ```apache
   # 启用HTTPS重定向
   RewriteEngine On
   RewriteCond %{HTTPS} off
   RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

   # 启用Gzip压缩
   <IfModule mod_deflate.c>
       AddOutputFilterByType DEFLATE text/html text/css application/javascript application/json
   </IfModule>

   # 设置缓存
   <IfModule mod_expires.c>
       ExpiresActive On
       ExpiresByType application/javascript "access plus 1 month"
       ExpiresByType application/json "access plus 1 day"
   </IfModule>
   ```

   **Nginx (nginx.conf)**
   ```nginx
   location /powerbank-estimator {
       # 启用Gzip
       gzip on;
       gzip_types text/css application/javascript application/json;

       # 设置缓存头
       location ~* \.(js|json)$ {
           expires 30d;
           add_header Cache-Control "public, immutable";
       }
   }
   ```

3. **测试访问**
   ```
   https://yourdomain.com/powerbank-estimator/index.html
   ```

#### 选项C: 本地开发服务器

**Python (推荐)**
```bash
cd powerbank-estimator
python -m http.server 8000
# 访问: http://localhost:8000
```

**Node.js**
```bash
npx http-server -p 8000
```

**PHP**
```bash
php -S localhost:8000
```

---

### 🔌 方式二：WordPress集成

#### 准备工作

1. **上传文件到主题目录**
   ```
   /wp-content/themes/your-theme/powerbank-calculator/
   ├── embed.html
   ├── script.js
   └── data.json
   ```

   **通过FTP上传**:
   - 连接到您的WordPress主机
   - 导航到 `/wp-content/themes/你的主题名/`
   - 创建 `powerbank-calculator` 文件夹
   - 上传文件

   **通过文件管理器**:
   - 登录cPanel或主机面板
   - 使用文件管理器上传

2. **验证文件路径**
   确保文件可访问：
   ```
   https://yoursite.com/wp-content/themes/your-theme/powerbank-calculator/data.json
   ```

#### 集成方法1: 短代码（推荐）

1. **编辑 functions.php**

   在 `外观 > 主题文件编辑器` 或通过FTP编辑：
   `/wp-content/themes/your-theme/functions.php`

2. **添加代码**
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

   在任何页面或文章中添加：
   ```
   [powerbank_calculator]
   ```

4. **测试**
   - 创建新页面
   - 添加短代码
   - 预览/发布

#### 集成方法2: 页面模板

1. **创建模板文件**

   创建文件: `/wp-content/themes/your-theme/page-calculator.php`
   ```php
   <?php
   /*
   Template Name: Powerbank Calculator
   */
   get_header();
   ?>

   <div class="calculator-container">
       <?php include 'powerbank-calculator/embed.html'; ?>
   </div>

   <?php
   get_footer();
   ?>
   ```

2. **创建页面**
   - WordPress后台 > 页面 > 新建页面
   - 标题: "市场容量预估工具"
   - 页面属性 > 模板: 选择 "Powerbank Calculator"
   - 发布

#### 集成方法3: Elementor

1. **添加HTML小部件**
   - 编辑页面
   - 添加 "HTML" 小部件
   - 粘贴 `embed.html` 内容
   - 更新页面

2. **添加自定义代码**
   - Elementor > 自定义代码
   - 位置: 页面底部
   - 粘贴script标签

#### 集成方法4: 古腾堡

1. **添加自定义HTML块**
   - 编辑页面
   - 添加块 > 自定义HTML
   - 粘贴 `embed.html` 内容
   - 更新页面

---

### 🎨 自定义配置

#### 修改品牌颜色

在 `index.html` 或 `embed.html` 的 `<style>` 标签中：

```css
:root {
    --primary: #070346;    /* 深蓝色 - 主色 */
    --secondary: #FE714C;  /* 橙色 - 强调色 */
    --accent: #E6F0EC;     /* 浅绿色 - 辅助色 */
}

/* 修改为您的品牌色 */
:root {
    --primary: #YOUR_COLOR;
    --secondary: #YOUR_COLOR;
    --accent: #YOUR_COLOR;
}
```

#### 添加参考城市

编辑 `data.json` 的 `referenceCities` 数组：

```json
{
  "name_zh": "广州",
  "name_en": "Guangzhou",
  "country": "china",
  "population": 1868,
  "area": 7434,
  "gdp": 24000,
  "malls": 15,
  "urbanRatio": 86,
  "mobilePay": 88
}
```

#### 调整计算参数

编辑 `data.json` 的 `coefficients` 部分：

```json
"cityLevel": {
  "mega": {
    "min": 3.0,
    "max": 4.5,
    "default": 3.8  // 修改默认值
  }
}
```

---

### 🔧 故障排除

#### 问题1: 页面空白或不显示

**原因**: 文件路径错误

**解决方案**:
1. 检查 `script.js` 和 `data.json` 路径
2. 打开浏览器控制台查看错误
3. 确认文件权限（644）

**检查命令**:
```bash
# 检查文件是否存在
ls -la /path/to/powerbank-calculator/

# 检查权限
chmod 644 script.js data.json
chmod 755 powerbank-calculator/
```

#### 问题2: 样式错误或显示异常

**原因**: CSS冲突

**解决方案**:
1. 使用 `embed.html` 版本（样式隔离）
2. 检查WordPress主题CSS是否覆盖
3. 添加 `!important` 标记

```css
#powerbank-estimator-app .btn-primary {
    background: var(--secondary) !important;
}
```

#### 问题3: Chart.js不显示图表

**原因**: CDN加载失败

**解决方案**:
1. 检查网络连接
2. 使用备用CDN
3. 下载到本地

```html
<!-- 备用CDN -->
<script src="https://unpkg.com/chart.js@4.4.0/dist/chart.umd.min.js"></script>
```

#### 问题4: 计算结果不正确

**原因**: 数据输入错误

**解决方案**:
1. 检查输入数据单位（万人, km²）
2. 验证参考城市数据
3. 使用浏览器控制台调试

```javascript
// 在控制台查看计算详情
console.log(window.estimator.result);
```

#### 问题5: WordPress短代码不工作

**原因**: PHP语法错误或路径错误

**解决方案**:
```php
// 调试路径
echo get_template_directory() . '/powerbank-calculator/embed.html';

// 检查文件是否存在
if (file_exists(get_template_directory() . '/powerbank-calculator/embed.html')) {
    echo "文件存在";
} else {
    echo "文件不存在";
}
```

---

### 📊 性能优化

#### 1. 启用CDN加速

使用国内CDN（适用于中国用户）：

```html
<!-- 使用BootCDN -->
<script src="https://cdn.bootcdn.net/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>

<!-- 使用UNPKG -->
<script src="https://unpkg.com/chart.js@4.4.0/dist/chart.umd.min.js"></script>
```

#### 2. 本地化资源

下载CDN文件到本地：

```bash
# 创建本地资源目录
mkdir -p assets/js assets/css

# 下载Chart.js
wget https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js -O assets/js/chart.min.js

# 下载jsPDF
wget https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js -O assets/js/jspdf.min.js
```

修改HTML引用：
```html
<script src="assets/js/chart.min.js"></script>
<script src="assets/js/jspdf.min.js"></script>
```

#### 3. 启用浏览器缓存

在 `.htaccess` 中添加：

```apache
<FilesMatch "\.(js|json)$">
    Header set Cache-Control "max-age=2592000, public"
</FilesMatch>
```

#### 4. 压缩文件

```bash
# 压缩JavaScript
npm install -g terser
terser script.js -c -m -o script.min.js

# 压缩JSON
npm install -g json-minify
json-minify data.json > data.min.json
```

---

### 🔒 安全建议

#### 1. 输入验证

在 `script.js` 中添加严格验证：

```javascript
validateForm() {
    const population = parseFloat(document.getElementById('population').value);

    // 防止异常值
    if (population < 0 || population > 100000) {
        alert('人口数据异常');
        return false;
    }

    return true;
}
```

#### 2. XSS防护

确保所有用户输入都经过清理：

```javascript
function sanitizeInput(input) {
    const div = document.createElement('div');
    div.textContent = input;
    return div.innerHTML;
}
```

#### 3. HTTPS强制

```apache
# .htaccess
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

---

### 📱 移动端优化

#### 1. 响应式测试

测试以下设备：
- iPhone SE (375x667)
- iPhone 12 Pro (390x844)
- iPad (768x1024)
- Android (360x640)

#### 2. 触摸优化

```css
/* 增大点击区域 */
.btn-primary, .btn-secondary {
    min-height: 44px;
    padding: 12px 24px;
}

/* 移除点击高亮 */
* {
    -webkit-tap-highlight-color: transparent;
}
```

#### 3. 字体大小

```css
/* 确保最小字体16px，防止iOS自动缩放 */
input, select {
    font-size: 16px;
}
```

---

### 📈 SEO优化

#### 1. Meta标签

在 `index.html` 添加：

```html
<meta name="description" content="全球共享充电宝市场容量预估工具 - 基于城市人口、经济与场景的智能预估系统">
<meta name="keywords" content="共享充电宝,市场预估,容量计算,power bank,market estimator">

<!-- Open Graph -->
<meta property="og:title" content="全球共享充电宝市场容量预估工具">
<meta property="og:description" content="基于城市人口、经济与场景的智能预估系统">
<meta property="og:image" content="https://yoursite.com/preview.jpg">
<meta property="og:url" content="https://yoursite.com/calculator">

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="全球共享充电宝市场容量预估工具">
<meta name="twitter:description" content="基于城市人口、经济与场景的智能预估系统">
```

#### 2. 结构化数据

```html
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "SoftwareApplication",
  "name": "全球共享充电宝市场容量预估工具",
  "applicationCategory": "BusinessApplication",
  "offers": {
    "@type": "Offer",
    "price": "0",
    "priceCurrency": "USD"
  }
}
</script>
```

---

### 🌐 多语言部署

#### 添加新语言

1. 在 `script.js` 的 `translations` 对象中添加：

```javascript
'ja-JP': {
    title: 'グローバルモバイルバッテリー市場推定ツール',
    subtitle: '人口、経済、シナリオに基づくAI予測',
    // ... 更多翻译
}
```

2. 更新语言切换按钮：

```html
<button class="lang-btn" data-lang="ja-JP">日本語</button>
```

---

### ✅ 部署检查清单

部署前请确认：

- [ ] 所有文件已上传到正确位置
- [ ] 文件路径在代码中正确引用
- [ ] CDN链接可正常访问
- [ ] 在不同浏览器测试通过
- [ ] 移动端显示正常
- [ ] 计算功能正常工作
- [ ] 导出功能（PDF/Excel）正常
- [ ] 语言切换功能正常
- [ ] 参考城市数据正确加载
- [ ] 无控制台错误
- [ ] HTTPS正常工作
- [ ] 页面加载速度 < 3秒

---

### 📞 获取帮助

遇到问题？

1. 查看 [常见问题](README.md#常见问题)
2. 检查浏览器控制台错误
3. 提交 [GitHub Issue](https://github.com/yourusername/powerbank-estimator/issues)
4. 发送邮件至 support@example.com

---

## English Version

### 📦 Pre-deployment Checklist

#### 1. File Inventory
Ensure you have:
- `index.html` - Standalone webpage
- `embed.html` - WordPress embed version
- `script.js` - Core JavaScript
- `data.json` - Configuration data
- `wordpress-integration.php` - WordPress integration example (optional)

#### 2. Server Requirements
- **Standalone**: Any web server supporting static HTML
- **WordPress**: WordPress 5.0+ (6.0+ recommended)
- **Browsers**: Chrome 90+, Firefox 88+, Safari 14+, Edge 90+

---

### 🚀 Method 1: Standalone Website Deployment

#### Option A: Static Hosting Services

**For**: Netlify, Vercel, GitHub Pages, Cloudflare Pages

1. **Upload Files**
   ```bash
   mkdir powerbank-estimator
   cd powerbank-estimator
   # Copy all files
   ```

2. **Configure Deployment**
   - **Netlify**: Drag & drop to netlify.com/drop
   - **Vercel**: `vercel --prod`
   - **GitHub Pages**: Push to `gh-pages` branch
   - **Cloudflare Pages**: Connect Git repository

3. **Custom Domain** (Optional)
   - Add custom domain in hosting service
   - Configure DNS CNAME record

#### Option B: Traditional Web Server

**For**: Apache, Nginx, IIS

1. **Upload to Server**
   ```bash
   /var/www/html/powerbank-estimator/
   ```

2. **Server Configuration**

   **Apache (.htaccess)**
   ```apache
   RewriteEngine On
   RewriteCond %{HTTPS} off
   RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
   ```

   **Nginx (nginx.conf)**
   ```nginx
   location /powerbank-estimator {
       gzip on;
       gzip_types text/css application/javascript;
   }
   ```

---

### 🔌 Method 2: WordPress Integration

See Chinese version for detailed WordPress integration steps.

---

**For more details, refer to the Chinese version above or contact support.**
