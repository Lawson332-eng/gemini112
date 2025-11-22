<?php
/**
 * Global Powerbank Estimator - WordPress Integration
 *
 * 将此代码添加到您的WordPress主题的 functions.php 文件中
 * Add this code to your WordPress theme's functions.php file
 *
 * @version 1.0.0
 */

// ================================
// 方式1: 短代码集成 / Method 1: Shortcode Integration
// ================================

function powerbank_calculator_shortcode() {
    // 加载必要的CDN资源
    // Load required CDN resources
    wp_enqueue_script('tailwind-css', 'https://cdn.tailwindcss.com', array(), null, false);
    wp_enqueue_script('chartjs', 'https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js', array(), '4.4.0', true);
    wp_enqueue_script('jspdf', 'https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js', array(), '2.5.1', true);

    // 加载本地JavaScript
    // Load local JavaScript
    wp_enqueue_script(
        'powerbank-calculator',
        get_template_directory_uri() . '/powerbank-calculator/script.js',
        array(),
        '1.0.0',
        true
    );

    // 加载HTML内容
    // Load HTML content
    ob_start();
    include(get_template_directory() . '/powerbank-calculator/embed.html');
    return ob_get_clean();
}

// 注册短代码 / Register shortcode
add_shortcode('powerbank_calculator', 'powerbank_calculator_shortcode');

// 使用方法 / Usage:
// 在任何页面或文章中添加: [powerbank_calculator]
// Add to any page or post: [powerbank_calculator]


// ================================
// 方式2: 古腾堡区块 / Method 2: Gutenberg Block
// ================================

function powerbank_calculator_register_block() {
    if (!function_exists('register_block_type')) {
        return;
    }

    wp_register_script(
        'powerbank-calculator-block',
        get_template_directory_uri() . '/powerbank-calculator/script.js',
        array('wp-blocks', 'wp-element'),
        '1.0.0'
    );

    register_block_type('custom/powerbank-calculator', array(
        'editor_script' => 'powerbank-calculator-block',
        'render_callback' => 'powerbank_calculator_shortcode',
    ));
}
add_action('init', 'powerbank_calculator_register_block');


// ================================
// 方式3: 小工具 / Method 3: Widget
// ================================

class Powerbank_Calculator_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'powerbank_calculator_widget',
            '全球共享充电宝市场容量预估工具',
            array('description' => 'Display powerbank market estimator')
        );
    }

    public function widget($args, $instance) {
        echo $args['before_widget'];

        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }

        echo powerbank_calculator_shortcode();

        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : '市场容量预估';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">标题:</label>
            <input class="widefat"
                   id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>"
                   type="text"
                   value="<?php echo esc_attr($title); ?>">
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        return $instance;
    }
}

// 注册小工具 / Register widget
function powerbank_calculator_register_widgets() {
    register_widget('Powerbank_Calculator_Widget');
}
add_action('widgets_init', 'powerbank_calculator_register_widgets');


// ================================
// 方式4: REST API 端点 / Method 4: REST API Endpoint
// ================================

function powerbank_calculator_rest_api() {
    register_rest_route('powerbank/v1', '/calculate', array(
        'methods' => 'POST',
        'callback' => 'powerbank_calculator_api_callback',
        'permission_callback' => '__return_true',
    ));
}
add_action('rest_api_init', 'powerbank_calculator_rest_api');

function powerbank_calculator_api_callback($request) {
    $params = $request->get_json_params();

    // 这里可以添加服务器端验证和计算
    // Server-side validation and calculation can be added here

    return new WP_REST_Response(array(
        'success' => true,
        'data' => $params,
        'message' => 'Calculation completed'
    ), 200);
}


// ================================
// 辅助功能 / Helper Functions
// ================================

// 添加管理菜单 / Add admin menu
function powerbank_calculator_admin_menu() {
    add_menu_page(
        '充电宝市场预估工具',
        '市场预估工具',
        'manage_options',
        'powerbank-calculator',
        'powerbank_calculator_admin_page',
        'dashicons-chart-area',
        30
    );
}
add_action('admin_menu', 'powerbank_calculator_admin_menu');

function powerbank_calculator_admin_page() {
    ?>
    <div class="wrap">
        <h1>全球共享充电宝市场容量预估工具</h1>
        <div class="card">
            <h2>使用方法</h2>
            <p><strong>短代码:</strong> 在页面或文章中添加 <code>[powerbank_calculator]</code></p>
            <p><strong>PHP模板:</strong> 使用 <code>&lt;?php echo do_shortcode('[powerbank_calculator]'); ?&gt;</code></p>
            <p><strong>小工具:</strong> 在"外观 > 小工具"中添加"充电宝市场预估工具"</p>
        </div>

        <div class="card" style="margin-top: 20px;">
            <h2>文件位置</h2>
            <p>请确保以下文件已上传到:</p>
            <code><?php echo get_template_directory(); ?>/powerbank-calculator/</code>
            <ul>
                <li>embed.html</li>
                <li>script.js</li>
                <li>data.json</li>
            </ul>
        </div>

        <div class="card" style="margin-top: 20px;">
            <h2>预览</h2>
            <p><a href="<?php echo home_url('/?powerbank_preview=1'); ?>" target="_blank" class="button button-primary">在新窗口预览</a></p>
        </div>
    </div>
    <?php
}

// 预览功能 / Preview function
function powerbank_calculator_preview() {
    if (isset($_GET['powerbank_preview']) && $_GET['powerbank_preview'] == '1') {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>充电宝市场预估工具 - 预览</title>
        </head>
        <body>
            <?php echo powerbank_calculator_shortcode(); ?>
        </body>
        </html>
        <?php
        exit;
    }
}
add_action('template_redirect', 'powerbank_calculator_preview');


// ================================
// 样式和脚本优化 / Style and Script Optimization
// ================================

// 仅在需要时加载资源 / Load resources only when needed
function powerbank_calculator_conditional_scripts() {
    global $post;

    if (is_a($post, 'WP_Post') && has_shortcode($post->post_content, 'powerbank_calculator')) {
        wp_enqueue_script('tailwind-css', 'https://cdn.tailwindcss.com');
        wp_enqueue_script('chartjs', 'https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js');
        wp_enqueue_script('jspdf', 'https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js');
    }
}
add_action('wp_enqueue_scripts', 'powerbank_calculator_conditional_scripts');


// ================================
// 缓存支持 / Cache Support
// ================================

function powerbank_calculator_cache_bust() {
    // 获取文件修改时间作为版本号
    // Get file modification time as version number
    $script_path = get_template_directory() . '/powerbank-calculator/script.js';
    $version = file_exists($script_path) ? filemtime($script_path) : '1.0.0';
    return $version;
}


// ================================
// 安全加固 / Security Hardening
// ================================

// 添加nonce验证 / Add nonce verification
function powerbank_calculator_nonce_field() {
    wp_nonce_field('powerbank_calculator_action', 'powerbank_calculator_nonce');
}

function powerbank_calculator_verify_nonce() {
    if (isset($_POST['powerbank_calculator_nonce'])) {
        return wp_verify_nonce($_POST['powerbank_calculator_nonce'], 'powerbank_calculator_action');
    }
    return false;
}


// ================================
// 多站点支持 / Multisite Support
// ================================

function powerbank_calculator_multisite_activate() {
    if (is_multisite()) {
        global $wpdb;
        $blog_ids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");

        foreach ($blog_ids as $blog_id) {
            switch_to_blog($blog_id);
            powerbank_calculator_activate();
            restore_current_blog();
        }
    } else {
        powerbank_calculator_activate();
    }
}

function powerbank_calculator_activate() {
    // 激活时的操作
    // Actions on activation
    flush_rewrite_rules();
}

register_activation_hook(__FILE__, 'powerbank_calculator_multisite_activate');


// ================================
// 调试模式 / Debug Mode
// ================================

if (defined('WP_DEBUG') && WP_DEBUG) {
    function powerbank_calculator_debug_info() {
        if (current_user_can('administrator')) {
            echo '<!-- Powerbank Calculator Debug Info -->';
            echo '<!-- Theme Directory: ' . get_template_directory() . ' -->';
            echo '<!-- Script Path: ' . get_template_directory_uri() . '/powerbank-calculator/script.js -->';
            echo '<!-- Data Path: ' . get_template_directory_uri() . '/powerbank-calculator/data.json -->';
        }
    }
    add_action('wp_footer', 'powerbank_calculator_debug_info');
}

?>
