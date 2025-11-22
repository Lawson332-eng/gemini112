# WordPress 部署完整指南

## 📋 准备工作

您需要：
- WordPress管理员权限
- FTP/SFTP访问权限 或 文件管理器访问权限

---

## 🚀 方法一：使用短代码（推荐，最简单）

### 步骤1: 上传文件

#### 选项A: 通过FTP/SFTP上传（推荐）

1. 使用FileZilla或其他FTP工具连接到您的服务器

2. 导航到您的主题目录：
   ```
   /wp-content/themes/你的主题名称/
   ```

3. 创建新文件夹 `powerbank-calculator`

4. 上传以下3个文件到该文件夹：
   - `embed.html`
   - `script.js`
   - `data.json`

5. 最终路径应该是：
   ```
   /wp-content/themes/你的主题名称/powerbank-calculator/
   ├── embed.html
   ├── script.js
   └── data.json
   ```

#### 选项B: 通过WordPress文件管理器

1. 登录WordPress管理后台

2. 安装插件 "File Manager" (如果没有的话)

3. 进入 **文件管理器** > **wp-content** > **themes** > **你的主题文件夹**

4. 创建新文件夹 `powerbank-calculator`

5. 将3个文件上传到该文件夹

#### 选项C: 通过cPanel文件管理器

1. 登录cPanel

2. 打开 **文件管理器**

3. 导航到：
   ```
   public_html/wp-content/themes/你的主题名称/
   ```

4. 创建文件夹 `powerbank-calculator`

5. 上传文件

---

### 步骤2: 添加短代码到WordPress

#### 方式A: 通过WordPress编辑器（推荐）

1. 进入 **外观** > **主题文件编辑器**

2. ⚠️ **警告**: 在右侧选择 **主题函数 (functions.php)**
   - 建议先备份此文件！

3. 滚动到文件末尾，在 `?>` 之前（如果有）或最后添加以下代码：

```php
<?php
/**
 * 全球共享充电宝市场容量预估工具
 * Global Powerbank Market Estimator
 */
function powerbank_calculator_shortcode() {
    // 加载必要的CSS和JS库
    wp_enqueue_script('tailwind-css', 'https://cdn.tailwindcss.com', array(), null, false);
    wp_enqueue_script('chartjs', 'https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js', array(), '4.4.0', true);
    wp_enqueue_script('jspdf', 'https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js', array(), '2.5.1', true);

    // 加载本地JavaScript文件
    wp_enqueue_script(
        'powerbank-calculator-script',
        get_template_directory_uri() . '/powerbank-calculator/script.js',
        array('chartjs'),
        '1.0.0',
        true
    );

    // 获取并返回HTML内容
    ob_start();
    $file_path = get_template_directory() . '/powerbank-calculator/embed.html';

    if (file_exists($file_path)) {
        include($file_path);
    } else {
        echo '<div style="padding: 20px; background: #fee; border: 1px solid #f00; border-radius: 5px;">';
        echo '<strong>错误:</strong> 找不到计算器文件。请确认文件已正确上传到: ' . $file_path;
        echo '</div>';
    }

    return ob_get_clean();
}

// 注册短代码
add_shortcode('powerbank_calculator', 'powerbank_calculator_shortcode');
?>
```

4. 点击 **更新文件** 保存

#### 方式B: 通过FTP编辑（更安全）

1. 下载 `functions.php` 到本地

2. 用文本编辑器打开，添加上面的代码

3. 保存并上传回服务器

---

### 步骤3: 创建工具页面

1. 进入 **页面** > **新建页面**

2. 输入页面标题：
   ```
   共享充电宝市场容量预估工具
   ```
   或
   ```
   Power Bank Market Estimator
   ```

3. 在内容编辑器中，根据您使用的编辑器：

   #### 如果使用经典编辑器：
   - 切换到 **文本** 模式
   - 输入短代码：
   ```
   [powerbank_calculator]
   ```

   #### 如果使用古腾堡编辑器：
   - 点击 **+** 添加块
   - 搜索并选择 **短代码** 块
   - 输入：
   ```
   [powerbank_calculator]
   ```

   #### 如果使用Elementor：
   - 添加 **短代码** 小部件
   - 在短代码字段中输入：
   ```
   [powerbank_calculator]
   ```

4. （可选）设置页面属性：
   - **模板**: 选择全宽模板（如果有）
   - **特色图片**: 上传相关图片

5. 点击 **发布**

---

### 步骤4: 测试

1. 点击 **查看页面**

2. 检查以下功能：
   - ✅ 页面正常显示
   - ✅ 可以选择参考城市
   - ✅ 可以输入数据
   - ✅ 步骤导航正常
   - ✅ 计算功能正常
   - ✅ 图表正常显示
   - ✅ 语言切换正常
   - ✅ 导出功能正常

3. 如果有问题，查看[故障排除](#故障排除)部分

---

## 🎨 方法二：使用页面模板（适合高级用户）

### 步骤1: 创建页面模板文件

1. 在主题目录创建文件 `page-powerbank-calculator.php`

2. 添加以下内容：

```php
<?php
/**
 * Template Name: 充电宝市场预估工具
 * Description: Power Bank Market Estimator Page Template
 */

get_header();
?>

<style>
/* 全宽显示 */
.powerbank-calculator-page {
    width: 100%;
    max-width: 1400px;
    margin: 0 auto;
    padding: 20px;
}

/* 隐藏侧边栏 */
.sidebar {
    display: none;
}

/* 内容区域全宽 */
.content-area {
    width: 100%;
    float: none;
}
</style>

<div class="powerbank-calculator-page">
    <?php
    // 加载计算器
    echo do_shortcode('[powerbank_calculator]');
    ?>
</div>

<?php
get_footer();
?>
```

### 步骤2: 创建页面并选择模板

1. 创建新页面

2. 在右侧 **页面属性** 中选择模板：
   - 模板: **充电宝市场预估工具**

3. 标题可以留空或输入描述

4. 发布

---

## 🔧 方法三：使用插件（最简单，适合新手）

### 步骤1: 创建自定义插件

1. 在 `/wp-content/plugins/` 创建文件夹：
   ```
   powerbank-calculator-plugin
   ```

2. 在该文件夹创建文件 `powerbank-calculator.php`

3. 添加以下内容：

```php
<?php
/**
 * Plugin Name: 全球共享充电宝市场容量预估工具
 * Plugin URI: https://yoursite.com
 * Description: Global Power Bank Market Estimator Tool
 * Version: 1.0.0
 * Author: Your Name
 * License: MIT
 */

// 防止直接访问
if (!defined('ABSPATH')) {
    exit;
}

// 定义插件路径
define('POWERBANK_CALC_PATH', plugin_dir_path(__FILE__));
define('POWERBANK_CALC_URL', plugin_dir_url(__FILE__));

// 短代码函数
function powerbank_calculator_shortcode() {
    wp_enqueue_script('tailwind-css', 'https://cdn.tailwindcss.com');
    wp_enqueue_script('chartjs', 'https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js');
    wp_enqueue_script('jspdf', 'https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js');

    wp_enqueue_script(
        'powerbank-calculator',
        POWERBANK_CALC_URL . 'assets/script.js',
        array('chartjs'),
        '1.0.0',
        true
    );

    ob_start();
    include(POWERBANK_CALC_PATH . 'assets/embed.html');
    return ob_get_clean();
}
add_shortcode('powerbank_calculator', 'powerbank_calculator_shortcode');

// 添加管理菜单
function powerbank_calculator_menu() {
    add_menu_page(
        '充电宝市场预估',
        '市场预估工具',
        'manage_options',
        'powerbank-calculator',
        'powerbank_calculator_admin_page',
        'dashicons-chart-area',
        30
    );
}
add_action('admin_menu', 'powerbank_calculator_menu');

function powerbank_calculator_admin_page() {
    ?>
    <div class="wrap">
        <h1>全球共享充电宝市场容量预估工具</h1>

        <div class="card" style="max-width: 800px; margin-top: 20px; padding: 20px;">
            <h2>📝 使用方法</h2>
            <ol>
                <li>在任何页面或文章中添加短代码: <code>[powerbank_calculator]</code></li>
                <li>或使用PHP代码: <code>&lt;?php echo do_shortcode('[powerbank_calculator]'); ?&gt;</code></li>
            </ol>

            <h2 style="margin-top: 30px;">📁 文件状态</h2>
            <?php
            $files = array(
                'embed.html' => POWERBANK_CALC_PATH . 'assets/embed.html',
                'script.js' => POWERBANK_CALC_PATH . 'assets/script.js',
                'data.json' => POWERBANK_CALC_PATH . 'assets/data.json'
            );

            foreach ($files as $name => $path) {
                $status = file_exists($path) ? '✅ 已上传' : '❌ 未找到';
                $color = file_exists($path) ? 'green' : 'red';
                echo "<p><strong>$name:</strong> <span style='color: $color;'>$status</span></p>";
            }
            ?>

            <h2 style="margin-top: 30px;">🔗 快速操作</h2>
            <p>
                <a href="<?php echo admin_url('post-new.php?post_type=page'); ?>" class="button button-primary">
                    创建新页面
                </a>
            </p>
        </div>
    </div>
    <?php
}
?>
```

4. 在插件文件夹创建 `assets` 子文件夹

5. 将以下文件复制到 `assets` 文件夹：
   - `embed.html`
   - `script.js`
   - `data.json`

6. 文件结构：
   ```
   /wp-content/plugins/powerbank-calculator-plugin/
   ├── powerbank-calculator.php
   └── assets/
       ├── embed.html
       ├── script.js
       └── data.json
   ```

### 步骤2: 激活插件

1. 进入 **插件** > **已安装的插件**

2. 找到 "全球共享充电宝市场容量预估工具"

3. 点击 **启用**

4. 在左侧菜单会出现 **市场预估工具** 菜单项

### 步骤3: 创建页面

同方法一的步骤3

---

## ⚠️ 故障排除

### 问题1: 页面显示 "找不到计算器文件"

**解决方案:**

1. 检查文件路径是否正确
   ```php
   // 在functions.php中添加调试代码
   echo get_template_directory() . '/powerbank-calculator/embed.html';
   ```

2. 确认文件已上传到正确位置

3. 检查文件权限（应该是644）
   ```bash
   chmod 644 embed.html script.js data.json
   chmod 755 powerbank-calculator/
   ```

### 问题2: 页面空白或样式错误

**解决方案:**

1. 清除WordPress缓存（如果使用缓存插件）

2. 检查浏览器控制台错误（F12 > Console）

3. 确认CDN链接可访问：
   - https://cdn.tailwindcss.com
   - https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js

4. 尝试添加到 `functions.php`：
   ```php
   // 禁用主题样式对工具的影响
   add_action('wp_head', function() {
       if (is_page('your-page-slug')) {
           echo '<style>#powerbank-estimator-app * { all: revert; }</style>';
       }
   });
   ```

### 问题3: Chart.js图表不显示

**解决方案:**

1. 确认Chart.js CDN正常加载

2. 检查控制台是否有JavaScript错误

3. 尝试使用备用CDN：
   ```php
   wp_enqueue_script('chartjs', 'https://unpkg.com/chart.js@4.4.0/dist/chart.umd.min.js');
   ```

### 问题4: 数据无法加载

**解决方案:**

1. 确认 `data.json` 文件存在并可访问

2. 在浏览器中直接访问：
   ```
   https://yoursite.com/wp-content/themes/your-theme/powerbank-calculator/data.json
   ```

3. 检查JSON格式是否正确（使用JSONLint验证）

### 问题5: WordPress编辑器无法保存短代码

**解决方案:**

1. 切换到HTML/代码视图

2. 或使用"自定义HTML"块（古腾堡）

3. 或安装"Shortcode Block"插件

---

## 📱 移动端优化

确保在移动设备上显示良好：

```php
// 添加到functions.php
add_action('wp_head', function() {
    if (has_shortcode(get_post()->post_content, 'powerbank_calculator')) {
        ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <style>
        @media (max-width: 768px) {
            .powerbank-calculator-page {
                padding: 10px !important;
            }
        }
        </style>
        <?php
    }
});
```

---

## 🎯 推荐设置

### 1. 使用全宽页面模板

在页面编辑器右侧选择:
- **模板**: 全宽页面 / Full Width / Canvas

### 2. 隐藏页面标题

添加自定义CSS：
```css
.page-id-YOUR_PAGE_ID .entry-title {
    display: none;
}
```

### 3. 添加到菜单

1. **外观** > **菜单**
2. 添加您的工具页面到主导航菜单

---

## ✅ 验证清单

部署完成后检查：

- [ ] 文件已上传到正确位置
- [ ] 短代码已添加到functions.php
- [ ] 页面已创建并发布
- [ ] 页面可以正常访问
- [ ] 表单可以输入数据
- [ ] 步骤导航正常工作
- [ ] 计算功能正常
- [ ] 图表正常显示
- [ ] 语言切换正常
- [ ] 导出功能（PDF/Excel）正常
- [ ] 移动端显示正常
- [ ] 无JavaScript错误（F12检查）

---

## 📞 需要帮助？

如果遇到问题：

1. 检查浏览器控制台（F12 > Console）
2. 查看WordPress调试日志
3. 确认所有文件都已正确上传
4. 尝试禁用其他插件排除冲突

---

**部署完成后，您将拥有一个功能完整的市场容量预估工具页面！** 🎉
