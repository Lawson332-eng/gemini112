<?php
/**
 * 产品页面添加官方应用商店徽章
 * 版本 2.0 - 使用官方应用商店徽章图片
 *
 * 使用说明：
 * 1. 下载官方徽章：
 *    - App Store: https://developer.apple.com/app-store/marketing/guidelines/
 *    - Google Play: https://play.google.com/intl/en_us/badges/
 * 2. 上传到您的服务器 /wp-content/uploads/app-badges/ 目录
 * 3. 或使用下面的 CDN 链接
 */

// 添加应用商店徽章按钮
add_action( 'woocommerce_after_add_to_cart_form', 'add_official_store_badges', 10 );
function add_official_store_badges() {
    $ios_app_url = 'https://apps.apple.com/us/app/yellowpal/id6754067632?l=zh-Hans-CN';
    $android_app_url = 'https://play.google.com/store/apps/details?id=vn.pinbus.app&hl=vi';

    // 徽章图片路径 - 可以替换为您自己上传的图片
    $app_store_badge = 'data:image/svg+xml;base64,' . base64_encode('
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 40">
        <defs>
            <linearGradient id="gradient" x1="0%" y1="0%" x2="0%" y2="100%">
                <stop offset="0%" style="stop-color:#000;stop-opacity:1" />
                <stop offset="100%" style="stop-color:#000;stop-opacity:1" />
            </linearGradient>
        </defs>
        <rect width="120" height="40" rx="5" fill="url(#gradient)"/>
        <g fill="#fff">
            <text x="40" y="12" font-size="8" font-family="SF Pro Display, -apple-system, sans-serif">Available on the</text>
            <text x="40" y="28" font-size="17" font-family="SF Pro Display, -apple-system, sans-serif" font-weight="600">App Store</text>
            <!-- Apple logo -->
            <path d="M28,10 c-0.8,0-1.5,0.3-2,0.8c-0.5-0.5-1.2-0.8-2-0.8c-1.7,0-3,1.3-3,3c0,2.5,3,5.5,5,7c2-1.5,5-4.5,5-7C31,11.3,29.7,10,28,10z M26,15.5l-1-1.5h2L26,15.5z" transform="translate(-5,0)"/>
        </g>
    </svg>
    ');

    $google_play_badge = 'data:image/svg+xml;base64,' . base64_encode('
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 135 40">
        <rect width="135" height="40" rx="5" fill="#000000"/>
        <g fill="#fff">
            <text x="48" y="11" font-size="9" font-family="Roboto, sans-serif">GET IT ON</text>
            <text x="48" y="27" font-size="15" font-family="Roboto, sans-serif" font-weight="500">Google Play</text>
            <!-- Google Play triangle -->
            <defs>
                <linearGradient id="grad1" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" style="stop-color:#00D3FF;stop-opacity:1" />
                    <stop offset="100%" style="stop-color:#0084FF;stop-opacity:1" />
                </linearGradient>
                <linearGradient id="grad2" x1="0%" y1="100%" x2="100%" y2="0%">
                    <stop offset="0%" style="stop-color:#FFD800;stop-opacity:1" />
                    <stop offset="100%" style="stop-color:#FF8A00;stop-opacity:1" />
                </linearGradient>
                <linearGradient id="grad3" x1="0%" y1="0%" x2="0%" y2="100%">
                    <stop offset="0%" style="stop-color:#FF3A44;stop-opacity:1" />
                    <stop offset="100%" style="stop-color:#B11162;stop-opacity:1" />
                </linearGradient>
                <linearGradient id="grad4" x1="100%" y1="0%" x2="0%" y2="100%">
                    <stop offset="0%" style="stop-color:#00E059;stop-opacity:1" />
                    <stop offset="100%" style="stop-color:#00DA3C;stop-opacity:1" />
                </linearGradient>
            </defs>
            <path d="M16,8 L16,32 L24,20 L16,8 Z" fill="url(#grad1)"/>
            <path d="M16,32 L24,20 L32,24 L20,32 L16,32 Z" fill="url(#grad2)"/>
            <path d="M32,16 L24,20 L16,8 L28,8 L32,16 Z" fill="url(#grad3)"/>
            <path d="M32,16 L24,20 L32,24 L32,16 Z" fill="url(#grad4)"/>
        </g>
    </svg>
    ');
    ?>
    <div class="custom-product-buttons-container official-badges">
        <!-- App Store 徽章 -->
        <a href="<?php echo esc_url($ios_app_url); ?>" class="official-badge-link app-store" target="_blank" rel="noopener noreferrer" aria-label="Download on the App Store">
            <img src="<?php echo $app_store_badge; ?>" alt="Download on the App Store" class="store-badge-img">
        </a>

        <!-- Google Play 徽章 -->
        <a href="<?php echo esc_url($android_app_url); ?>" class="official-badge-link google-play" target="_blank" rel="noopener noreferrer" aria-label="Get it on Google Play">
            <img src="<?php echo $google_play_badge; ?>" alt="Get it on Google Play" class="store-badge-img">
        </a>
    </div>

    <script type="text/javascript">
    jQuery(document).ready(function($) {
        setTimeout(function() {
            var $yithButton = $('.yith-ywraq-add-to-quote, .add-request-quote-button, .yith-ywraq-add-button').first();
            var $container = $('.custom-product-buttons-container.official-badges');

            if ($yithButton.length && $container.length) {
                // 将 YITH Request Quote 按钮移到徽章容器前面
                $container.before($yithButton);

                // 为 Request Quote 按钮添加样式
                $yithButton.addClass('request-quote-styled');

                $container.show().css('display', 'flex');
            }
        }, 500);
    });
    </script>
    <?php
}

// 添加样式
add_action( 'wp_head', 'add_official_badge_styles' );
function add_official_badge_styles() {
    ?>
    <style type="text/css">
    /* 隐藏数量选择器 */
    .single-product .summary form.cart .quantity {
        display: none !important;
    }

    /* 官方徽章容器样式 */
    .custom-product-buttons-container.official-badges {
        display: flex !important;
        flex-wrap: wrap;
        gap: 12px;
        align-items: center;
        justify-content: center;
        margin-top: 15px;
        margin-bottom: 20px;
        border: none !important;
        background: transparent !important;
        padding: 0 !important;
        box-shadow: none !important;
    }

    /* 徽章链接样式 */
    .official-badge-link {
        display: inline-block;
        text-decoration: none;
        transition: transform 0.15s ease, opacity 0.15s ease;
        border: none !important;
        background: transparent !important;
        padding: 0 !important;
        box-shadow: none !important;
        outline: none !important;
        line-height: 0;
    }

    .official-badge-link:hover {
        transform: translateY(-2px);
        opacity: 0.85;
    }

    .official-badge-link:active {
        transform: translateY(0);
    }

    /* 徽章图片样式 */
    .store-badge-img {
        width: 135px;
        height: 40px;
        display: block;
        border-radius: 5px;
        border: none !important;
        box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
    }

    /* Request Quote 按钮样式 */
    .request-quote-styled,
    .yith-ywraq-add-to-quote,
    .add-request-quote-button,
    .yith-ywraq-add-button {
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
        border: 2px solid !important;
        border-radius: 4px !important;
        padding: 12px 32px !important;
        font-size: 14px !important;
        font-weight: 600 !important;
        text-transform: uppercase !important;
        min-height: 48px !important;
        text-align: center !important;
        margin: 0 auto 15px auto !important;
        max-width: 280px !important;
        width: 100% !important;
        box-sizing: border-box !important;
    }

    /* 移除所有可能的容器边框 */
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

    /* 移动端响应式 - 统一间距 */
    @media (max-width: 768px) {
        .custom-product-buttons-container.official-badges {
            flex-direction: column;
            align-items: center;
            gap: 12px;
            margin-top: 12px;
        }

        .store-badge-img {
            width: 150px;
            height: 45px;
        }

        .request-quote-styled,
        .yith-ywraq-add-to-quote,
        .add-request-quote-button,
        .yith-ywraq-add-button {
            max-width: 280px !important;
            width: 100% !important;
            margin-bottom: 12px !important;
        }

        /* 确保三个元素间距统一 */
        .official-badge-link {
            margin: 0 !important;
        }
    }

    /* 平板适配 */
    @media (min-width: 769px) and (max-width: 1024px) {
        .store-badge-img {
            width: 140px;
            height: 42px;
        }

        .custom-product-buttons-container.official-badges {
            gap: 10px;
        }
    }

    /* 桌面端 - 横排显示 */
    @media (min-width: 1025px) {
        .custom-product-buttons-container.official-badges {
            justify-content: flex-start;
            gap: 15px;
        }

        .request-quote-styled,
        .yith-ywraq-add-to-quote,
        .add-request-quote-button,
        .yith-ywraq-add-button {
            display: inline-block !important;
            width: auto !important;
            max-width: none !important;
            margin: 0 15px 0 0 !important;
        }
    }
    </style>
    <?php
}
?>
