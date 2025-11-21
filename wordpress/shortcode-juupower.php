<?php
/**
 * Power Bank ROI Calculator - JuuPower Website Integration
 *
 * Custom integration for JuuPower website with brand colors:
 * - Primary: #070346 (Dark Navy Blue)
 * - Background: #E6F0EC (Light Green-Gray)
 * - Accent: #FD6450 (Coral Red)
 *
 * Usage: Add this code to your theme's functions.php
 * Then use shortcode: [powerbank_roi_calculator]
 *
 * Version: 1.0.0
 * Author: JuuPower Dev Team
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * ROI Calculator Shortcode
 * Embeds the calculator seamlessly into your WordPress page
 */
function juupower_roi_calculator_shortcode($atts) {
    // Parse shortcode attributes
    $atts = shortcode_atts(array(
        'width' => '100%',
        'height' => '1200',
        'sites' => '',
        'orders' => '',
        'price' => '',
    ), $atts);

    // Calculator file URL
    // Option 1: Use theme directory
    $calculator_url = get_template_directory_uri() . '/calculator/calculator-embed-en.html';

    // Option 2: Use uploads directory (uncomment if preferred)
    // $upload_dir = wp_upload_dir();
    // $calculator_url = $upload_dir['baseurl'] . '/calculator/calculator-embed-en.html';

    // Option 3: Use external URL (uncomment if hosted separately)
    // $calculator_url = 'https://calculator.juupower.com/calculator-embed-en.html';

    // Build query parameters if defaults provided
    $query_params = array();
    if (!empty($atts['sites'])) $query_params['sites'] = $atts['sites'];
    if (!empty($atts['orders'])) $query_params['orders'] = $atts['orders'];
    if (!empty($atts['price'])) $query_params['price'] = $atts['price'];

    if (!empty($query_params)) {
        $calculator_url .= '?' . http_build_query($query_params);
    }

    // Generate unique ID
    $iframe_id = 'roi-calculator-' . uniqid();

    // Output buffer start
    ob_start();
    ?>

    <!-- ROI Calculator Container -->
    <div class="juupower-calculator-wrapper"
         style="width: <?php echo esc_attr($atts['width']); ?>; max-width: 100%; margin: 40px auto; background: #E6F0EC; padding: 0; border-radius: 15px; overflow: hidden; box-shadow: 0 10px 30px rgba(7, 3, 70, 0.1);">

        <iframe
            id="<?php echo esc_attr($iframe_id); ?>"
            src="<?php echo esc_url($calculator_url); ?>"
            width="100%"
            height="<?php echo esc_attr($atts['height']); ?>px"
            frameborder="0"
            scrolling="auto"
            style="border: none; display: block; background: #E6F0EC;"
            title="Power Bank Sharing ROI Calculator"
            loading="lazy"
        ></iframe>
    </div>

    <style>
    /* JuuPower Calculator Styles */
    .juupower-calculator-wrapper {
        position: relative;
        min-height: 400px;
        background: #E6F0EC;
    }

    .juupower-calculator-wrapper iframe {
        background: #E6F0EC;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .juupower-calculator-wrapper {
            margin: 20px 0;
            border-radius: 10px;
        }

        .juupower-calculator-wrapper iframe {
            height: auto !important;
            min-height: 800px;
        }
    }

    @media (max-width: 480px) {
        .juupower-calculator-wrapper {
            border-radius: 0;
            margin-left: -20px;
            margin-right: -20px;
            width: calc(100% + 40px) !important;
        }
    }

    /* Loading animation */
    .juupower-calculator-wrapper::before {
        content: 'Loading Calculator...';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: #070346;
        font-size: 18px;
        font-weight: 600;
        z-index: -1;
    }
    </style>

    <script>
    // Responsive height adjustment (optional)
    (function() {
        var iframe = document.getElementById('<?php echo esc_js($iframe_id); ?>');

        if (iframe && window.addEventListener) {
            // Listen for messages from iframe
            window.addEventListener('message', function(e) {
                if (e.data && e.data.type === 'resize' && e.data.height) {
                    iframe.style.height = e.data.height + 'px';
                }
            }, false);

            // Adjust height on load
            iframe.onload = function() {
                // Auto-adjust based on viewport
                if (window.innerWidth < 768) {
                    iframe.style.height = 'auto';
                    iframe.style.minHeight = '800px';
                }
            };
        }

        // Responsive resize handler
        window.addEventListener('resize', function() {
            if (iframe && window.innerWidth < 768) {
                iframe.style.height = 'auto';
                iframe.style.minHeight = '800px';
            }
        });
    })();
    </script>

    <?php
    return ob_get_clean();
}

// Register shortcode
add_shortcode('powerbank_roi_calculator', 'juupower_roi_calculator_shortcode');
add_shortcode('roi_calculator', 'juupower_roi_calculator_shortcode'); // Alias


/**
 * Alternative: Direct HTML Embed (No iframe)
 * Use this if you want to embed the calculator directly without iframe
 *
 * Note: Requires the calculator HTML to be split into component parts
 */
function juupower_roi_calculator_direct_shortcode($atts) {
    $atts = shortcode_atts(array(
        'sites' => '100',
        'orders' => '2.2',
        'price' => '15',
    ), $atts);

    wp_enqueue_script('pbrc-react', 'https://unpkg.com/react@18/umd/react.production.min.js', array(), null, false);
    wp_enqueue_script('pbrc-react-dom', 'https://unpkg.com/react-dom@18/umd/react-dom.production.min.js', array('pbrc-react'), null, false);
    wp_enqueue_script('pbrc-babel', 'https://unpkg.com/@babel/standalone/babel.min.js', array(), null, false);
    wp_enqueue_script('pbrc-chartjs', 'https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js', array(), null, false);
    wp_enqueue_script('pbrc-xlsx', 'https://cdn.sheetjs.com/xlsx-0.20.0/package/dist/xlsx.full.min.js', array(), null, false);
    wp_enqueue_script('pbrc-tailwind', 'https://cdn.tailwindcss.com', array(), null, false);

    $calculator_id = 'roi-calc-' . uniqid();

    ob_start();
    ?>
    <div id="<?php echo esc_attr($calculator_id); ?>"
         class="juupower-calculator-direct"
         style="background: #E6F0EC; padding: 20px; border-radius: 15px;">
        <div class="loading" style="text-align: center; padding: 60px 20px; color: #070346;">
            <div style="display: inline-block; width: 50px; height: 50px; border: 5px solid #E6F0EC; border-top-color: #FD6450; border-radius: 50%; animation: spin 1s linear infinite;"></div>
            <p style="margin-top: 20px; font-size: 16px; font-weight: 600;">Loading ROI Calculator...</p>
        </div>
    </div>

    <style>
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    </style>

    <script type="text/babel">
        // Initialize calculator with custom parameters
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('<?php echo esc_js($calculator_id); ?>');
            if (container) {
                // Custom initialization with JuuPower branding
                console.log('JuuPower ROI Calculator initialized');

                // You can load the full React app here
                // or fetch the calculator component from an external source
            }
        });
    </script>
    <?php
    return ob_get_clean();
}
// add_shortcode('roi_calculator_direct', 'juupower_roi_calculator_direct_shortcode');


/**
 * CTA Button Shortcode
 * Creates a call-to-action button that opens calculator in modal/new tab
 */
function juupower_roi_calculator_button_shortcode($atts) {
    $atts = shortcode_atts(array(
        'text' => 'Calculate Your ROI',
        'url' => '',
        'style' => 'gradient', // gradient, solid, outline
        'new_window' => 'yes',
    ), $atts);

    $calculator_url = !empty($atts['url']) ? $atts['url'] : get_template_directory_uri() . '/calculator/calculator-embed-en.html';
    $target = ($atts['new_window'] === 'yes') ? '_blank' : '_self';

    // Button styles based on JuuPower theme
    $button_styles = array(
        'gradient' => 'background: linear-gradient(135deg, #FD6450 0%, #ff8570 100%); color: white; border: none;',
        'solid' => 'background: #FD6450; color: white; border: none;',
        'outline' => 'background: transparent; color: #070346; border: 2px solid #070346;'
    );

    $style = isset($button_styles[$atts['style']]) ? $button_styles[$atts['style']] : $button_styles['gradient'];

    return sprintf(
        '<a href="%s" target="%s" class="juupower-roi-button" style="display: inline-block; padding: 15px 40px; %s text-decoration: none; border-radius: 50px; font-weight: 600; font-size: 16px; transition: all 0.3s ease; box-shadow: 0 5px 15px rgba(253, 100, 80, 0.3); text-align: center;">%s</a>

        <style>
        .juupower-roi-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(253, 100, 80, 0.4) !important;
        }
        </style>',
        esc_url($calculator_url),
        esc_attr($target),
        $style,
        esc_html($atts['text'])
    );
}
add_shortcode('roi_calculator_button', 'juupower_roi_calculator_button_shortcode');


/**
 * Add custom CSS to admin (optional)
 * Helps visualize calculator in WordPress editor
 */
function juupower_calculator_admin_css() {
    ?>
    <style>
    /* WordPress Editor Styles */
    .wp-block[data-type*="shortcode"] {
        background: #E6F0EC;
        border: 2px dashed #070346;
        border-radius: 10px;
        padding: 20px;
    }
    </style>
    <?php
}
add_action('admin_head', 'juupower_calculator_admin_css');


/**
 * INSTALLATION INSTRUCTIONS
 * =========================
 *
 * Step 1: Upload Calculator File
 * -------------------------------
 * Upload "calculator-embed-en.html" to one of these locations:
 *
 * Option A (Recommended): Theme directory
 *   Path: wp-content/themes/your-theme/calculator/calculator-embed-en.html
 *
 * Option B: Uploads directory
 *   Path: wp-content/uploads/calculator/calculator-embed-en.html
 *
 * Option C: External hosting
 *   Host on subdomain: https://calculator.juupower.com/calculator-embed-en.html
 *
 *
 * Step 2: Add This Code
 * ---------------------
 * Copy this entire file content and paste it at the end of your theme's functions.php file:
 *   Location: Appearance → Theme File Editor → functions.php
 *
 * Or create as a custom plugin:
 *   1. Create folder: wp-content/plugins/juupower-calculator/
 *   2. Save this as: juupower-calculator.php
 *   3. Add plugin header (see below)
 *   4. Activate in Plugins menu
 *
 *
 * Step 3: Use Shortcodes
 * ----------------------
 * In any page or post, use one of these shortcodes:
 *
 * Basic usage:
 *   [powerbank_roi_calculator]
 *
 * With custom height:
 *   [powerbank_roi_calculator height="1000"]
 *
 * With default parameters:
 *   [powerbank_roi_calculator sites="100" orders="2.5" price="18"]
 *
 * CTA Button:
 *   [roi_calculator_button text="Start Calculating" style="gradient"]
 *
 *
 * Step 4: Customize (Optional)
 * ----------------------------
 * - Adjust colors in calculator-embed-en.html if needed
 * - Modify iframe height in shortcode attributes
 * - Change button styles in button shortcode
 *
 *
 * TROUBLESHOOTING
 * ===============
 *
 * Calculator not showing?
 * - Check file path is correct
 * - Verify file uploaded successfully
 * - Test URL directly in browser
 * - Check browser console for errors
 *
 * Styles look wrong?
 * - Clear browser cache
 * - Clear WordPress cache (if using cache plugin)
 * - Check for theme CSS conflicts
 *
 * Height issues on mobile?
 * - Adjust height parameter
 * - Use responsive CSS adjustments included
 *
 *
 * SUPPORT
 * =======
 * For help, contact: info@juupower.com
 * Documentation: [Your docs URL]
 */


/**
 * Optional: Convert to Plugin
 * ============================
 * To use this as a standalone plugin instead of adding to functions.php,
 * add this header at the very top of the file:
 *
 * <?php
 * /**
 *  * Plugin Name: JuuPower ROI Calculator
 *  * Plugin URI: https://www.juupower.com
 *  * Description: Power Bank Sharing ROI Calculator for JuuPower website
 *  * Version: 1.0.0
 *  * Author: JuuPower Dev Team
 *  * Author URI: https://www.juupower.com
 *  * License: MIT
 *  * /
 *
 * Then upload to: wp-content/plugins/juupower-calculator/juupower-calculator.php
 */
