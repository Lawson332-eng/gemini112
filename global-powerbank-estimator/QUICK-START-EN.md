# WordPress Quick Deploy - 5 Minutes

## 🚀 Just 3 Steps to Deploy!

---

## Step 1: Upload Files (2 minutes)

### Via FTP/File Manager:

1. Open your FTP software or host file manager

2. Navigate to:
   ```
   /wp-content/themes/your-theme-name/
   ```

3. Create folder: `powerbank-calculator`

4. Upload these 3 files:
   - ✅ `embed.html`
   - ✅ `script.js`
   - ✅ `data.json`

**Final path should be:**
```
/wp-content/themes/your-theme/powerbank-calculator/
├── embed.html
├── script.js
└── data.json
```

---

## Step 2: Add Code (1 minute)

1. Log in to WordPress admin

2. Go to: **Appearance** > **Theme File Editor**

3. Select on the right: **Theme Functions (functions.php)**

4. Scroll to the bottom of the file

5. Copy and paste this code:

```php
// Power Bank Market Estimator Tool
function powerbank_calculator_shortcode() {
    wp_enqueue_script('tailwind', 'https://cdn.tailwindcss.com');
    wp_enqueue_script('chartjs', 'https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js');
    wp_enqueue_script('jspdf', 'https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js');
    wp_enqueue_script('powerbank-calc', get_template_directory_uri() . '/powerbank-calculator/script.js', array('chartjs'), '1.0', true);

    ob_start();
    include(get_template_directory() . '/powerbank-calculator/embed.html');
    return ob_get_clean();
}
add_shortcode('powerbank_calculator', 'powerbank_calculator_shortcode');
```

6. Click: **Update File**

---

## Step 3: Create Page (2 minutes)

1. Go to: **Pages** > **Add New**

2. Enter title:
   ```
   Market Capacity Estimator
   ```

3. In content area, enter shortcode:
   ```
   [powerbank_calculator]
   ```

   **Note:**
   - If using Gutenberg Editor: Click **+** > Select **Shortcode** block > Enter shortcode above
   - If using Classic Editor: Switch to **Text** mode > Enter shortcode above

4. (Optional) Set on the right sidebar:
   - **Template**: Select "Full Width" or "Canvas" (if available)
   - **Permalink**: Change to `market-estimator`

5. Click: **Publish**

6. Click: **View Page**

---

## ✅ Done!

You should now see the tool running properly!

### Feature Test:

- ✅ Can select reference cities
- ✅ Can switch languages (Chinese/English)
- ✅ Can input data and calculate
- ✅ Can see charts
- ✅ Can export PDF/Excel

---

## ⚠️ If You Encounter Issues

### Issue 1: Shows "File not found"

**Cause**: Incorrect file path

**Solution**:
1. Confirm files uploaded to correct location
2. Check theme name is correct
3. Try refreshing page

### Issue 2: Blank page

**Cause**: Code error

**Solution**:
1. Check if code in functions.php is complete
2. Ensure no extra spaces or characters
3. Check browser console (press F12) for errors

### Issue 3: Style issues

**Cause**: Theme style conflicts

**Solution**:
1. Select "Full Width" page template
2. Clear cache (if using cache plugin)
3. Refresh browser

---

## 📱 Page Link

Tool page default address:
```
https://yourwebsite.com/market-estimator/
```

You can:
- Add to main menu
- Share with users
- Embed in other pages

---

## 🎨 Customize Colors

To modify colors, edit this part in `embed.html`:

```css
:root {
    --primary: #070346;    /* Primary color */
    --secondary: #FE714C;  /* Accent color */
    --accent: #E6F0EC;     /* Supporting color */
}
```

---

## 📞 Need Detailed Tutorial?

Check complete documentation:
- **WORDPRESS-SETUP-EN.md** - Detailed deployment guide
- **README_EN.md** - Feature description
- **DEPLOYMENT.md** - Advanced configuration

---

**That's it! Enjoy your new tool!** 🎉
