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
// 在 YITH Request Quote 按钮后立即添加 Get the App 按钮
add_action( 'woocommerce_after_add_to_cart_form', 'add_get_app_button_wrapper', 10 );
function add_get_app_button_wrapper() {
    $ios_app_url = 'https://apps.apple.com/us/app/yellowpal/id6754067632?l=zh-Hans-CN';
    $android_app_url = 'https://play.google.com/store/apps/details?id=vn.pinbus.app&hl=vi';
    ?>
    <!-- 按钮容器 -->
    <div class="custom-product-buttons-container">
        <a href="<?php echo esc_url($ios_app_url); ?>" class="button alt get-app-button ios-app-button" target="_blank" rel="noopener noreferrer">Get the App</a>
        <a href="<?php echo esc_url($android_app_url); ?>" class="button alt get-app-button android-app-button" target="_blank" rel="noopener noreferrer">安卓版本</a>
    </div>

    <script type="text/javascript">
    jQuery(document).ready(function($) {
        // 等待页面完全加载
        setTimeout(function() {
            // 查找 YITH Request Quote 按钮
            var $yithButton = $('.yith-ywraq-add-to-quote, .add-request-quote-button, .yith-ywraq-add-button').first();
            var $container = $('.custom-product-buttons-container');

            if ($yithButton.length && $container.length) {
                // 将 YITH 按钮移动到容器的最前面
                $container.prepend($yithButton);

                // 确保容器可见
                $container.show().css('display', 'flex');
            }
        }, 500);
    });
    </script>
    <?php
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
    /* 只隐藏 Add to Cart 按钮，保留 form */
    .single-product .summary form.cart .single_add_to_cart_button {
        display: none !important;
    }

    /* 隐藏数量选择器 */
    .single-product .summary form.cart .quantity {
        display: none !important;
    }

    /* 按钮容器 - 使用 Flexbox 确保并排显示 */
    .custom-product-buttons-container {
        display: flex !important;
        flex-wrap: wrap;
        gap: 10px;
        align-items: center;
        margin-top: 20px;
        margin-bottom: 20px;
        border: none !important;
        background: transparent !important;
        padding: 0 !important;
        box-shadow: none !important;
        outline: none !important;
    }

    /* 统一按钮基础样式 */
    .custom-product-buttons-container .get-app-button,
    .custom-product-buttons-container .yith-ywraq-add-to-quote,
    .custom-product-buttons-container .add-request-quote-button,
    .custom-product-buttons-container .yith-ywraq-add-button {
        /* 统一边框 */
        border: 2px solid !important;
        border-radius: 4px !important;

        /* 统一内边距 */
        padding: 12px 28px !important;

        /* 统一字体 */
        font-size: 14px !important;
        font-weight: 600 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.5px !important;
        line-height: 1.5 !important;

        /* 统一布局 */
        box-sizing: border-box !important;
        white-space: nowrap !important;
        flex: 0 0 auto;
        margin: 0 !important;
        display: inline-block !important;
        text-decoration: none !important;

        /* 统一过渡效果 */
        transition: all 0.3s ease !important;

        /* 统一高度 */
        min-height: 48px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
    }

    /* iOS Get the App 按钮颜色 */
    .custom-product-buttons-container .ios-app-button {
        background-color: #FD6450 !important;
        border-color: #FD6450 !important;
        color: #ffffff !important;
    }

    .custom-product-buttons-container .ios-app-button:hover {
        background-color: #E5533F !important;
        border-color: #E5533F !important;
        color: #ffffff !important;
        opacity: 0.95;
    }

    /* Android 安卓版本按钮颜色 */
    .custom-product-buttons-container .android-app-button {
        background-color: #3DDC84 !important;
        border-color: #3DDC84 !important;
        color: #ffffff !important;
    }

    .custom-product-buttons-container .android-app-button:hover {
        background-color: #2DBE6C !important;
        border-color: #2DBE6C !important;
        color: #ffffff !important;
        opacity: 0.95;
    }

    /* Request Quote 按钮保持原有蓝色 */
    .custom-product-buttons-container .yith-ywraq-add-to-quote,
    .custom-product-buttons-container .add-request-quote-button,
    .custom-product-buttons-container .yith-ywraq-add-button {
        /* 保持主题原有颜色，只统一尺寸和边框 */
    }

    /* 确保 YITH 按钮默认可见 */
    .yith-ywraq-add-to-quote,
    .add-request-quote-button,
    .yith-ywraq-add-button {
        display: inline-block !important;
        visibility: visible !important;
        opacity: 1 !important;
    }

    /* 移除 YITH 按钮外层可能的边框容器 */
    .yith-ywraq-add-button,
    .yith-ywraq-add-button-container,
    .yith-ywraq-button-wrapper,
    div.yith-ywraq-add-button {
        border: none !important;
        background: transparent !important;
        padding: 0 !important;
        box-shadow: none !important;
        outline: none !important;
    }

    /* 确保按钮内没有额外的容器边框 */
    .custom-product-buttons-container > *,
    .custom-product-buttons-container > div,
    .custom-product-buttons-container .yith-ywraq-add-button {
        border: none !important;
        box-shadow: none !important;
        outline: none !important;
        background: transparent !important;
        padding: 0 !important;
    }

    /* 移除可能的 woocommerce 容器边框 */
    .single-product div.product form.cart,
    .single-product div.product .yith-ywraq-add-button,
    .single-product .yith-ywraq-add-button > div,
    .yith-ywraq-add-button > * {
        border: none !important;
        box-shadow: none !important;
    }

    /* 强制移除所有可能的父容器边框 */
    .custom-product-buttons-container [class*="yith"],
    .custom-product-buttons-container [class*="ywraq"],
    .custom-product-buttons-container div[class*="button"] {
        border: none !important;
        box-shadow: none !important;
        outline: none !important;
        background: transparent !important;
    }

    /* 移动端响应式 - 按钮竖排且全宽 */
    @media (max-width: 768px) {
        .custom-product-buttons-container {
            flex-direction: column;
            align-items: stretch;
        }

        .custom-product-buttons-container .ios-app-button,
        .custom-product-buttons-container .android-app-button,
        .custom-product-buttons-container .yith-ywraq-add-to-quote,
        .custom-product-buttons-container .add-request-quote-button {
            width: 100%;
            text-align: center;
            flex: 1 1 auto;
        }
    }

    /* 小屏幕平板适配 */
    @media (min-width: 769px) and (max-width: 1024px) {
        .custom-product-buttons-container .ios-app-button,
        .custom-product-buttons-container .android-app-button,
        .custom-product-buttons-container .yith-ywraq-add-to-quote {
            font-size: 13px;
            padding: 10px 18px;
        }
    }
    </style>
    <?php
}
