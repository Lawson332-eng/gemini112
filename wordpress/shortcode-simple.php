<?php
/**
 * 简单短代码实现 - 共享充电宝ROI计算器
 *
 * 使用方法：
 * 1. 将此文件内容复制到主题的 functions.php 文件末尾
 * 2. 或者创建为独立插件文件
 * 3. 将 public/index.html 上传到主题目录的 roi-calculator/ 文件夹
 * 4. 在页面中使用短代码: [roi_calculator]
 *
 * Version: 1.0.0
 * License: MIT
 */

// 防止直接访问
if (!defined('ABSPATH')) {
    exit;
}

/**
 * 方案一：iframe嵌入方式（最简单，推荐）
 *
 * 优点：
 * - 实现最简单，5分钟完成
 * - 样式完全隔离，不会与主题冲突
 * - 功能完整，无需修改
 * - 易于更新维护
 */
function roi_calculator_iframe_shortcode($atts) {
    $atts = shortcode_atts(array(
        'width' => '100%',
        'height' => '1200',
        'src' => '', // 如果为空，使用主题目录下的文件
    ), $atts);

    // 计算器HTML文件路径
    if (empty($atts['src'])) {
        // 默认使用主题目录
        $calculator_url = get_template_directory_uri() . '/roi-calculator/index.html';

        // 如果主题目录没有，尝试插件目录
        if (!file_exists(get_template_directory() . '/roi-calculator/index.html')) {
            // 尝试uploads目录
            $upload_dir = wp_upload_dir();
            $calculator_url = $upload_dir['baseurl'] . '/roi-calculator/index.html';
        }
    } else {
        $calculator_url = esc_url($atts['src']);
    }

    // 生成唯一ID
    $iframe_id = 'roi-calculator-' . uniqid();

    ob_start();
    ?>
    <div class="roi-calculator-wrapper" style="width: <?php echo esc_attr($atts['width']); ?>; max-width: 100%; margin: 0 auto;">
        <iframe
            id="<?php echo esc_attr($iframe_id); ?>"
            src="<?php echo esc_url($calculator_url); ?>"
            width="100%"
            height="<?php echo esc_attr($atts['height']); ?>px"
            frameborder="0"
            scrolling="auto"
            style="border: none; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);"
            title="共享充电宝ROI计算器"
            loading="lazy"
        ></iframe>
    </div>

    <style>
    .roi-calculator-wrapper {
        position: relative;
        min-height: 400px;
    }

    @media (max-width: 768px) {
        .roi-calculator-wrapper iframe {
            height: auto;
            min-height: 800px;
        }
    }
    </style>

    <script>
    // 响应式高度调整（可选）
    (function() {
        var iframe = document.getElementById('<?php echo esc_js($iframe_id); ?>');
        if (iframe && window.addEventListener) {
            window.addEventListener('message', function(e) {
                // 接收来自iframe的高度信息
                if (e.data && e.data.type === 'resize' && e.data.height) {
                    iframe.style.height = e.data.height + 'px';
                }
            }, false);
        }
    })();
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('roi_calculator', 'roi_calculator_iframe_shortcode');


/**
 * 方案二：直接内嵌方式（高级用户）
 *
 * 优点：
 * - SEO更友好
 * - 加载速度快
 * - 与主题深度集成
 *
 * 使用此方案请取消下面的注释
 */
/*
function roi_calculator_inline_shortcode($atts) {
    $atts = shortcode_atts(array(
        'sites' => '100',
        'orders' => '2.2',
        'price' => '15',
    ), $atts);

    // 加载依赖库
    wp_enqueue_script('pbrc-react', 'https://unpkg.com/react@18/umd/react.production.min.js', array(), null, false);
    wp_enqueue_script('pbrc-react-dom', 'https://unpkg.com/react-dom@18/umd/react-dom.production.min.js', array('pbrc-react'), null, false);
    wp_enqueue_script('pbrc-babel', 'https://unpkg.com/@babel/standalone/babel.min.js', array(), null, false);
    wp_enqueue_script('pbrc-chartjs', 'https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js', array(), null, false);
    wp_enqueue_script('pbrc-xlsx', 'https://cdn.sheetjs.com/xlsx-0.20.0/package/dist/xlsx.full.min.js', array(), null, false);

    // 加载Tailwind CSS
    wp_enqueue_script('pbrc-tailwind', 'https://cdn.tailwindcss.com', array(), null, false);

    $calculator_id = 'roi-calc-' . uniqid();

    ob_start();
    ?>
    <div id="<?php echo esc_attr($calculator_id); ?>" class="roi-calculator-inline"></div>

    <script type="text/babel">
        // 在这里嵌入 public/index.html 中的完整React代码
        // 或者通过 wp_enqueue_script 加载外部JS文件
        console.log('ROI Calculator initialized with params:', {
            sites: <?php echo intval($atts['sites']); ?>,
            orders: <?php echo floatval($atts['orders']); ?>,
            price: <?php echo floatval($atts['price']); ?>
        });
    </script>
    <?php
    return ob_get_clean();
}
// add_shortcode('roi_calculator_inline', 'roi_calculator_inline_shortcode');
*/


/**
 * 方案三：外部链接跳转（最简单）
 *
 * 如果计算器托管在独立域名/子域名
 */
function roi_calculator_link_shortcode($atts) {
    $atts = shortcode_atts(array(
        'url' => 'https://calculator.yourdomain.com',
        'text' => '打开ROI计算器',
        'new_window' => 'yes',
    ), $atts);

    $target = ($atts['new_window'] === 'yes') ? '_blank' : '_self';

    return sprintf(
        '<a href="%s" target="%s" class="roi-calculator-button" style="display: inline-block; padding: 15px 30px; background: linear-gradient(135deg, #667EEA, #764BA2); color: white; text-decoration: none; border-radius: 10px; font-weight: 600; transition: transform 0.3s; box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);">%s</a>',
        esc_url($atts['url']),
        esc_attr($target),
        esc_html($atts['text'])
    );
}
add_shortcode('roi_calculator_link', 'roi_calculator_link_shortcode');


/**
 * 添加自定义CSS（可选）
 */
function roi_calculator_custom_styles() {
    ?>
    <style>
    /* ROI计算器自定义样式 */
    .roi-calculator-wrapper {
        margin: 30px 0;
    }

    .roi-calculator-button:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4) !important;
    }

    /* 响应式调整 */
    @media (max-width: 768px) {
        .roi-calculator-wrapper iframe {
            height: auto !important;
            min-height: 600px;
        }
    }

    /* 加载动画 */
    @keyframes roi-pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }

    .roi-calculator-loading {
        animation: roi-pulse 1.5s ease-in-out infinite;
        text-align: center;
        padding: 60px 20px;
        color: #667EEA;
    }
    </style>
    <?php
}
add_action('wp_head', 'roi_calculator_custom_styles');


/**
 * 使用示例：
 *
 * 基础用法:
 * [roi_calculator]
 *
 * 自定义高度:
 * [roi_calculator height="1000"]
 *
 * 指定URL:
 * [roi_calculator src="https://yourdomain.com/calculator/index.html"]
 *
 * 按钮链接方式:
 * [roi_calculator_link url="https://calculator.yourdomain.com" text="立即计算ROI"]
 */


/**
 * 安装说明:
 *
 * 步骤1: 上传计算器文件
 * - 将 public/index.html 重命名为 index.html
 * - 上传到以下任一位置:
 *   a) wp-content/themes/你的主题/roi-calculator/index.html
 *   b) wp-content/uploads/roi-calculator/index.html
 *
 * 步骤2: 添加短代码
 * - 将此文件内容复制到 functions.php
 * - 或创建为独立插件
 *
 * 步骤3: 使用
 * - 在页面/文章编辑器中插入: [roi_calculator]
 * - 或在模板文件中使用: <?php echo do_shortcode('[roi_calculator]'); ?>
 *
 * 故障排除:
 * - 如果显示404: 检查文件路径是否正确
 * - 如果样式错乱: 使用iframe方式避免CSS冲突
 * - 如果功能异常: 检查浏览器控制台错误
 */
