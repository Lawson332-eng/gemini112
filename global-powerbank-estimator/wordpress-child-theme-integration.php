<?php
/**
 * Global Powerbank Estimator - Child Theme Integration
 * 全球共享充电宝市场容量预估工具 - 子主题集成
 *
 * 将此代码添加到您的子主题的 functions.php 文件中
 * Add this code to your CHILD THEME's functions.php file
 *
 * ⚠️ 重要：请确保文件上传到子主题目录，不是父主题！
 * ⚠️ Important: Upload files to CHILD THEME directory, not parent theme!
 *
 * 文件位置 / File Location:
 * /wp-content/themes/YOUR-CHILD-THEME/powerbank-calculator/
 * ├── embed.html
 * ├── embed-en.html
 * ├── script.js
 * └── data.json
 *
 * @version 1.0.0
 */

// ================================
// 中文版本短代码 / Chinese Version
// ================================

function powerbank_calculator_shortcode() {
    // 加载必要的CSS和JS库
    wp_enqueue_script('tailwind-css', 'https://cdn.tailwindcss.com', array(), null, false);
    wp_enqueue_script('chartjs', 'https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js', array(), '4.4.0', true);
    wp_enqueue_script('jspdf', 'https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js', array(), '2.5.1', true);

    // ✅ 使用 get_stylesheet_directory_uri() 指向子主题
    // Use get_stylesheet_directory_uri() for child theme
    wp_enqueue_script(
        'powerbank-calculator-script',
        get_stylesheet_directory_uri() . '/powerbank-calculator/script.js',
        array('chartjs'),
        '1.0.0',
        true
    );

    // ✅ 使用 get_stylesheet_directory() 指向子主题
    // Use get_stylesheet_directory() for child theme
    ob_start();
    $file_path = get_stylesheet_directory() . '/powerbank-calculator/embed.html';

    if (file_exists($file_path)) {
        include($file_path);
    } else {
        echo '<div style="padding: 20px; background: #fee; border: 1px solid #f00; border-radius: 5px;">';
        echo '<strong>错误 / Error:</strong> 找不到计算器文件 / Calculator file not found.<br>';
        echo '请确认文件已上传到子主题目录 / Please ensure files are uploaded to child theme directory:<br>';
        echo '<code>' . $file_path . '</code>';
        echo '</div>';
    }

    return ob_get_clean();
}

// 注册中文版短代码
add_shortcode('powerbank_calculator', 'powerbank_calculator_shortcode');

// 使用方法 / Usage: [powerbank_calculator]


// ================================
// 英文版本短代码 / English Version
// ================================

function powerbank_calculator_en_shortcode() {
    wp_enqueue_script('tailwind-css', 'https://cdn.tailwindcss.com', array(), null, false);
    wp_enqueue_script('chartjs', 'https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js', array(), '4.4.0', true);
    wp_enqueue_script('jspdf', 'https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js', array(), '2.5.1', true);

    // ✅ 子主题路径
    wp_enqueue_script(
        'powerbank-calculator-script',
        get_stylesheet_directory_uri() . '/powerbank-calculator/script.js',
        array('chartjs'),
        '1.0.0',
        true
    );

    // ✅ 子主题路径
    ob_start();
    $file_path = get_stylesheet_directory() . '/powerbank-calculator/embed-en.html';

    if (file_exists($file_path)) {
        include($file_path);
    } else {
        echo '<div style="padding: 20px; background: #fee; border: 1px solid #f00; border-radius: 5px;">';
        echo '<strong>Error:</strong> English calculator file not found.<br>';
        echo 'Please ensure files are uploaded to child theme directory:<br>';
        echo '<code>' . $file_path . '</code>';
        echo '</div>';
    }

    return ob_get_clean();
}

// 注册英文版短代码
add_shortcode('powerbank_calculator_en', 'powerbank_calculator_en_shortcode');

// 使用方法 / Usage: [powerbank_calculator_en]


// ================================
// 自动检测语言版本 / Auto Language Detection
// ================================

function powerbank_calculator_auto_shortcode() {
    // 检查URL参数
    $lang = isset($_GET['lang']) ? sanitize_text_field($_GET['lang']) : '';

    // 如果没有URL参数，检查浏览器语言
    if (empty($lang)) {
        $browser_lang = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) : 'en';
        $lang = ($browser_lang === 'zh') ? 'zh' : 'en';
    }

    // 加载必要的脚本
    wp_enqueue_script('tailwind-css', 'https://cdn.tailwindcss.com');
    wp_enqueue_script('chartjs', 'https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js');
    wp_enqueue_script('jspdf', 'https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js');
    wp_enqueue_script(
        'powerbank-calculator-script',
        get_stylesheet_directory_uri() . '/powerbank-calculator/script.js',
        array('chartjs'),
        '1.0.0',
        true
    );

    // 根据语言加载对应版本
    ob_start();

    if (strpos($lang, 'zh') !== false) {
        // 中文版本
        $file_path = get_stylesheet_directory() . '/powerbank-calculator/embed.html';
    } else {
        // 英文版本
        $file_path = get_stylesheet_directory() . '/powerbank-calculator/embed-en.html';
    }

    if (file_exists($file_path)) {
        include($file_path);
    } else {
        echo '<div style="padding: 20px; background: #fee; border: 1px solid #f00;">';
        echo '<strong>Error:</strong> Calculator file not found: <code>' . $file_path . '</code>';
        echo '</div>';
    }

    return ob_get_clean();
}

// 注册自动检测短代码
add_shortcode('powerbank_calculator_auto', 'powerbank_calculator_auto_shortcode');

// 使用方法 / Usage: [powerbank_calculator_auto]


// ================================
// 调试信息 / Debug Information
// ================================

// 仅在调试模式下显示信息
if (defined('WP_DEBUG') && WP_DEBUG && current_user_can('administrator')) {

    function powerbank_calculator_debug_info() {
        echo '<!-- Powerbank Calculator - Child Theme Integration Debug -->' . "\n";
        echo '<!-- Child Theme Directory: ' . get_stylesheet_directory() . ' -->' . "\n";
        echo '<!-- Parent Theme Directory: ' . get_template_directory() . ' -->' . "\n";
        echo '<!-- Chinese File: ' . get_stylesheet_directory() . '/powerbank-calculator/embed.html -->' . "\n";
        echo '<!-- English File: ' . get_stylesheet_directory() . '/powerbank-calculator/embed-en.html -->' . "\n";

        // 检查文件是否存在
        $files = [
            'embed.html' => get_stylesheet_directory() . '/powerbank-calculator/embed.html',
            'embed-en.html' => get_stylesheet_directory() . '/powerbank-calculator/embed-en.html',
            'script.js' => get_stylesheet_directory() . '/powerbank-calculator/script.js',
            'data.json' => get_stylesheet_directory() . '/powerbank-calculator/data.json'
        ];

        foreach ($files as $name => $path) {
            $exists = file_exists($path) ? '✓ EXISTS' : '✗ MISSING';
            echo "<!-- File Check: $name = $exists -->\n";
        }
    }

    add_action('wp_footer', 'powerbank_calculator_debug_info');
}


// ================================
// 管理员通知 / Admin Notice
// ================================

function powerbank_calculator_child_theme_notice() {
    $screen = get_current_screen();

    // 只在仪表板和页面编辑器显示
    if ($screen && in_array($screen->id, ['dashboard', 'page'])) {

        // 检查是否是子主题
        $is_child_theme = (get_template_directory() !== get_stylesheet_directory());

        ?>
        <div class="notice notice-info is-dismissible">
            <h3>🌐 充电宝市场预估工具 / Power Bank Market Estimator</h3>

            <?php if ($is_child_theme): ?>
                <p style="color: green;">✅ <strong>已检测到子主题 / Child theme detected</strong></p>
                <p>子主题名称 / Child Theme: <code><?php echo wp_get_theme()->get('Name'); ?></code></p>
                <p>父主题名称 / Parent Theme: <code><?php echo wp_get_theme()->get('Template'); ?></code></p>
            <?php else: ?>
                <p style="color: orange;">⚠️ <strong>未使用子主题 / Not using child theme</strong></p>
                <p>建议创建子主题以保护自定义内容 / Recommend creating a child theme</p>
            <?php endif; ?>

            <hr>

            <p><strong>可用短代码 / Available Shortcodes:</strong></p>
            <ul style="list-style: disc; margin-left: 20px;">
                <li><code>[powerbank_calculator]</code> - 中文版 / Chinese Version</li>
                <li><code>[powerbank_calculator_en]</code> - 英文版 / English Version</li>
                <li><code>[powerbank_calculator_auto]</code> - 自动检测 / Auto-detect Language</li>
            </ul>

            <p><strong>文件位置 / File Location:</strong></p>
            <code><?php echo get_stylesheet_directory(); ?>/powerbank-calculator/</code>

            <hr>

            <p><strong>文件状态 / File Status:</strong></p>
            <?php
            $files = [
                'embed.html' => get_stylesheet_directory() . '/powerbank-calculator/embed.html',
                'embed-en.html' => get_stylesheet_directory() . '/powerbank-calculator/embed-en.html',
                'script.js' => get_stylesheet_directory() . '/powerbank-calculator/script.js',
                'data.json' => get_stylesheet_directory() . '/powerbank-calculator/data.json'
            ];

            echo '<ul style="list-style: none; margin-left: 20px;">';
            foreach ($files as $name => $path) {
                $exists = file_exists($path);
                $icon = $exists ? '✅' : '❌';
                $color = $exists ? 'green' : 'red';
                echo "<li style='color: $color;'>$icon <code>$name</code></li>";
            }
            echo '</ul>';
            ?>
        </div>
        <?php
    }
}

add_action('admin_notices', 'powerbank_calculator_child_theme_notice');


// ================================
// 条件加载脚本 / Conditional Script Loading
// ================================

function powerbank_calculator_conditional_scripts() {
    global $post;

    if (is_a($post, 'WP_Post')) {
        $has_calculator = has_shortcode($post->post_content, 'powerbank_calculator') ||
                         has_shortcode($post->post_content, 'powerbank_calculator_en') ||
                         has_shortcode($post->post_content, 'powerbank_calculator_auto');

        if ($has_calculator) {
            // 仅在需要时加载脚本
            wp_enqueue_script('tailwind-css', 'https://cdn.tailwindcss.com');
            wp_enqueue_script('chartjs', 'https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js');
            wp_enqueue_script('jspdf', 'https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js');
        }
    }
}

add_action('wp_enqueue_scripts', 'powerbank_calculator_conditional_scripts');

?>
