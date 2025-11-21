<?php
/**
 * Child Theme Functions - Optimized Version
 *
 * @package [Parent Theme]
 * @author  gaviasthemes <gaviasthemes@gmail.com>
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 */

// ============================================
// 1. 基础样式加载
// ============================================
function qempo_child_scripts() {
   wp_enqueue_style( 'qempo-parent-style', get_template_directory_uri(). '/style.css');
   wp_enqueue_style( 'qempo-child-style', get_stylesheet_uri());
}
add_action( 'wp_enqueue_scripts', 'qempo_child_scripts', 9999 );

// ============================================
// 2. YITH Quote 弹窗功能 - 优化版
// ============================================
add_action('wp_footer', 'yith_quote_popup_script');
function yith_quote_popup_script() {
    if (!is_product()) {
        return;
    }
    ?>
    <div id="quote-modal-overlay" style="display:none;">
        <div id="quote-modal-content">
            <button id="close-quote-modal" aria-label="Close">&times;</button>
            <h3>Request Quote</h3>
            <div id="quote-form-wrapper">
                <?php echo do_shortcode('[contact-form-7 id="8495a82" title="Contact Form"]'); ?>
            </div>
        </div>
    </div>

    <style>
    #quote-modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    #quote-modal-content {
        background: white;
        padding: 30px;
        border-radius: 8px;
        max-width: 600px;
        width: 90%;
        max-height: 80vh;
        overflow-y: auto;
        position: relative;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    }

    #close-quote-modal {
        position: absolute;
        top: 15px;
        right: 20px;
        background: none;
        border: none;
        font-size: 28px;
        cursor: pointer;
        color: #666;
        line-height: 1;
        padding: 0;
        width: 30px;
        height: 30px;
        transition: color 0.3s ease;
    }

    #close-quote-modal:hover {
        color: #000;
    }

    #quote-modal-content h3 {
        margin-top: 0;
        margin-bottom: 20px;
        color: #333;
        font-size: 24px;
    }

    /* 确保按钮可见 - 降低specificity */
    .add-request-quote-button,
    .yith-ywraq-add-to-quote {
        display: inline-block;
        visibility: visible;
        opacity: 1;
    }
    </style>

    <script type="text/javascript">
    jQuery(document).ready(function($) {

        // 拦截按钮点击事件
        $(document).on('click', '.add-request-quote-button, .yith-ywraq-add-to-quote', function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();

            // 显示弹窗
            $('#quote-modal-overlay').fadeIn(300);
            $('body').css('overflow', 'hidden'); // 防止背景滚动

            return false;
        });

        // 关闭弹窗函数
        function closeModal() {
            $('#quote-modal-overlay').fadeOut(300);
            $('body').css('overflow', ''); // 恢复滚动
        }

        // 关闭按钮事件
        $('#close-quote-modal').on('click', closeModal);

        // 点击背景关闭
        $('#quote-modal-overlay').on('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // ESC 键关闭
        $(document).on('keyup', function(e) {
            if (e.keyCode === 27 && $('#quote-modal-overlay').is(':visible')) {
                closeModal();
            }
        });

    });
    </script>
    <?php
}

// ============================================
// 3. 防止YITH按钮被隐藏
// ============================================
add_action('wp_head', 'prevent_yith_button_hide');
function prevent_yith_button_hide() {
    if (!is_product()) {
        return;
    }
    ?>
    <style>
    /* 保持报价按钮可见 */
    .add-request-quote-button,
    .yith-ywraq-add-to-quote,
    .yith-ywraq-add-button {
        display: inline-block;
        visibility: visible;
        opacity: 1;
    }

    /* 隐藏YITH的成功消息 */
    .woocommerce-message.ywraq-success {
        display: none;
    }
    </style>
    <?php
}

// ============================================
// 4. Get the App 按钮 ⭐ 你的核心功能
// ============================================
add_action( 'woocommerce_single_product_summary', 'add_get_app_button', 36 );
function add_get_app_button() {
    $app_url = 'https://apps.apple.com/us/app/yellowpal/id6754067632?l=zh-Hans-CN';
    echo '<a href="' . esc_url($app_url) . '" class="button alt get-app-button" target="_blank" rel="noopener noreferrer">Get the App</a>';
}

// ============================================
// 5. 按钮样式 - 优化版
// ============================================
add_action('wp_head', 'get_app_button_styles');
function get_app_button_styles() {
    if (!is_product()) {
        return;
    }
    ?>
    <style>
    /* 按钮容器布局 - 并排显示 */
    .single-product .summary .button.alt {
        display: inline-block !important;
        margin-right: 10px;
        margin-bottom: 10px;
        vertical-align: middle;
        max-width: 180px;
        white-space: nowrap;
    }

    /* Get the App 按钮样式 - 匹配Request Quote样式 */
    .single-product .summary .get-app-button {
        background-color: #FD6450 !important;
        border: 2px solid #FD6450 !important;
        border-radius: 4px;
        color: #ffffff !important;
        padding: 12px 24px;
        font-size: 14px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-left: 0;
        transition: all 0.3s ease;
        text-decoration: none;
        line-height: 1.5;
    }

    .single-product .summary .get-app-button:hover {
        background-color: #E5533F !important;
        border-color: #E5533F !important;
        color: #ffffff !important;
        opacity: 0.9;
    }

    /* 确保Request Quote按钮也保持并排 */
    .single-product .summary .yith-ywraq-add-to-quote,
    .single-product .summary .add-request-quote-button {
        display: inline-block !important;
        max-width: 180px;
    }

    /* 移动端响应式 - 竖排显示 */
    @media (max-width: 768px) {
        .single-product .summary .button.alt {
            display: block !important;
            width: 100%;
            max-width: 100%;
            margin-right: 0;
            margin-bottom: 10px;
            text-align: center;
        }

        .single-product .summary .get-app-button {
            width: 100%;
        }
    }

    /* 小屏幕平板适配 */
    @media (min-width: 769px) and (max-width: 1024px) {
        .single-product .summary .button.alt {
            max-width: 160px;
            font-size: 13px;
            padding: 10px 20px;
        }
    }
    </style>
    <?php
}
