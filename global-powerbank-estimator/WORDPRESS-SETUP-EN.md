# WordPress Deployment Guide

## 📋 Prerequisites

You need:
- WordPress administrator access
- FTP/SFTP access OR File Manager access

---

## 🚀 Method 1: Using Shortcode (Recommended - Easiest)

### Step 1: Upload Files

#### Option A: Via FTP/SFTP (Recommended)

1. Connect to your server using FileZilla or other FTP client

2. Navigate to your theme directory:
   ```
   /wp-content/themes/your-theme-name/
   ```

3. Create a new folder: `powerbank-calculator`

4. Upload these 3 files to the folder:
   - `embed.html`
   - `script.js`
   - `data.json`

5. Final path should be:
   ```
   /wp-content/themes/your-theme-name/powerbank-calculator/
   ├── embed.html
   ├── script.js
   └── data.json
   ```

#### Option B: Via WordPress File Manager

1. Log in to WordPress admin panel

2. Install "File Manager" plugin (if you don't have one)

3. Go to **File Manager** > **wp-content** > **themes** > **your-theme-folder**

4. Create new folder `powerbank-calculator`

5. Upload the 3 files to this folder

#### Option C: Via cPanel File Manager

1. Log in to cPanel

2. Open **File Manager**

3. Navigate to:
   ```
   public_html/wp-content/themes/your-theme-name/
   ```

4. Create folder `powerbank-calculator`

5. Upload files

---

### Step 2: Add Shortcode to WordPress

#### Method A: Via WordPress Editor (Recommended)

1. Go to **Appearance** > **Theme File Editor**

2. ⚠️ **Warning**: Select **Theme Functions (functions.php)** on the right side
   - Backup this file first!

3. Scroll to the end of the file, before `?>` (if exists) or at the very end, add:

```php
<?php
/**
 * Global Powerbank Market Estimator
 */
function powerbank_calculator_shortcode() {
    // Load required CSS and JS libraries
    wp_enqueue_script('tailwind-css', 'https://cdn.tailwindcss.com', array(), null, false);
    wp_enqueue_script('chartjs', 'https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js', array(), '4.4.0', true);
    wp_enqueue_script('jspdf', 'https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js', array(), '2.5.1', true);

    // Load local JavaScript file
    wp_enqueue_script(
        'powerbank-calculator-script',
        get_template_directory_uri() . '/powerbank-calculator/script.js',
        array('chartjs'),
        '1.0.0',
        true
    );

    // Get and return HTML content
    ob_start();
    $file_path = get_template_directory() . '/powerbank-calculator/embed.html';

    if (file_exists($file_path)) {
        include($file_path);
    } else {
        echo '<div style="padding: 20px; background: #fee; border: 1px solid #f00; border-radius: 5px;">';
        echo '<strong>Error:</strong> Calculator file not found. Please ensure files are uploaded to: ' . $file_path;
        echo '</div>';
    }

    return ob_get_clean();
}

// Register shortcode
add_shortcode('powerbank_calculator', 'powerbank_calculator_shortcode');
?>
```

4. Click **Update File** to save

#### Method B: Via FTP Edit (Safer)

1. Download `functions.php` to local

2. Open with text editor, add the code above

3. Save and upload back to server

---

### Step 3: Create Tool Page

1. Go to **Pages** > **Add New**

2. Enter page title:
   ```
   Power Bank Market Estimator
   ```
   or
   ```
   Market Capacity Estimation Tool
   ```

3. In the content editor, depending on which editor you use:

   #### If using Classic Editor:
   - Switch to **Text** mode
   - Enter shortcode:
   ```
   [powerbank_calculator]
   ```

   #### If using Gutenberg Editor:
   - Click **+** to add block
   - Search and select **Shortcode** block
   - Enter:
   ```
   [powerbank_calculator]
   ```

   #### If using Elementor:
   - Add **Shortcode** widget
   - In shortcode field enter:
   ```
   [powerbank_calculator]
   ```

4. (Optional) Set page attributes:
   - **Template**: Select full-width template (if available)
   - **Featured Image**: Upload relevant image

5. Click **Publish**

---

### Step 4: Test

1. Click **View Page**

2. Check these features:
   - ✅ Page displays correctly
   - ✅ Can select reference cities
   - ✅ Can input data
   - ✅ Step navigation works
   - ✅ Calculation works
   - ✅ Charts display properly
   - ✅ Language switch works
   - ✅ Export functions work

3. If issues occur, see [Troubleshooting](#troubleshooting) section

---

## 🎨 Method 2: Using Page Template (For Advanced Users)

### Step 1: Create Page Template File

1. Create file `page-powerbank-calculator.php` in theme directory

2. Add this content:

```php
<?php
/**
 * Template Name: Power Bank Market Estimator
 * Description: Power Bank Market Estimator Page Template
 */

get_header();
?>

<style>
/* Full width display */
.powerbank-calculator-page {
    width: 100%;
    max-width: 1400px;
    margin: 0 auto;
    padding: 20px;
}

/* Hide sidebar */
.sidebar {
    display: none;
}

/* Full width content area */
.content-area {
    width: 100%;
    float: none;
}
</style>

<div class="powerbank-calculator-page">
    <?php
    // Load calculator
    echo do_shortcode('[powerbank_calculator]');
    ?>
</div>

<?php
get_footer();
?>
```

### Step 2: Create Page and Select Template

1. Create new page

2. In right sidebar **Page Attributes** select template:
   - Template: **Power Bank Market Estimator**

3. Title can be empty or enter description

4. Publish

---

## 🔧 Method 3: Using Plugin (Easiest for Beginners)

### Step 1: Create Custom Plugin

1. In `/wp-content/plugins/` create folder:
   ```
   powerbank-calculator-plugin
   ```

2. In this folder create file `powerbank-calculator.php`

3. Add this content:

```php
<?php
/**
 * Plugin Name: Global Power Bank Market Estimator
 * Plugin URI: https://yoursite.com
 * Description: Global Power Bank Market Estimator Tool
 * Version: 1.0.0
 * Author: Your Name
 * License: MIT
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin paths
define('POWERBANK_CALC_PATH', plugin_dir_path(__FILE__));
define('POWERBANK_CALC_URL', plugin_dir_url(__FILE__));

// Shortcode function
function powerbank_calculator_shortcode() {
    wp_enqueue_script('tailwind-css', 'https://cdn.tailwindcss.com');
    wp_enqueue_script('chartjs', 'https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js');
    wp_enqueue_script('jspdf', 'https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js');

    wp_enqueue_script(
        'powerbank-calculator',
        POWERBANK_CALC_URL . 'assets/script.js',
        array('chartjs'),
        '1.0.0',
        true
    );

    ob_start();
    include(POWERBANK_CALC_PATH . 'assets/embed.html');
    return ob_get_clean();
}
add_shortcode('powerbank_calculator', 'powerbank_calculator_shortcode');

// Add admin menu
function powerbank_calculator_menu() {
    add_menu_page(
        'Power Bank Estimator',
        'Market Estimator',
        'manage_options',
        'powerbank-calculator',
        'powerbank_calculator_admin_page',
        'dashicons-chart-area',
        30
    );
}
add_action('admin_menu', 'powerbank_calculator_menu');

function powerbank_calculator_admin_page() {
    ?>
    <div class="wrap">
        <h1>Global Power Bank Market Estimator</h1>

        <div class="card" style="max-width: 800px; margin-top: 20px; padding: 20px;">
            <h2>📝 How to Use</h2>
            <ol>
                <li>Add shortcode to any page or post: <code>[powerbank_calculator]</code></li>
                <li>Or use PHP code: <code>&lt;?php echo do_shortcode('[powerbank_calculator]'); ?&gt;</code></li>
            </ol>

            <h2 style="margin-top: 30px;">📁 File Status</h2>
            <?php
            $files = array(
                'embed.html' => POWERBANK_CALC_PATH . 'assets/embed.html',
                'script.js' => POWERBANK_CALC_PATH . 'assets/script.js',
                'data.json' => POWERBANK_CALC_PATH . 'assets/data.json'
            );

            foreach ($files as $name => $path) {
                $status = file_exists($path) ? '✅ Uploaded' : '❌ Not Found';
                $color = file_exists($path) ? 'green' : 'red';
                echo "<p><strong>$name:</strong> <span style='color: $color;'>$status</span></p>";
            }
            ?>

            <h2 style="margin-top: 30px;">🔗 Quick Actions</h2>
            <p>
                <a href="<?php echo admin_url('post-new.php?post_type=page'); ?>" class="button button-primary">
                    Create New Page
                </a>
            </p>
        </div>
    </div>
    <?php
}
?>
```

4. Create `assets` subfolder in plugin folder

5. Copy these files to `assets` folder:
   - `embed.html`
   - `script.js`
   - `data.json`

6. File structure:
   ```
   /wp-content/plugins/powerbank-calculator-plugin/
   ├── powerbank-calculator.php
   └── assets/
       ├── embed.html
       ├── script.js
       └── data.json
   ```

### Step 2: Activate Plugin

1. Go to **Plugins** > **Installed Plugins**

2. Find "Global Power Bank Market Estimator"

3. Click **Activate**

4. **Market Estimator** menu will appear in left sidebar

### Step 3: Create Page

Same as Method 1 Step 3

---

## ⚠️ Troubleshooting

### Issue 1: Page shows "Calculator file not found"

**Solution:**

1. Check if file path is correct
   ```php
   // Add debug code in functions.php
   echo get_template_directory() . '/powerbank-calculator/embed.html';
   ```

2. Confirm files uploaded to correct location

3. Check file permissions (should be 644)
   ```bash
   chmod 644 embed.html script.js data.json
   chmod 755 powerbank-calculator/
   ```

### Issue 2: Blank page or style errors

**Solution:**

1. Clear WordPress cache (if using cache plugin)

2. Check browser console for errors (F12 > Console)

3. Confirm CDN links are accessible:
   - https://cdn.tailwindcss.com
   - https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js

4. Try adding to `functions.php`:
   ```php
   // Disable theme styles affecting the tool
   add_action('wp_head', function() {
       if (is_page('your-page-slug')) {
           echo '<style>#powerbank-estimator-app * { all: revert; }</style>';
       }
   });
   ```

### Issue 3: Chart.js charts not displaying

**Solution:**

1. Confirm Chart.js CDN loads properly

2. Check console for JavaScript errors

3. Try alternate CDN:
   ```php
   wp_enqueue_script('chartjs', 'https://unpkg.com/chart.js@4.4.0/dist/chart.umd.min.js');
   ```

### Issue 4: Data cannot load

**Solution:**

1. Confirm `data.json` file exists and is accessible

2. Access directly in browser:
   ```
   https://yoursite.com/wp-content/themes/your-theme/powerbank-calculator/data.json
   ```

3. Check JSON format is correct (use JSONLint validator)

### Issue 5: WordPress editor cannot save shortcode

**Solution:**

1. Switch to HTML/code view

2. Or use "Custom HTML" block (Gutenberg)

3. Or install "Shortcode Block" plugin

---

## 📱 Mobile Optimization

Ensure good display on mobile devices:

```php
// Add to functions.php
add_action('wp_head', function() {
    if (has_shortcode(get_post()->post_content, 'powerbank_calculator')) {
        ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <style>
        @media (max-width: 768px) {
            .powerbank-calculator-page {
                padding: 10px !important;
            }
        }
        </style>
        <?php
    }
});
```

---

## 🎯 Recommended Settings

### 1. Use Full-Width Page Template

In page editor right sidebar select:
- **Template**: Full Width / Canvas

### 2. Hide Page Title

Add custom CSS:
```css
.page-id-YOUR_PAGE_ID .entry-title {
    display: none;
}
```

### 3. Add to Menu

1. **Appearance** > **Menus**
2. Add your tool page to main navigation menu

---

## ✅ Verification Checklist

After deployment check:

- [ ] Files uploaded to correct location
- [ ] Shortcode added to functions.php
- [ ] Page created and published
- [ ] Page accessible
- [ ] Form can input data
- [ ] Step navigation works
- [ ] Calculation function works
- [ ] Charts display properly
- [ ] Language switch works
- [ ] Export functions (PDF/Excel) work
- [ ] Mobile display is good
- [ ] No JavaScript errors (F12 check)

---

## 📞 Need Help?

If you encounter issues:

1. Check browser console (F12 > Console)
2. View WordPress debug log
3. Confirm all files uploaded correctly
4. Try disabling other plugins to rule out conflicts

---

**After deployment, you'll have a fully functional market capacity estimation tool page!** 🎉
