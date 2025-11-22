<?php
/**
 * Global Powerbank Estimator - WordPress Integration (English Version)
 *
 * Add this code to your WordPress theme's functions.php file
 * 将此代码添加到您的WordPress主题的 functions.php 文件中
 *
 * @version 1.0.0
 */

// ================================
// English Version Shortcode / 英文版本短代码
// ================================

function powerbank_calculator_en_shortcode() {
    // Load required CDN resources
    wp_enqueue_script('tailwind-css', 'https://cdn.tailwindcss.com', array(), null, false);
    wp_enqueue_script('chartjs', 'https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js', array(), '4.4.0', true);
    wp_enqueue_script('jspdf', 'https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js', array(), '2.5.1', true);

    // Load local JavaScript
    wp_enqueue_script(
        'powerbank-calculator-script',
        get_template_directory_uri() . '/powerbank-calculator/script.js',
        array('chartjs'),
        '1.0.0',
        true
    );

    // Load English HTML content
    ob_start();
    $file_path = get_template_directory() . '/powerbank-calculator/embed-en.html';

    if (file_exists($file_path)) {
        include($file_path);
    } else {
        echo '<div style="padding: 20px; background: #fee; border: 1px solid #f00; border-radius: 5px;">';
        echo '<strong>Error:</strong> Calculator file not found. Please ensure files are uploaded to: ' . $file_path;
        echo '</div>';
    }

    return ob_get_clean();
}

// Register English shortcode
add_shortcode('powerbank_calculator_en', 'powerbank_calculator_en_shortcode');

// Usage / 使用方法:
// English version: [powerbank_calculator_en]
// 英文版本: [powerbank_calculator_en]


// ================================
// Bilingual Support / 双语支持
// ================================

/**
 * Auto-detect language based on browser or URL parameter
 * 根据浏览器或URL参数自动检测语言
 */
function powerbank_calculator_auto_shortcode() {
    // Check URL parameter
    $lang = isset($_GET['lang']) ? sanitize_text_field($_GET['lang']) : '';

    // Check browser language if no URL parameter
    if (empty($lang)) {
        $browser_lang = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) : 'en';
        $lang = ($browser_lang === 'zh') ? 'zh' : 'en';
    }

    // Load appropriate version
    if (strpos($lang, 'zh') !== false) {
        return powerbank_calculator_shortcode(); // Chinese version
    } else {
        return powerbank_calculator_en_shortcode(); // English version
    }
}

// Register auto-detect shortcode
add_shortcode('powerbank_calculator_auto', 'powerbank_calculator_auto_shortcode');

// Usage / 使用方法:
// Auto-detect language: [powerbank_calculator_auto]
// 自动检测语言: [powerbank_calculator_auto]
// URL with lang parameter: yoursite.com/page/?lang=en or ?lang=zh


// ================================
// Helper Functions / 辅助功能
// ================================

/**
 * Add language switcher to page
 * 在页面添加语言切换器
 */
function powerbank_calculator_language_switcher() {
    $current_url = home_url($_SERVER['REQUEST_URI']);
    $current_lang = isset($_GET['lang']) ? $_GET['lang'] : 'auto';

    echo '<div style="text-align: right; margin-bottom: 20px;">';
    echo '<span style="margin-right: 10px;">Language / 语言:</span>';

    // English link
    $en_url = add_query_arg('lang', 'en', remove_query_arg('lang', $current_url));
    $en_class = ($current_lang === 'en') ? 'current' : '';
    echo '<a href="' . esc_url($en_url) . '" class="' . $en_class . '" style="margin-right: 10px; padding: 5px 10px; border: 1px solid #ccc; border-radius: 4px; text-decoration: none;">English</a>';

    // Chinese link
    $zh_url = add_query_arg('lang', 'zh', remove_query_arg('lang', $current_url));
    $zh_class = ($current_lang === 'zh') ? 'current' : '';
    echo '<a href="' . esc_url($zh_url) . '" class="' . $zh_class . '" style="padding: 5px 10px; border: 1px solid #ccc; border-radius: 4px; text-decoration: none;">中文</a>';

    echo '</div>';
}

// Add to page template if needed
// add_action('wp_head', 'powerbank_calculator_language_switcher');


// ================================
// SEO & Meta Tags / SEO和Meta标签
// ================================

/**
 * Add language-specific meta tags
 * 添加语言特定的meta标签
 */
function powerbank_calculator_meta_tags() {
    if (has_shortcode(get_post()->post_content, 'powerbank_calculator_en') ||
        has_shortcode(get_post()->post_content, 'powerbank_calculator_auto')) {

        $lang = isset($_GET['lang']) ? $_GET['lang'] : 'en';

        if (strpos($lang, 'en') !== false) {
            // English meta tags
            echo '<meta name="description" content="Global Power Bank Market Estimator - AI-powered estimation based on population, economy & scenarios">' . "\n";
            echo '<meta name="keywords" content="power bank, market estimator, capacity calculator, sharing economy">' . "\n";
            echo '<meta property="og:title" content="Global Power Bank Market Estimator">' . "\n";
            echo '<meta property="og:description" content="AI-powered estimation based on population, economy & scenarios">' . "\n";
        } else {
            // Chinese meta tags
            echo '<meta name="description" content="全球共享充电宝市场容量预估工具 - 基于城市人口、经济与场景的智能预估系统">' . "\n";
            echo '<meta name="keywords" content="共享充电宝,市场预估,容量计算">' . "\n";
            echo '<meta property="og:title" content="全球共享充电宝市场容量预估工具">' . "\n";
            echo '<meta property="og:description" content="基于城市人口、经济与场景的智能预估系统">' . "\n";
        }
    }
}
add_action('wp_head', 'powerbank_calculator_meta_tags');


// ================================
// Admin Notice / 管理员通知
// ================================

/**
 * Show admin notice with instructions
 * 显示管理员通知和使用说明
 */
function powerbank_calculator_admin_notice() {
    $screen = get_current_screen();

    if ($screen->id === 'dashboard' || $screen->id === 'page') {
        ?>
        <div class="notice notice-info is-dismissible">
            <h3>🌐 Power Bank Market Estimator - Bilingual Support</h3>
            <p><strong>Available Shortcodes / 可用短代码:</strong></p>
            <ul style="list-style: disc; margin-left: 20px;">
                <li><code>[powerbank_calculator]</code> - Chinese version (中文版)</li>
                <li><code>[powerbank_calculator_en]</code> - English version (英文版)</li>
                <li><code>[powerbank_calculator_auto]</code> - Auto-detect language (自动检测语言)</li>
            </ul>
            <p><strong>File Requirements / 文件要求:</strong></p>
            <ul style="list-style: disc; margin-left: 20px;">
                <li>Upload <code>embed.html</code> to <code>/wp-content/themes/your-theme/powerbank-calculator/</code></li>
                <li>Upload <code>embed-en.html</code> to <code>/wp-content/themes/your-theme/powerbank-calculator/</code></li>
                <li>Upload <code>script.js</code> and <code>data.json</code> to the same folder</li>
            </ul>
        </div>
        <?php
    }
}
add_action('admin_notices', 'powerbank_calculator_admin_notice');


// ================================
// Conditional Loading / 条件加载
// ================================

/**
 * Load scripts only when shortcode is present
 * 仅在短代码存在时加载脚本
 */
function powerbank_calculator_conditional_scripts() {
    global $post;

    if (is_a($post, 'WP_Post')) {
        $has_calculator = has_shortcode($post->post_content, 'powerbank_calculator') ||
                         has_shortcode($post->post_content, 'powerbank_calculator_en') ||
                         has_shortcode($post->post_content, 'powerbank_calculator_auto');

        if ($has_calculator) {
            wp_enqueue_script('tailwind-css', 'https://cdn.tailwindcss.com');
            wp_enqueue_script('chartjs', 'https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js');
            wp_enqueue_script('jspdf', 'https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js');
        }
    }
}
add_action('wp_enqueue_scripts', 'powerbank_calculator_conditional_scripts');


// ================================
// URL Rewrite Rules / URL重写规则 (Optional / 可选)
// ================================

/**
 * Add custom URL structure for language switching
 * 添加自定义URL结构用于语言切换
 *
 * Example: yoursite.com/market-estimator/en/ or /zh/
 */
function powerbank_calculator_rewrite_rules() {
    add_rewrite_rule(
        '^market-estimator/(en|zh)/?',
        'index.php?pagename=market-estimator&lang=$matches[1]',
        'top'
    );
}
add_action('init', 'powerbank_calculator_rewrite_rules');

function powerbank_calculator_query_vars($vars) {
    $vars[] = 'lang';
    return $vars;
}
add_filter('query_vars', 'powerbank_calculator_query_vars');


// ================================
// Debugging / 调试
// ================================

if (defined('WP_DEBUG') && WP_DEBUG) {
    /**
     * Show debug information for admins
     * 为管理员显示调试信息
     */
    function powerbank_calculator_debug_info() {
        if (current_user_can('administrator')) {
            echo '<!-- Powerbank Calculator Debug Info -->' . "\n";
            echo '<!-- Theme Directory: ' . get_template_directory() . ' -->' . "\n";
            echo '<!-- Chinese File: ' . get_template_directory() . '/powerbank-calculator/embed.html -->' . "\n";
            echo '<!-- English File: ' . get_template_directory() . '/powerbank-calculator/embed-en.html -->' . "\n";
            echo '<!-- Script: ' . get_template_directory_uri() . '/powerbank-calculator/script.js -->' . "\n";
            echo '<!-- Data: ' . get_template_directory_uri() . '/powerbank-calculator/data.json -->' . "\n";

            // Check file existence
            $files = [
                'embed.html' => file_exists(get_template_directory() . '/powerbank-calculator/embed.html'),
                'embed-en.html' => file_exists(get_template_directory() . '/powerbank-calculator/embed-en.html'),
                'script.js' => file_exists(get_template_directory() . '/powerbank-calculator/script.js'),
                'data.json' => file_exists(get_template_directory() . '/powerbank-calculator/data.json')
            ];

            foreach ($files as $file => $exists) {
                $status = $exists ? '✓ EXISTS' : '✗ MISSING';
                echo "<!-- File Status: $file = $status -->\n";
            }
        }
    }
    add_action('wp_footer', 'powerbank_calculator_debug_info');
}

?>
