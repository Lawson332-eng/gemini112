# JuuPower Website Integration Guide
## Power Bank ROI Calculator

Quick integration guide for embedding the ROI calculator into your JuuPower website.

---

## 🎨 Your Brand Colors (Applied)

✅ **Primary Color**: `#070346` (Dark Navy Blue)
✅ **Background Color**: `#E6F0EC` (Light Green-Gray)
✅ **Accent Color**: `#FD6450` (Coral Red)

All colors have been customized to match your website perfectly!

---

## 🚀 Quick Start (5 Minutes)

### Step 1: Upload Calculator File

Upload `calculator-embed-en.html` to your website:

**Option A: Via FTP (Recommended)**
```
Upload to: /wp-content/themes/your-theme/calculator/
File: calculator-embed-en.html
```

**Option B: Via WordPress Media Library**
```
1. Install "File Manager" plugin
2. Navigate to: wp-content/themes/your-theme/
3. Create folder: calculator
4. Upload: calculator-embed-en.html
```

**Option C: Via cPanel File Manager**
```
1. Login to cPanel
2. Go to File Manager
3. Navigate to: public_html/wp-content/themes/your-theme/
4. Create folder: calculator
5. Upload: calculator-embed-en.html
```

---

### Step 2: Add Integration Code

**Method A: Theme Functions (Recommended)**

1. Go to: `Appearance` → `Theme File Editor`
2. Select: `functions.php` (right sidebar)
3. Scroll to the bottom
4. Copy and paste the entire content of `shortcode-juupower.php`
5. Click `Update File`

**Method B: Code Snippets Plugin** (Safer)

1. Install plugin: "Code Snippets"
2. Go to: `Snippets` → `Add New`
3. Paste the code from `shortcode-juupower.php`
4. Give it a title: "ROI Calculator"
5. Click `Save Changes and Activate`

---

### Step 3: Add Calculator to Your Page

**In WordPress Page Editor:**

1. Edit the page where you want the calculator (e.g., "Product" or "ROI Calculator" page)
2. Add a new block / switch to text mode
3. Insert the shortcode:

```
[powerbank_roi_calculator]
```

4. Publish/Update the page
5. View your page - the calculator should appear!

---

## 🎯 Shortcode Usage Examples

### Basic Calculator
```
[powerbank_roi_calculator]
```

### Custom Height
```
[powerbank_roi_calculator height="1000"]
```

### With Default Parameters
```
[powerbank_roi_calculator sites="100" orders="2.5" price="18"]
```

### Call-to-Action Button
```
[roi_calculator_button text="Calculate Your ROI" style="gradient"]
```

### Button Styles
```
Gradient style (default):
[roi_calculator_button text="Get Started" style="gradient"]

Solid style:
[roi_calculator_button text="Calculate Now" style="solid"]

Outline style:
[roi_calculator_button text="Learn More" style="outline"]
```

---

## 📱 Integration Examples

### Example 1: Full Page Calculator

Create a new page called "ROI Calculator" and add:

```html
<div style="max-width: 1400px; margin: 0 auto; padding: 20px;">
    <h2 style="text-align: center; color: #070346; margin-bottom: 30px;">
        Calculate Your Investment Returns
    </h2>

    [powerbank_roi_calculator]

    <p style="text-align: center; color: #666; margin-top: 20px;">
        Need help? Contact us: <a href="mailto:info@juupower.com" style="color: #FD6450;">info@juupower.com</a>
    </p>
</div>
```

### Example 2: Calculator Section in Content

Add within your existing page content:

```html
<section style="background: #E6F0EC; padding: 60px 20px; margin: 40px 0; border-radius: 15px;">
    <div style="max-width: 1200px; margin: 0 auto; text-align: center;">
        <h2 style="color: #070346; margin-bottom: 20px;">
            Calculate Your ROI
        </h2>
        <p style="color: #666; margin-bottom: 40px; font-size: 18px;">
            See how much you can earn with our power bank sharing system
        </p>

        [powerbank_roi_calculator height="1000"]
    </div>
</section>
```

### Example 3: CTA Button in Sidebar

Add to your sidebar or widget area:

```html
<div style="background: linear-gradient(135deg, #070346, #0a0557); padding: 30px; border-radius: 15px; text-align: center; color: white;">
    <h3 style="color: white; margin-bottom: 15px;">
        Ready to Start?
    </h3>
    <p style="margin-bottom: 20px; opacity: 0.9;">
        Calculate your potential returns in minutes
    </p>

    [roi_calculator_button text="Calculate ROI Now" style="gradient"]
</div>
```

### Example 4: Hero Section Integration

Add to your home page hero section:

```html
<div class="hero-section" style="text-align: center; padding: 80px 20px;">
    <h1 style="color: #070346; font-size: 48px; margin-bottom: 20px;">
        We Cut Your Operating Costs
    </h1>

    <p style="font-size: 20px; color: #666; margin-bottom: 40px;">
        Waterproof Design | Reverse Charging Technology | ODM/OEM Factory
    </p>

    [roi_calculator_button text="Calculate Your ROI →" style="gradient"]

    <p style="margin-top: 20px; color: #999;">
        Or <a href="/product" style="color: #FD6450; text-decoration: underline;">view all stations</a>
    </p>
</div>
```

---

## 🎨 Customization Options

### Adjust Colors (If Needed)

If you need to tweak colors, edit `calculator-embed-en.html`:

```css
/* Find these color variables around line 30-35 */
.gradient-bg {
    background: linear-gradient(135deg, #070346 0%, #0a0557 100%);
}

.gradient-accent {
    background: linear-gradient(135deg, #FD6450 0%, #ff8570 100%);
}

/* Background color */
body {
    background: #E6F0EC;
}
```

### Adjust Iframe Height

For different content lengths:

```
Short content (basic info only):
[powerbank_roi_calculator height="800"]

Standard (with charts):
[powerbank_roi_calculator height="1200"]

Extended (all features):
[powerbank_roi_calculator height="1400"]
```

### Mobile Optimization

The calculator automatically adjusts for mobile devices. You can customize mobile behavior in `shortcode-juupower.php`:

```php
@media (max-width: 768px) {
    .juupower-calculator-wrapper iframe {
        height: auto !important;
        min-height: 800px; /* Adjust this value */
    }
}
```

---

## 🔧 Troubleshooting

### Calculator Not Showing?

**Check 1: File Path**
```
Verify file exists at:
/wp-content/themes/your-theme/calculator/calculator-embed-en.html

Test by visiting directly:
https://yourdomain.com/wp-content/themes/your-theme/calculator/calculator-embed-en.html
```

**Check 2: Shortcode Spelling**
```
✅ Correct: [powerbank_roi_calculator]
❌ Wrong: [roi_calculator] (unless you used the alias)
❌ Wrong: [powerbank-roi-calculator] (use underscore, not dash)
```

**Check 3: Browser Console**
```
1. Open page with calculator
2. Press F12 (Developer Tools)
3. Check Console tab for errors
4. Look for red error messages
```

### Styles Look Wrong?

**Solution 1: Clear Cache**
```
1. Clear browser cache (Ctrl+F5)
2. Clear WordPress cache (if using cache plugin)
3. Clear CDN cache (if using Cloudflare/similar)
```

**Solution 2: Check Theme Conflicts**
```php
Add to functions.php to isolate calculator styles:

.juupower-calculator-wrapper * {
    all: revert !important;
}
```

### Height Issues on Mobile?

**Solution: Adjust Mobile Height**
```
[powerbank_roi_calculator height="1200"]

On mobile, it auto-adjusts to minimum 800px.
Change this in the CSS if needed.
```

### Iframe Not Responsive?

**Solution: Check Container Width**
```css
Ensure parent container allows full width:

.page-content {
    max-width: 100% !important;
    padding: 0 20px;
}
```

---

## 📊 Analytics Tracking (Optional)

### Track Calculator Usage with Google Analytics

Add to `shortcode-juupower.php`:

```php
function juupower_calculator_tracking() {
    ?>
    <script>
    // Track calculator views
    if (typeof gtag !== 'undefined') {
        gtag('event', 'view_calculator', {
            'event_category': 'ROI Calculator',
            'event_label': 'Calculator Loaded'
        });
    }

    // Track export button clicks
    document.addEventListener('click', function(e) {
        if (e.target.closest('.export-button')) {
            gtag('event', 'export', {
                'event_category': 'ROI Calculator',
                'event_label': 'Export Clicked'
            });
        }
    });
    </script>
    <?php
}
add_action('wp_footer', 'juupower_calculator_tracking');
```

---

## 🎯 Recommended Page Structure

### Option 1: Dedicated Calculator Page

```
Page Title: ROI Calculator
URL: /roi-calculator/

Content Structure:
1. Hero section with headline
2. Brief introduction (2-3 sentences)
3. [powerbank_roi_calculator]
4. FAQ section below
5. Contact CTA
```

### Option 2: Calculator Section in Product Page

```
Page: Product
URL: /product/

Content Structure:
1. Product features
2. Technical specifications
3. Calculator section:
   - Section heading
   - [powerbank_roi_calculator]
4. Case studies
5. Get started CTA
```

### Option 3: Popup/Modal Calculator

```
Add button anywhere:
[roi_calculator_button text="Calculate ROI"]

Opens calculator in:
- New tab (default)
- Or modal (requires custom JS)
```

---

## ✅ Post-Installation Checklist

After integration, verify these items:

- [ ] Calculator loads without errors
- [ ] Colors match JuuPower brand (#070346, #E6F0EC, #FD6450)
- [ ] All input fields are functional
- [ ] Charts render correctly
- [ ] Export to Excel works
- [ ] Mobile responsive (test on phone)
- [ ] Loads quickly (under 3 seconds)
- [ ] No console errors (F12 to check)
- [ ] Shortcode works on multiple pages
- [ ] Button links work correctly

---

## 🆘 Need Help?

### Contact Support
- **Email**: info@juupower.com
- **Phone**: [Your phone number]
- **Live Chat**: [If available]

### Documentation
- Full Integration Guide: `INTEGRATION.md`
- Calculator Usage: `USAGE.md`
- WordPress Plugin: `powerbank-roi-calculator/README.md`

### Common Issues
1. **"404 Not Found"** → Check file path
2. **"Blank white space"** → Check browser console
3. **"Styles broken"** → Clear cache
4. **"Not responsive"** → Check theme width settings

---

## 🚀 Go Live Checklist

Before launching to public:

1. **Test on Multiple Devices**
   - [ ] Desktop (Chrome, Firefox, Safari)
   - [ ] Mobile (iOS Safari, Android Chrome)
   - [ ] Tablet (iPad, Android)

2. **Performance Check**
   - [ ] Page load time < 3 seconds
   - [ ] Calculator responds instantly
   - [ ] No JavaScript errors
   - [ ] Images optimized

3. **SEO Optimization**
   - [ ] Page title includes "ROI Calculator"
   - [ ] Meta description added
   - [ ] H1/H2 tags properly used
   - [ ] Alt text for images

4. **Analytics Setup**
   - [ ] Google Analytics tracking
   - [ ] Conversion goals configured
   - [ ] Event tracking enabled
   - [ ] Heatmap tool installed (optional)

5. **Marketing Preparation**
   - [ ] Social media posts scheduled
   - [ ] Email campaign ready
   - [ ] Blog post published
   - [ ] Screenshots taken

---

## 📈 Success Metrics

Track these KPIs after launch:

- **Engagement**: Time on calculator page
- **Conversions**: Contact form submissions after calculator use
- **Exports**: Number of Excel downloads
- **Shares**: Link share button clicks
- **Mobile vs Desktop**: Usage breakdown

---

## 🎓 Training Resources

### Video Tutorials (Coming Soon)
- Installation walkthrough
- Customization guide
- WordPress integration best practices

### Blog Posts
- "How to Calculate ROI for Power Bank Sharing"
- "5 Tips to Maximize Your Investment Returns"
- "Case Study: 200% ROI in 8 Months"

---

**Version**: 1.0.0
**Last Updated**: 2025-01-06
**Compatible With**: WordPress 5.0+, All modern browsers
**Support**: info@juupower.com

---

## 🎉 You're All Set!

Your calculator is ready to help customers make data-driven investment decisions.

**Next Steps:**
1. ✅ Follow the Quick Start guide above
2. ✅ Test thoroughly on your devices
3. ✅ Share the page link with your team
4. ✅ Launch and promote!

**Need immediate help?** Email us at info@juupower.com - we typically respond within 2 hours during business hours.
