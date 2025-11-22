# English Version Setup Guide

## 🌐 Language Options

Your Power Bank Market Estimator tool supports both **Chinese** and **English**!

---

## Option 1: User Switches Language (Recommended)

The tool has built-in language switcher buttons in the top-right corner:

- **[中文]** - Switch to Chinese
- **[EN]** - Switch to English

Users can click these buttons anytime to change the language.

**No setup required!** This works out of the box.

---

## Option 2: Default English Version

If you want the tool to **display English by default**, you have several options:

### A. Use URL Parameter

Add `?lang=en-US` to your page URL:

```
https://yoursite.com/market-estimator/?lang=en-US
```

This will open the page in English automatically.

### B. Use English-Specific Shortcode

**Step 1:** Upload the English version file

Upload `embed-en.html` to:
```
/wp-content/themes/your-theme/powerbank-calculator/embed-en.html
```

**Step 2:** Add this code to `functions.php`:

```php
// English Version Shortcode
function powerbank_calculator_en_shortcode() {
    wp_enqueue_script('tailwind', 'https://cdn.tailwindcss.com');
    wp_enqueue_script('chartjs', 'https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js');
    wp_enqueue_script('jspdf', 'https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js');
    wp_enqueue_script('powerbank-calc', get_template_directory_uri() . '/powerbank-calculator/script.js', array('chartjs'), '1.0', true);

    ob_start();
    include(get_template_directory() . '/powerbank-calculator/embed-en.html');
    return ob_get_clean();
}
add_shortcode('powerbank_calculator_en', 'powerbank_calculator_en_shortcode');
```

**Step 3:** Use the English shortcode in your page:

```
[powerbank_calculator_en]
```

This will always show the English version.

---

## Option 3: Auto-Detect Language

Want the tool to automatically show the right language based on the user's browser?

**Step 1:** Add this code to `functions.php`:

```php
function powerbank_calculator_auto_shortcode() {
    // Check URL parameter first
    $lang = isset($_GET['lang']) ? $_GET['lang'] : '';

    // Check browser language if no URL parameter
    if (empty($lang)) {
        $browser_lang = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) : 'en';
        $lang = ($browser_lang === 'zh') ? 'zh' : 'en';
    }

    // Load appropriate version
    if (strpos($lang, 'zh') !== false) {
        include(get_template_directory() . '/powerbank-calculator/embed.html'); // Chinese
    } else {
        include(get_template_directory() . '/powerbank-calculator/embed-en.html'); // English
    }
}
add_shortcode('powerbank_calculator_auto', 'powerbank_calculator_auto_shortcode');
```

**Step 2:** Use the auto-detect shortcode:

```
[powerbank_calculator_auto]
```

This will:
- Show **English** for English-speaking users
- Show **Chinese** for Chinese-speaking users
- Allow manual override with `?lang=en` or `?lang=zh` parameter

---

## Quick Summary

| Method | Shortcode | Behavior |
|--------|-----------|----------|
| **Original** | `[powerbank_calculator]` | Chinese by default, manual switch available |
| **English Default** | `[powerbank_calculator_en]` | Always English, manual switch available |
| **Auto-Detect** | `[powerbank_calculator_auto]` | Detects browser language automatically |

---

## Complete WordPress Integration Files

For full bilingual support, use:

1. **`wordpress-integration-en.php`** - Contains all 3 shortcode options
2. Copy the code to your `functions.php`
3. Upload both `embed.html` (Chinese) and `embed-en.html` (English)

---

## File Checklist

Make sure you have these files uploaded:

```
/wp-content/themes/your-theme/powerbank-calculator/
├── embed.html        ← Chinese version
├── embed-en.html     ← English version
├── script.js         ← Required (same for both)
└── data.json         ← Required (same for both)
```

---

## Testing

1. **Chinese Version:**
   ```
   yoursite.com/page/?lang=zh-CN
   ```

2. **English Version:**
   ```
   yoursite.com/page/?lang=en-US
   ```

3. **Auto-Detect:**
   ```
   yoursite.com/page/
   ```
   (Will show language based on browser settings)

---

## Need Help?

- Check browser console (F12) for errors
- Confirm all files are uploaded
- Verify shortcode is correct
- Clear WordPress cache

**The tool supports full bilingual functionality!** 🌍🇬🇧🇨🇳
