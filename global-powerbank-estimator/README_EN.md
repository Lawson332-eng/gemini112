# Global Power Bank Market Estimator

> AI-powered estimation based on population, economy & scenarios

[![Version](https://img.shields.io/badge/version-1.0.0-blue.svg)](https://github.com/yourusername/powerbank-estimator)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](LICENSE)

English | [简体中文](README.md)

## 📋 Table of Contents

- [Features](#features)
- [Demo](#demo)
- [Quick Start](#quick-start)
- [Calculation Model](#calculation-model)
- [WordPress Integration](#wordpress-integration)
- [File Structure](#file-structure)
- [Test Cases](#test-cases)
- [Browser Compatibility](#browser-compatibility)
- [Tech Stack](#tech-stack)
- [FAQ](#faq)
- [Changelog](#changelog)
- [License](#license)

## ✨ Features

### Core Features
- ✅ **Smart Estimation Algorithm** - Comprehensive model based on 6 coefficients
- ✅ **Step-by-Step Form** - Intuitive 4-step input process
- ✅ **Reference Cities** - Quick fill with 10+ major cities worldwide
- ✅ **Visual Charts** - Radar and bar chart analysis
- ✅ **Multi-language** - Chinese/English interface switching
- ✅ **Responsive Design** - Perfect for mobile and desktop
- ✅ **Data Export** - PDF reports, Excel, and shareable links
- ✅ **Pure Frontend** - No backend required, local calculations

### Technical Highlights
- 🚀 **Zero Installation** - All libraries loaded via CDN
- 🎨 **Custom Theme** - Brand color support (#070346, #FE714C, #E6F0EC)
- 📱 **PWA Ready** - Installable as Web App
- 🔒 **Privacy Protected** - All calculations done locally
- ⚡ **High Performance** - First load < 2s, calculation < 100ms

## 📸 Demo

### Desktop View
```
┌─────────────────────────────────────────┐
│  Global Power Bank Market Estimator     │
│  [中文] [EN]                            │
├─────────────────────────────────────────┤
│  Reference City: [Shenzhen ▼]          │
│                                         │
│  Step 1: Basic Info                     │
│  City Name: [________]                  │
│  Country: [China ▼]                     │
│                                         │
│  [Next]                                 │
└─────────────────────────────────────────┘
```

### Results
```
┌─────────────────────────────────────────┐
│  Estimated Total Devices                │
│  30.25 (10k)                            │
│  (302,500 devices)                      │
└─────────────────────────────────────────┘

┌─────────────────────────────────────────┐
│  Device Density                         │
│  60 people/device                       │
│  Global Baseline: 212 (China)           │
│  ⭐⭐⭐⭐⭐                              │
└─────────────────────────────────────────┘
```

## 🚀 Quick Start

### Method 1: Standalone Webpage

1. **Download Files**
   ```bash
   git clone https://github.com/yourusername/powerbank-estimator.git
   cd global-powerbank-estimator
   ```

2. **Open Directly**
   - Double-click `index.html` or
   - Use local server:
   ```bash
   python -m http.server 8000
   # Visit http://localhost:8000
   ```

3. **Start Using**
   - Select a reference city for quick fill or enter data manually
   - Complete the form step by step
   - Click "Calculate" to view results

### Method 2: WordPress Integration

#### Option A: Shortcode

1. **Upload Files**
   Upload to your theme directory:
   ```
   /wp-content/themes/your-theme/powerbank-calculator/
   ├── embed.html
   ├── script.js
   └── data.json
   ```

2. **Add Shortcode**
   In `functions.php`:
   ```php
   function powerbank_calculator_shortcode() {
       wp_enqueue_script('chartjs', 'https://cdn.jsdelivr.net/npm/chart.js@4');
       wp_enqueue_script('jspdf', 'https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js');

       ob_start();
       include(get_template_directory() . '/powerbank-calculator/embed.html');
       return ob_get_clean();
   }
   add_shortcode('powerbank_calculator', 'powerbank_calculator_shortcode');
   ```

3. **Use Shortcode**
   Add to any page or post:
   ```
   [powerbank_calculator]
   ```

#### Option B: Page Template

1. **Create Template**
   Create `page-calculator.php` in theme directory:
   ```php
   <?php
   /*
   Template Name: Powerbank Calculator
   */
   get_header();
   include 'powerbank-calculator/embed.html';
   get_footer();
   ?>
   ```

2. **Create Page**
   - Create new page in WordPress admin
   - Select template "Powerbank Calculator"
   - Publish

#### Option C: Elementor/Page Builders

1. Add HTML widget
2. Paste contents of `embed.html`
3. Ensure CDN links load properly

## 🧮 Calculation Model

### Core Formula

```
Device Capacity (10k) = Urban Population (10k) ÷ (Baseline Density ÷ Composite Coefficient)

Composite Coefficient = City Level × Economic × Density ×
                       Commercial × Mobile Payment × Climate
```

### Coefficient Details

#### 1. City Level Coefficient
Auto-determined by population:

| Level | Population | Range | Default |
|-------|-----------|-------|---------|
| Mega City | > 10M | 3.0 - 4.5 | 3.8 |
| Large City | 5-10M | 2.5 - 3.5 | 3.0 |
| Major City | 3-5M | 2.0 - 2.8 | 2.4 |
| Medium City | 1-3M | 1.5 - 2.2 | 1.8 |
| Small City | 0.5-1M | 1.0 - 1.5 | 1.2 |
| Mini City | < 0.5M | 0.6 - 1.0 | 0.8 |

#### 2. Economic Coefficient
Based on GDP per capita (USD):

| Level | GDP Range | Coefficient |
|-------|-----------|-------------|
| Very High | > $50k | 1.5 |
| High | $30k-50k | 1.3 |
| Upper Middle | $15k-30k | 1.1 |
| Middle | $8k-15k | 1.0 |
| Low | < $8k | 0.8 |

#### 3. Density Coefficient
Based on actual urban density (people/km²):

| Level | Density | Coefficient |
|-------|---------|-------------|
| Ultra High | ≥ 10000 | 1.4 |
| High | 5000-10000 | 1.25 |
| Medium High | 3000-5000 | 1.15 |
| Standard | 1500-3000 | 1.0 |
| Low | < 1500 | 0.8 |

#### 4. Commercial Coefficient
Based on number of major malls:

| Level | Count | Coefficient |
|-------|-------|-------------|
| Very High | > 10 | 1.4 |
| High | 6-10 | 1.25 |
| Medium | 3-5 | 1.1 |
| Low | 1-3 | 0.9 |
| Very Low | < 1 | 0.6 |

#### 5. Mobile Payment Coefficient
Based on penetration rate (%):

| Level | Rate | Coefficient |
|-------|------|-------------|
| Very High | > 80% | 1.4 |
| High | 60-80% | 1.2 |
| Medium | 40-60% | 1.05 |
| Low | 20-40% | 0.9 |
| Very Low | < 20% | 0.65 |

#### 6. Climate Coefficient

| Climate | Coefficient | Note |
|---------|-------------|------|
| Tropical/Subtropical | 1.2 | High temp, faster battery drain |
| Temperate | 1.05 | Standard climate |
| Cold/Highland | 0.95 | Low temp affects battery |

### Baseline Density

Regional baseline (people/device):

| Region | Baseline | Note |
|--------|----------|------|
| China | 212 | Most mature market |
| Japan | 250 | High-income market |
| South Korea | 250 | High-income market |
| Southeast Asia | 180 | Emerging market |
| Europe | 300 | Low mobile payment adoption |
| North America | 300 | Low mobile payment adoption |
| Middle East | 350 | High income, lower demand |
| Others | 320 | Global average |

## 📁 File Structure

```
global-powerbank-estimator/
├── index.html          # Standalone version (complete HTML)
├── embed.html          # WordPress embed version (no header/footer)
├── script.js           # Core calculation logic and UI
├── data.json           # Reference cities and coefficients
├── README.md           # Chinese documentation
├── README_EN.md        # English documentation
└── LICENSE             # MIT License
```

### File Dependencies

```
index.html
  ├── script.js (required)
  ├── data.json (required)
  ├── Tailwind CSS (CDN)
  ├── Chart.js (CDN)
  └── jsPDF (CDN)

embed.html (same as above)
```

## ✅ Test Cases

### Test 1: Shenzhen
```
Input:
- Population: 17.98M
- Area: 1997 km²
- GDP: $28,000
- Malls: 12

Expected Output:
- Devices: ~300k
- Density: ~60 people/device
- Rating: ⭐⭐⭐⭐⭐
```

### Test 2: Tokyo
```
Input:
- Population: 13.96M
- Area: 2194 km²
- GDP: $52,000
- Malls: 15

Expected Output:
- Devices: ~180k
- Density: ~78 people/device
- Rating: ⭐⭐⭐⭐⭐
```

### Test 3: Singapore
```
Input:
- Population: 5.64M
- Area: 733 km²
- GDP: $72,000
- Malls: 8

Expected Output:
- Devices: ~100k
- Density: ~56 people/device
- Rating: ⭐⭐⭐⭐⭐
```

## 🌐 Browser Compatibility

| Browser | Min Version | Status |
|---------|------------|--------|
| Chrome | 90+ | ✅ Passed |
| Firefox | 88+ | ✅ Passed |
| Safari | 14+ | ✅ Passed |
| Edge | 90+ | ✅ Passed |
| IE11 | - | ⚠️ Partial |

## 🛠 Tech Stack

- **Frontend**: Vanilla JavaScript (ES6+)
- **CSS**: Tailwind CSS 3.x (CDN)
- **Charts**: Chart.js 4.4.0
- **PDF**: jsPDF 2.5.1
- **Data**: JSON
- **Design**: Mobile-first Responsive

## ❓ FAQ

### Q1: How to customize theme colors?

**A**: Modify CSS variables in `index.html` or `embed.html`:

```css
:root {
    --primary: #070346;    /* Primary color */
    --secondary: #FE714C;  /* Accent color */
    --accent: #E6F0EC;     /* Supporting color */
}
```

### Q2: How to add new reference cities?

**A**: Edit `data.json` `referenceCities` array:

```json
{
  "name_zh": "北京",
  "name_en": "Beijing",
  "country": "china",
  "population": 2189,
  "area": 16410,
  "gdp": 25000,
  "malls": 20,
  "urbanRatio": 86,
  "mobilePay": 87
}
```

### Q3: Results seem inaccurate?

**A**: Adjust these parameters:
1. Verify input data accuracy (especially urban area)
2. Adjust coefficient ranges in `data.json`
3. Modify country baseline density

### Q4: How to disable a language?

**A**: Remove translation object in `script.js` and language switcher buttons.

### Q5: Can I use it offline?

**A**: Download CDN dependencies locally:
1. Download Tailwind CSS, Chart.js, jsPDF
2. Update script/link tags to local files
3. Use Service Worker for PWA caching

### Q6: Style conflicts in WordPress?

**A**: Use `embed.html` version - all styles scoped to `#powerbank-estimator-app`.

### Q7: How to add new countries?

**A**: Add to `countryDefaults` in `data.json`:

```json
"india": {
  "baseline": 250,
  "mobilePay": 45,
  "climate": "tropical",
  "urbanRatio": 35,
  "name_zh": "印度",
  "name_en": "India"
}
```

### Q8: How to customize calculation formula?

**A**: Modify `performCalculation()` method and coefficient functions in `script.js`.

## 📝 Changelog

### v1.0.0 (2025-01-15)
- ✨ Initial release
- ✅ 6-coefficient calculation model
- ✅ 10+ reference cities
- ✅ Chinese/English support
- ✅ PDF/Excel export
- ✅ WordPress integration
- ✅ Responsive design

## 🤝 Contributing

Issues and Pull Requests are welcome!

1. Fork the repository
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open Pull Request

## 📄 License

This project is licensed under the MIT License - see [LICENSE](LICENSE) file

## 📧 Contact

- Project: https://github.com/yourusername/powerbank-estimator
- Issues: https://github.com/yourusername/powerbank-estimator/issues
- Email: your.email@example.com

## 🙏 Acknowledgments

- [Tailwind CSS](https://tailwindcss.com/)
- [Chart.js](https://www.chartjs.org/)
- [jsPDF](https://github.com/parallax/jsPDF)
- Reference city data: Wikipedia

---

**⭐ If this project helps you, please give us a Star!**
