<?php
/**
 * Power Bank Market Estimator - English Only Version (Simplified)
 * Add this code to your child theme's functions.php
 *
 * File location: gempo_child/functions.php
 */

function powerbank_calculator_en_shortcode() {
    // Load CDN resources
    wp_enqueue_script('tailwind-css', 'https://cdn.tailwindcss.com', array(), null, false);
    wp_enqueue_script('chartjs', 'https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js', array(), '4.4.0', true);
    wp_enqueue_script('jspdf', 'https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js', array(), '2.5.1', true);

    // Load local JavaScript with proper path
    wp_enqueue_script(
        'powerbank-calculator-script',
        get_stylesheet_directory_uri() . '/powerbank-calculator/script-en-only.js',
        array('chartjs', 'jspdf'),
        '2.0.1',
        true
    );

    // Pass data.json URL to JavaScript
    wp_localize_script(
        'powerbank-calculator-script',
        'powerbankPaths',
        array(
            'dataJsonUrl' => get_stylesheet_directory_uri() . '/powerbank-calculator/data.json',
            'themeUrl' => get_stylesheet_directory_uri() . '/powerbank-calculator',
            'siteUrl' => get_site_url()
        )
    );

    // Load HTML content
    ob_start();
    $file_path = get_stylesheet_directory() . '/powerbank-calculator/embed-en.html';

    if (file_exists($file_path)) {
        include($file_path);
    } else {
        // Error message
        echo '<div style="padding: 20px; background: #fee2e2; border: 2px solid #ef4444; border-radius: 8px; margin: 20px 0;">';
        echo '<h3 style="color: #991b1b; margin: 0 0 10px 0;">⚠️ File Not Found</h3>';
        echo '<p style="margin: 0;">Cannot find: <code style="background: #fef2f2; padding: 2px 6px; border-radius: 4px;">' . $file_path . '</code></p>';
        echo '<p style="margin: 10px 0 0 0; font-size: 14px;">Please ensure <strong>embed-en.html</strong> is uploaded to the powerbank-calculator folder in your child theme.</p>';
        echo '</div>';
    }

    return ob_get_clean();
}

// Register shortcode
add_shortcode('powerbank_calculator_en', 'powerbank_calculator_en_shortcode');

// Optional: Add admin notice to confirm setup
add_action('admin_notices', function() {
    $screen = get_current_screen();

    if ($screen && in_array($screen->id, ['dashboard', 'page'])) {
        $is_child_theme = (get_template_directory() !== get_stylesheet_directory());
        $files_exist = array(
            'embed-en.html' => file_exists(get_stylesheet_directory() . '/powerbank-calculator/embed-en.html'),
            'script-en-only.js' => file_exists(get_stylesheet_directory() . '/powerbank-calculator/script-en-only.js'),
            'data.json' => file_exists(get_stylesheet_directory() . '/powerbank-calculator/data.json')
        );

        $all_files_exist = !in_array(false, $files_exist, true);

        ?>
        <div class="notice notice-info is-dismissible">
            <h3>🔧 Power Bank Market Estimator - Status</h3>

            <?php if ($is_child_theme): ?>
                <p style="color: green;">✅ Child theme detected: <strong><?php echo wp_get_theme()->get('Name'); ?></strong></p>
            <?php else: ?>
                <p style="color: orange;">⚠️ Not using child theme</p>
            <?php endif; ?>

            <p><strong>Shortcode:</strong> <code>[powerbank_calculator_en]</code></p>

            <p><strong>File Status:</strong></p>
            <ul style="list-style: none; margin-left: 0; padding-left: 20px;">
                <?php foreach ($files_exist as $file => $exists): ?>
                    <li style="color: <?php echo $exists ? 'green' : 'red'; ?>;">
                        <?php echo $exists ? '✅' : '❌'; ?> <?php echo $file; ?>
                    </li>
                <?php endforeach; ?>
            </ul>

            <?php if ($all_files_exist): ?>
                <p style="color: green; font-weight: bold;">✅ All files are in place! Ready to use.</p>
            <?php else: ?>
                <p style="color: red;">❌ Missing files. Please upload all required files to:<br>
                <code><?php echo get_stylesheet_directory(); ?>/powerbank-calculator/</code></p>
            <?php endif; ?>
        </div>
        <?php
    }
});
?>
