<?php
/**
 * Plugin Name: Powerbank ROI Calculator
 * Plugin URI: https://github.com/yourusername/powerbank-roi-calculator
 * Description: 专业的共享充电宝投资回报率(ROI)计算器，支持短代码和Gutenberg块编辑器
 * Version: 1.0.0
 * Author: Your Name
 * Author URI: https://yourdomain.com
 * License: MIT
 * Text Domain: powerbank-roi-calculator
 * Domain Path: /languages
 */

// 防止直接访问
if (!defined('ABSPATH')) {
    exit;
}

// 定义插件常量
define('PBRC_VERSION', '1.0.0');
define('PBRC_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('PBRC_PLUGIN_URL', plugin_dir_url(__FILE__));
define('PBRC_PLUGIN_BASENAME', plugin_basename(__FILE__));

/**
 * 主插件类
 */
class Powerbank_ROI_Calculator {

    private static $instance = null;

    /**
     * 单例模式
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * 构造函数
     */
    private function __construct() {
        // 加载文本域
        add_action('plugins_loaded', array($this, 'load_textdomain'));

        // 注册短代码
        add_shortcode('roi_calculator', array($this, 'render_calculator'));
        add_shortcode('powerbank_roi', array($this, 'render_calculator')); // 别名

        // 注册Gutenberg块
        add_action('init', array($this, 'register_block'));

        // 加载资源
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));

        // 添加设置页面
        add_action('admin_menu', array($this, 'add_settings_page'));
        add_action('admin_init', array($this, 'register_settings'));

        // 添加插件操作链接
        add_filter('plugin_action_links_' . PBRC_PLUGIN_BASENAME, array($this, 'add_action_links'));
    }

    /**
     * 加载文本域
     */
    public function load_textdomain() {
        load_plugin_textdomain(
            'powerbank-roi-calculator',
            false,
            dirname(PBRC_PLUGIN_BASENAME) . '/languages'
        );
    }

    /**
     * 注册和加载资源
     */
    public function enqueue_scripts() {
        // 只在包含短代码的页面加载
        global $post;
        if (is_a($post, 'WP_Post') && (has_shortcode($post->post_content, 'roi_calculator') || has_shortcode($post->post_content, 'powerbank_roi'))) {

            // 加载Tailwind CSS
            wp_enqueue_script('pbrc-tailwind', 'https://cdn.tailwindcss.com', array(), null, false);

            // 加载React
            wp_enqueue_script('pbrc-react', 'https://unpkg.com/react@18/umd/react.production.min.js', array(), '18.0.0', false);
            wp_enqueue_script('pbrc-react-dom', 'https://unpkg.com/react-dom@18/umd/react-dom.production.min.js', array('pbrc-react'), '18.0.0', false);

            // 加载Babel
            wp_enqueue_script('pbrc-babel', 'https://unpkg.com/@babel/standalone/babel.min.js', array(), null, false);

            // 加载Chart.js
            wp_enqueue_script('pbrc-chartjs', 'https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js', array(), '4.4.0', false);

            // 加载SheetJS
            wp_enqueue_script('pbrc-xlsx', 'https://cdn.sheetjs.com/xlsx-0.20.0/package/dist/xlsx.full.min.js', array(), '0.20.0', false);

            // 加载自定义样式
            wp_enqueue_style('pbrc-custom-style', PBRC_PLUGIN_URL . 'assets/css/calculator.css', array(), PBRC_VERSION);

            // 加载计算器脚本
            wp_enqueue_script('pbrc-calculator', PBRC_PLUGIN_URL . 'assets/js/calculator.js', array('pbrc-babel', 'pbrc-react', 'pbrc-react-dom', 'pbrc-chartjs', 'pbrc-xlsx'), PBRC_VERSION, true);

            // 传递配置到前端
            $config = get_option('pbrc_settings', array());
            wp_localize_script('pbrc-calculator', 'pbrcConfig', $config);
        }
    }

    /**
     * 渲染计算器短代码
     */
    public function render_calculator($atts) {
        // 解析短代码参数
        $atts = shortcode_atts(array(
            'sites' => '',
            'orders' => '',
            'price' => '',
            'device_cost' => '',
            'venue_commission' => '',
            'width' => '100%',
            'height' => 'auto',
            'theme' => 'default', // default, light, dark
        ), $atts, 'roi_calculator');

        // 生成唯一ID
        $calculator_id = 'pbrc-' . uniqid();

        // 构建数据属性
        $data_attrs = '';
        if (!empty($atts['sites'])) $data_attrs .= ' data-sites="' . esc_attr($atts['sites']) . '"';
        if (!empty($atts['orders'])) $data_attrs .= ' data-orders="' . esc_attr($atts['orders']) . '"';
        if (!empty($atts['price'])) $data_attrs .= ' data-price="' . esc_attr($atts['price']) . '"';
        if (!empty($atts['device_cost'])) $data_attrs .= ' data-device-cost="' . esc_attr($atts['device_cost']) . '"';
        if (!empty($atts['venue_commission'])) $data_attrs .= ' data-venue-commission="' . esc_attr($atts['venue_commission']) . '"';

        // 输出HTML
        ob_start();
        ?>
        <div id="<?php echo esc_attr($calculator_id); ?>"
             class="powerbank-roi-calculator-wrapper theme-<?php echo esc_attr($atts['theme']); ?>"
             style="width: <?php echo esc_attr($atts['width']); ?>; height: <?php echo esc_attr($atts['height']); ?>; max-width: 100%; margin: 0 auto;"
             <?php echo $data_attrs; ?>>
            <div class="pbrc-loading" style="text-align: center; padding: 60px 20px; color: #667EEA;">
                <div style="display: inline-block; width: 50px; height: 50px; border: 5px solid #f3f4f6; border-top-color: #667EEA; border-radius: 50%; animation: pbrc-spin 1s linear infinite;"></div>
                <p style="margin-top: 20px; font-size: 16px;">正在加载ROI计算器...</p>
            </div>
        </div>

        <style>
        @keyframes pbrc-spin {
            to { transform: rotate(360deg); }
        }
        .powerbank-roi-calculator-wrapper {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }
        </style>

        <script type="text/babel">
            document.addEventListener('DOMContentLoaded', function() {
                const container = document.getElementById('<?php echo esc_js($calculator_id); ?>');
                if (container && typeof window.loadPowerbankROICalculator === 'function') {
                    // 提取数据属性
                    const initialParams = {
                        sites: container.dataset.sites ? parseFloat(container.dataset.sites) : undefined,
                        ordersPerSite: container.dataset.orders ? parseFloat(container.dataset.orders) : undefined,
                        pricePerOrder: container.dataset.price ? parseFloat(container.dataset.price) : undefined,
                        deviceCost: container.dataset.deviceCost ? parseFloat(container.dataset.deviceCost) : undefined,
                        venueCommission: container.dataset.venueCommission ? parseFloat(container.dataset.venueCommission) : undefined,
                    };

                    // 移除loading
                    container.querySelector('.pbrc-loading').remove();

                    // 加载计算器
                    window.loadPowerbankROICalculator(container, initialParams);
                }
            });
        </script>
        <?php
        return ob_get_clean();
    }

    /**
     * 注册Gutenberg块
     */
    public function register_block() {
        if (!function_exists('register_block_type')) {
            return;
        }

        // 注册块脚本
        wp_register_script(
            'pbrc-block-editor',
            PBRC_PLUGIN_URL . 'assets/js/block-editor.js',
            array('wp-blocks', 'wp-element', 'wp-components', 'wp-editor'),
            PBRC_VERSION
        );

        // 注册块样式
        wp_register_style(
            'pbrc-block-editor-style',
            PBRC_PLUGIN_URL . 'assets/css/block-editor.css',
            array('wp-edit-blocks'),
            PBRC_VERSION
        );

        // 注册块
        register_block_type('powerbank-roi/calculator', array(
            'editor_script' => 'pbrc-block-editor',
            'editor_style' => 'pbrc-block-editor-style',
            'render_callback' => array($this, 'render_calculator'),
        ));
    }

    /**
     * 添加设置页面
     */
    public function add_settings_page() {
        add_options_page(
            __('ROI计算器设置', 'powerbank-roi-calculator'),
            __('ROI计算器', 'powerbank-roi-calculator'),
            'manage_options',
            'pbrc-settings',
            array($this, 'render_settings_page')
        );
    }

    /**
     * 注册设置
     */
    public function register_settings() {
        register_setting('pbrc_settings_group', 'pbrc_settings');

        add_settings_section(
            'pbrc_general_section',
            __('基本设置', 'powerbank-roi-calculator'),
            array($this, 'render_general_section'),
            'pbrc-settings'
        );

        add_settings_field(
            'primary_color',
            __('主题色', 'powerbank-roi-calculator'),
            array($this, 'render_color_field'),
            'pbrc-settings',
            'pbrc_general_section',
            array('field' => 'primary_color', 'default' => '#667EEA')
        );

        add_settings_field(
            'secondary_color',
            __('次要色', 'powerbank-roi-calculator'),
            array($this, 'render_color_field'),
            'pbrc-settings',
            'pbrc_general_section',
            array('field' => 'secondary_color', 'default' => '#764BA2')
        );
    }

    /**
     * 渲染设置页面
     */
    public function render_settings_page() {
        ?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>

            <div class="pbrc-settings-header" style="background: linear-gradient(135deg, #667EEA 0%, #764BA2 100%); color: white; padding: 20px; border-radius: 8px; margin: 20px 0;">
                <h2 style="color: white; margin: 0;">共享充电宝ROI计算器</h2>
                <p style="margin: 10px 0 0 0; opacity: 0.9;">配置您的计算器外观和默认参数</p>
            </div>

            <div class="pbrc-usage-info" style="background: #f0f9ff; border-left: 4px solid #0ea5e9; padding: 15px; margin: 20px 0;">
                <h3 style="margin-top: 0;">📝 使用方法</h3>
                <p><strong>短代码：</strong><code>[roi_calculator]</code></p>
                <p><strong>带参数：</strong><code>[roi_calculator sites="100" orders="2.5" price="18"]</code></p>
                <p><strong>Gutenberg：</strong>在编辑器中搜索 "ROI计算器" 块</p>
            </div>

            <form method="post" action="options.php">
                <?php
                settings_fields('pbrc_settings_group');
                do_settings_sections('pbrc-settings');
                submit_button();
                ?>
            </form>

            <div class="pbrc-support-info" style="background: #f9fafb; border: 1px solid #e5e7eb; padding: 20px; border-radius: 8px; margin-top: 30px;">
                <h3>📚 文档和支持</h3>
                <ul>
                    <li><a href="<?php echo PBRC_PLUGIN_URL . 'README.md'; ?>" target="_blank">完整文档</a></li>
                    <li><a href="<?php echo PBRC_PLUGIN_URL . 'INTEGRATION.md'; ?>" target="_blank">WordPress集成指南</a></li>
                    <li><a href="https://github.com/yourusername/repo/issues" target="_blank">报告问题</a></li>
                </ul>
                <p><strong>版本:</strong> <?php echo PBRC_VERSION; ?></p>
            </div>
        </div>
        <?php
    }

    /**
     * 渲染通用设置区域
     */
    public function render_general_section() {
        echo '<p>' . __('自定义计算器的外观和默认值。', 'powerbank-roi-calculator') . '</p>';
    }

    /**
     * 渲染颜色字段
     */
    public function render_color_field($args) {
        $options = get_option('pbrc_settings');
        $value = isset($options[$args['field']]) ? $options[$args['field']] : $args['default'];
        ?>
        <input type="color"
               name="pbrc_settings[<?php echo esc_attr($args['field']); ?>]"
               value="<?php echo esc_attr($value); ?>"
               style="width: 100px; height: 40px; border: none; cursor: pointer;">
        <p class="description">
            <?php echo sprintf(__('默认: %s', 'powerbank-roi-calculator'), $args['default']); ?>
        </p>
        <?php
    }

    /**
     * 添加插件操作链接
     */
    public function add_action_links($links) {
        $settings_link = '<a href="' . admin_url('options-general.php?page=pbrc-settings') . '">' . __('设置', 'powerbank-roi-calculator') . '</a>';
        array_unshift($links, $settings_link);
        return $links;
    }
}

/**
 * 初始化插件
 */
function powerbank_roi_calculator_init() {
    return Powerbank_ROI_Calculator::get_instance();
}

// 启动插件
add_action('plugins_loaded', 'powerbank_roi_calculator_init');

/**
 * 激活钩子
 */
register_activation_hook(__FILE__, function() {
    // 设置默认选项
    add_option('pbrc_settings', array(
        'primary_color' => '#667EEA',
        'secondary_color' => '#764BA2',
    ));
});

/**
 * 卸载钩子
 */
register_deactivation_hook(__FILE__, function() {
    // 清理操作（如果需要）
});
