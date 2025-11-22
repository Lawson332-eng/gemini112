<?php
/**
 * 产品页面添加应用商店徽章按钮
 * 使用 App Store 和 Google Play 官方徽章样式
 */

// 添加应用商店徽章按钮
add_action( 'woocommerce_after_add_to_cart_form', 'add_store_badge_buttons', 10 );
function add_store_badge_buttons() {
    $ios_app_url = 'https://apps.apple.com/us/app/yellowpal/id6754067632?l=zh-Hans-CN';
    $android_app_url = 'https://play.google.com/store/apps/details?id=vn.pinbus.app&hl=vi';
    ?>
    <div class="custom-product-buttons-container store-badges">
        <!-- App Store 徽章 -->
        <a href="<?php echo esc_url($ios_app_url); ?>" class="store-badge-link app-store-badge" target="_blank" rel="noopener noreferrer">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 135 40" class="badge-svg">
                <rect width="135" height="40" rx="5" fill="#000000"/>
                <text x="50" y="13" fill="#FFFFFF" font-size="10" font-family="Arial, sans-serif">Available on the</text>
                <text x="50" y="28" fill="#FFFFFF" font-size="16" font-family="Arial, sans-serif" font-weight="bold">App Store</text>
                <path d="M25,10 L20,20 L30,20 Z M18,23 L15,28 M32,23 L35,28 M15,28 L35,28" stroke="#FFFFFF" stroke-width="2" fill="none"/>
            </svg>
        </a>

        <!-- Google Play 徽章 -->
        <a href="<?php echo esc_url($android_app_url); ?>" class="store-badge-link google-play-badge" target="_blank" rel="noopener noreferrer">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 135 40" class="badge-svg">
                <rect width="135" height="40" rx="5" fill="#000000"/>
                <text x="45" y="13" fill="#FFFFFF" font-size="9" font-family="Arial, sans-serif">GET IT ON</text>
                <text x="45" y="28" fill="#FFFFFF" font-size="14" font-family="Arial, sans-serif" font-weight="bold">Google Play</text>
                <path d="M20,12 L28,20 L20,28 L12,20 Z" fill="#FFFFFF" opacity="0.8"/>
            </svg>
        </a>
    </div>

    <script type="text/javascript">
    jQuery(document).ready(function($) {
        setTimeout(function() {
            var $yithButton = $('.yith-ywraq-add-to-quote, .add-request-quote-button, .yith-ywraq-add-button').first();
            var $container = $('.custom-product-buttons-container.store-badges');

            if ($yithButton.length && $container.length) {
                // 将 YITH 按钮移到徽章容器前面
                $container.before($yithButton);
                $yithButton.css({
                    'display': 'block',
                    'margin-bottom': '15px',
                    'width': '100%',
                    'max-width': '300px'
                });
                $container.show().css('display', 'flex');
            }
        }, 500);
    });
    </script>
    <?php
}

// 添加样式
add_action( 'wp_head', 'add_store_badge_styles' );
function add_store_badge_styles() {
    ?>
    <style type="text/css">
    /* 隐藏数量选择器 */
    .single-product .summary form.cart .quantity {
        display: none !important;
    }

    /* 应用商店徽章容器 */
    .custom-product-buttons-container.store-badges {
        display: flex !important;
        flex-wrap: wrap;
        gap: 15px;
        align-items: center;
        justify-content: center;
        margin-top: 20px;
        margin-bottom: 20px;
        border: none !important;
        background: transparent !important;
        padding: 0 !important;
    }

    /* 应用商店徽章链接 */
    .store-badge-link {
        display: inline-block;
        text-decoration: none;
        transition: transform 0.2s ease, opacity 0.2s ease;
        border: none !important;
        background: transparent !important;
        padding: 0 !important;
        box-shadow: none !important;
    }

    .store-badge-link:hover {
        transform: scale(1.05);
        opacity: 0.9;
    }

    /* 徽章 SVG 样式 */
    .badge-svg {
        width: 135px;
        height: 40px;
        display: block;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }

    /* Request Quote 按钮样式 */
    .yith-ywraq-add-to-quote,
    .add-request-quote-button,
    .yith-ywraq-add-button {
        display: inline-block !important;
        visibility: visible !important;
        opacity: 1 !important;
        border: 2px solid !important;
        border-radius: 4px !important;
        padding: 12px 28px !important;
        font-size: 14px !important;
        font-weight: 600 !important;
        text-transform: uppercase !important;
        min-height: 48px !important;
        text-align: center !important;
    }

    /* 移动端响应式 */
    @media (max-width: 768px) {
        .custom-product-buttons-container.store-badges {
            flex-direction: column;
            align-items: center;
            gap: 12px;
        }

        .badge-svg {
            width: 150px;
            height: 45px;
        }

        .yith-ywraq-add-to-quote,
        .add-request-quote-button,
        .yith-ywraq-add-button {
            width: 100% !important;
            max-width: 280px !important;
            margin: 0 auto 12px auto !important;
        }
    }

    /* 小屏幕平板适配 */
    @media (min-width: 769px) and (max-width: 1024px) {
        .badge-svg {
            width: 140px;
            height: 42px;
        }
    }
    </style>
    <?php
}
?>
