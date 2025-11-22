// Global Powerbank Market Estimator - Core Logic
// Version: 1.0.0

class PowerbankEstimator {
  constructor() {
    this.data = null;
    this.currentLang = 'zh-CN';
    this.currentStep = 1;
    this.formData = {};
    this.result = null;
    this.chart = null;
  }

  // Initialize
  async init() {
    try {
      const response = await fetch('data.json');
      this.data = await response.json();
      this.setupEventListeners();
      this.detectLanguage();
      this.updateUI();
    } catch (error) {
      console.error('Failed to load data:', error);
    }
  }

  // Language detection
  detectLanguage() {
    const urlParams = new URLSearchParams(window.location.search);
    const langParam = urlParams.get('lang');

    if (langParam) {
      this.currentLang = langParam;
    } else {
      const browserLang = navigator.language || navigator.userLanguage;
      if (browserLang.startsWith('zh')) {
        this.currentLang = 'zh-CN';
      } else if (browserLang.startsWith('ja')) {
        this.currentLang = 'ja-JP';
      } else if (browserLang.startsWith('ko')) {
        this.currentLang = 'ko-KR';
      } else {
        this.currentLang = 'en-US';
      }
    }
  }

  // Get translation
  t(key) {
    const translations = {
      'zh-CN': {
        title: '全球共享充电宝市场容量预估工具',
        subtitle: '基于城市人口、经济与场景的智能预估系统',
        step1: '步骤 1: 基础信息',
        step2: '步骤 2: 人口与经济',
        step3: '步骤 3: 商业与场景',
        step4: '步骤 4: 高级选项',
        cityName: '城市名称',
        cityNamePlaceholder: '例如: 深圳',
        country: '国家/地区',
        selectCountry: '请选择国家',
        population: '常住人口 (万人)',
        area: '城市行政区面积 (km²)',
        gdp: '人均GDP (美元)',
        malls: '大型商业综合体数量',
        mallsHint: '日均客流10万+的购物中心/CBD数量',
        mobilePay: '移动支付普及率 (%)',
        climate: '气候类型',
        urbanRatio: '城区人口占比 (%)',
        next: '下一步',
        previous: '上一步',
        calculate: '开始计算',
        reset: '重置',
        loading: '计算中...',
        resultTitle: '预估结果',
        totalDevices: '预估设备总量',
        deviceDensity: '设备密度',
        globalBaseline: '全球基准',
        peoplePerDevice: '人/台',
        calculationDetails: '计算明细',
        urbanPopulation: '城区人口',
        baselineDensity: '基准密度',
        coefficients: '系数组成',
        cityLevelCoef: '城市等级系数',
        economicCoef: '经济系数',
        densityCoef: '人口密度系数',
        commercialCoef: '商业场景系数',
        mobilePayCoef: '移动支付系数',
        climateCoef: '气候系数',
        compositeCoef: '综合系数',
        marketRating: '市场评级',
        marketFeatures: '市场特征',
        suggestions: '建议',
        downloadPDF: '下载PDF报告',
        downloadExcel: '导出Excel',
        shareLink: '分享链接',
        referenceCities: '参考城市',
        quickFill: '快速填充',
        advancedOptions: '高级选项',
        showAdvanced: '显示高级选项',
        hideAdvanced: '隐藏高级选项',
        tropical: '热带/亚热带',
        temperate: '温带',
        cold: '寒带/高原',
        wikiHint: '提示：可在Wikipedia查询',
        uncertainty: '不确定',
        copiedLink: '链接已复制!',
        errorTitle: '输入错误',
        errorMessage: '请填写所有必填字段',
        chartTitle: '系数贡献分析',
        comparisonTitle: '与参考城市对比',
        devices: '台',
        tenThousand: '万台',
        rating5: '优秀',
        rating4: '良好',
        rating3: '中等',
        rating2: '一般',
        rating1: '较差'
      },
      'en-US': {
        title: 'Global Power Bank Market Estimator',
        subtitle: 'AI-powered estimation based on population, economy & scenarios',
        step1: 'Step 1: Basic Info',
        step2: 'Step 2: Population & Economy',
        step3: 'Step 3: Commercial & Scenarios',
        step4: 'Step 4: Advanced Options',
        cityName: 'City Name',
        cityNamePlaceholder: 'e.g., Shenzhen',
        country: 'Country/Region',
        selectCountry: 'Select Country',
        population: 'Population (10k)',
        area: 'City Area (km²)',
        gdp: 'GDP per Capita (USD)',
        malls: 'Number of Major Malls',
        mallsHint: 'Shopping centers with 100k+ daily visitors',
        mobilePay: 'Mobile Payment Penetration (%)',
        climate: 'Climate Type',
        urbanRatio: 'Urban Population Ratio (%)',
        next: 'Next',
        previous: 'Previous',
        calculate: 'Calculate',
        reset: 'Reset',
        loading: 'Calculating...',
        resultTitle: 'Estimation Results',
        totalDevices: 'Estimated Total Devices',
        deviceDensity: 'Device Density',
        globalBaseline: 'Global Baseline',
        peoplePerDevice: 'people/device',
        calculationDetails: 'Calculation Details',
        urbanPopulation: 'Urban Population',
        baselineDensity: 'Baseline Density',
        coefficients: 'Coefficients',
        cityLevelCoef: 'City Level',
        economicCoef: 'Economic',
        densityCoef: 'Density',
        commercialCoef: 'Commercial',
        mobilePayCoef: 'Mobile Payment',
        climateCoef: 'Climate',
        compositeCoef: 'Composite',
        marketRating: 'Market Rating',
        marketFeatures: 'Market Features',
        suggestions: 'Suggestions',
        downloadPDF: 'Download PDF',
        downloadExcel: 'Export Excel',
        shareLink: 'Share Link',
        referenceCities: 'Reference Cities',
        quickFill: 'Quick Fill',
        advancedOptions: 'Advanced Options',
        showAdvanced: 'Show Advanced',
        hideAdvanced: 'Hide Advanced',
        tropical: 'Tropical/Subtropical',
        temperate: 'Temperate',
        cold: 'Cold/Highland',
        wikiHint: 'Hint: Check Wikipedia',
        uncertainty: 'Uncertain',
        copiedLink: 'Link copied!',
        errorTitle: 'Input Error',
        errorMessage: 'Please fill all required fields',
        chartTitle: 'Coefficient Analysis',
        comparisonTitle: 'City Comparison',
        devices: 'devices',
        tenThousand: '10k',
        rating5: 'Excellent',
        rating4: 'Good',
        rating3: 'Fair',
        rating2: 'Average',
        rating1: 'Poor'
      }
    };

    return translations[this.currentLang]?.[key] || key;
  }

  // Setup event listeners
  setupEventListeners() {
    // Language switcher
    document.querySelectorAll('[data-lang]').forEach(btn => {
      btn.addEventListener('click', (e) => {
        this.currentLang = e.target.dataset.lang;
        this.updateUI();
      });
    });

    // Country selector
    const countrySelect = document.getElementById('country');
    if (countrySelect) {
      countrySelect.addEventListener('change', () => {
        this.onCountryChange();
      });
    }

    // Reference city selector
    const refCitySelect = document.getElementById('referenceCity');
    if (refCitySelect) {
      refCitySelect.addEventListener('change', () => {
        this.fillReferenceCity();
      });
    }

    // Form navigation
    document.getElementById('nextBtn')?.addEventListener('click', () => this.nextStep());
    document.getElementById('prevBtn')?.addEventListener('click', () => this.prevStep());
    document.getElementById('calculateBtn')?.addEventListener('click', () => this.calculate());
    document.getElementById('resetBtn')?.addEventListener('click', () => this.reset());

    // Advanced options toggle
    document.getElementById('toggleAdvanced')?.addEventListener('click', () => {
      this.toggleAdvanced();
    });

    // Export buttons
    document.getElementById('downloadPDF')?.addEventListener('click', () => this.exportPDF());
    document.getElementById('downloadExcel')?.addEventListener('click', () => this.exportExcel());
    document.getElementById('shareLink')?.addEventListener('click', () => this.shareLink());
  }

  // Update UI with current language
  updateUI() {
    document.querySelectorAll('[data-i18n]').forEach(el => {
      const key = el.dataset.i18n;
      el.textContent = this.t(key);
    });

    document.querySelectorAll('[data-i18n-placeholder]').forEach(el => {
      const key = el.dataset.i18nPlaceholder;
      el.placeholder = this.t(key);
    });

    this.updateCountryOptions();
    this.updateReferenceCities();
  }

  // Update country options
  updateCountryOptions() {
    const select = document.getElementById('country');
    if (!select || !this.data) return;

    const nameKey = this.currentLang === 'zh-CN' ? 'name_zh' : 'name_en';
    select.innerHTML = `<option value="">${this.t('selectCountry')}</option>`;

    Object.keys(this.data.countryDefaults).forEach(key => {
      const country = this.data.countryDefaults[key];
      const option = document.createElement('option');
      option.value = key;
      option.textContent = country[nameKey];
      select.appendChild(option);
    });
  }

  // Update reference cities
  updateReferenceCities() {
    const select = document.getElementById('referenceCity');
    if (!select || !this.data) return;

    const nameKey = this.currentLang === 'zh-CN' ? 'name_zh' : 'name_en';
    select.innerHTML = `<option value="">${this.t('quickFill')}</option>`;

    this.data.referenceCities.forEach((city, index) => {
      const option = document.createElement('option');
      option.value = index;
      option.textContent = city[nameKey];
      select.appendChild(option);
    });
  }

  // Country change handler
  onCountryChange() {
    const country = document.getElementById('country').value;
    if (!country || !this.data) return;

    const defaults = this.data.countryDefaults[country];
    document.getElementById('mobilePay').value = defaults.mobilePay;
    document.getElementById('climate').value = defaults.climate;
    document.getElementById('urbanRatio').value = defaults.urbanRatio;
  }

  // Fill reference city data
  fillReferenceCity() {
    const index = document.getElementById('referenceCity').value;
    if (index === '' || !this.data) return;

    const city = this.data.referenceCities[index];
    const nameKey = this.currentLang === 'zh-CN' ? 'name_zh' : 'name_en';

    document.getElementById('cityName').value = city[nameKey];
    document.getElementById('country').value = city.country;
    document.getElementById('population').value = city.population;
    document.getElementById('area').value = city.area;
    document.getElementById('gdp').value = city.gdp;
    document.getElementById('malls').value = city.malls;
    document.getElementById('mobilePay').value = city.mobilePay;
    document.getElementById('urbanRatio').value = city.urbanRatio;

    this.onCountryChange();
  }

  // Step navigation
  nextStep() {
    if (this.currentStep < 4) {
      this.currentStep++;
      this.updateStepDisplay();
    }
  }

  prevStep() {
    if (this.currentStep > 1) {
      this.currentStep--;
      this.updateStepDisplay();
    }
  }

  updateStepDisplay() {
    for (let i = 1; i <= 4; i++) {
      const step = document.getElementById(`step${i}`);
      const indicator = document.querySelector(`[data-step="${i}"]`);

      if (step) {
        step.classList.toggle('hidden', i !== this.currentStep);
      }
      if (indicator) {
        indicator.classList.toggle('active', i <= this.currentStep);
      }
    }

    document.getElementById('prevBtn').disabled = this.currentStep === 1;
    document.getElementById('nextBtn').classList.toggle('hidden', this.currentStep === 4);
    document.getElementById('calculateBtn').classList.toggle('hidden', this.currentStep !== 4);
  }

  // Toggle advanced options
  toggleAdvanced() {
    const advanced = document.getElementById('advancedOptions');
    const btn = document.getElementById('toggleAdvanced');

    advanced.classList.toggle('hidden');
    btn.textContent = advanced.classList.contains('hidden')
      ? this.t('showAdvanced')
      : this.t('hideAdvanced');
  }

  // Core calculation
  calculate() {
    // Gather form data
    this.formData = {
      cityName: document.getElementById('cityName').value,
      country: document.getElementById('country').value,
      population: parseFloat(document.getElementById('population').value),
      area: parseFloat(document.getElementById('area').value),
      gdp: parseFloat(document.getElementById('gdp').value),
      malls: parseInt(document.getElementById('malls').value),
      mobilePay: parseFloat(document.getElementById('mobilePay').value),
      climate: document.getElementById('climate').value,
      urbanRatio: parseFloat(document.getElementById('urbanRatio').value)
    };

    // Validation
    if (!this.validateForm()) {
      alert(this.t('errorMessage'));
      return;
    }

    // Calculate
    this.result = this.performCalculation(this.formData);

    // Display results
    this.displayResults();
  }

  // Form validation
  validateForm() {
    const required = ['cityName', 'country', 'population', 'area', 'gdp', 'malls'];
    return required.every(field => this.formData[field] !== '' && !isNaN(this.formData[field]));
  }

  // Main calculation logic
  performCalculation(data) {
    // Get baseline density
    const baseline = this.data.countryDefaults[data.country].baseline;

    // Calculate urban population
    const urbanPopulation = data.population * (data.urbanRatio / 100);

    // Calculate actual density
    const actualDensity = (urbanPopulation * 10000) / data.area;

    // Calculate coefficients
    const coefficients = {
      cityLevel: this.getCityLevelCoef(data.population),
      economic: this.getEconomicCoef(data.gdp),
      density: this.getDensityCoef(actualDensity),
      commercial: this.getCommercialCoef(data.malls),
      mobilePay: this.getMobilePayCoef(data.mobilePay),
      climate: this.getClimateCoef(data.climate)
    };

    // Composite coefficient
    const compositeCoef = Object.values(coefficients).reduce((a, b) => a * b, 1);

    // Calculate device capacity
    const adjustedDensity = baseline / compositeCoef;
    const deviceCapacity = urbanPopulation / adjustedDensity;

    // Calculate metrics
    const totalDevices = deviceCapacity * 10000; // Convert to units
    const peoplePerDevice = (urbanPopulation * 10000) / totalDevices;

    // Market rating
    const rating = this.calculateRating(compositeCoef);

    return {
      cityName: data.cityName,
      country: data.country,
      baseline,
      urbanPopulation,
      actualDensity,
      coefficients,
      compositeCoef,
      deviceCapacity,
      totalDevices,
      peoplePerDevice,
      rating,
      adjustedDensity
    };
  }

  // Coefficient calculators
  getCityLevelCoef(population) {
    const coefs = this.data.coefficients.cityLevel;
    if (population >= 1000) return coefs.mega.default;
    if (population >= 500) return coefs.large.default;
    if (population >= 300) return coefs.major.default;
    if (population >= 100) return coefs.medium.default;
    if (population >= 50) return coefs.small.default;
    return coefs.mini.default;
  }

  getEconomicCoef(gdp) {
    const coefs = this.data.coefficients.economic;
    if (gdp >= 50000) return coefs.very_high.default;
    if (gdp >= 30000) return coefs.high.default;
    if (gdp >= 15000) return coefs.upper_middle.default;
    if (gdp >= 8000) return coefs.middle.default;
    return coefs.low.default;
  }

  getDensityCoef(density) {
    const coefs = this.data.coefficients.density;
    if (density >= 10000) return coefs.ultra_high.default;
    if (density >= 5000) return coefs.high.default;
    if (density >= 3000) return coefs.medium_high.default;
    if (density >= 1500) return coefs.standard.default;
    return coefs.low.default;
  }

  getCommercialCoef(malls) {
    const coefs = this.data.coefficients.commercial;
    if (malls > 10) return coefs.very_high.default;
    if (malls >= 6) return coefs.high.default;
    if (malls >= 3) return coefs.medium.default;
    if (malls >= 1) return coefs.low.default;
    return coefs.very_low.default;
  }

  getMobilePayCoef(rate) {
    const coefs = this.data.coefficients.mobilePay;
    if (rate > 80) return coefs.very_high.default;
    if (rate >= 60) return coefs.high.default;
    if (rate >= 40) return coefs.medium.default;
    if (rate >= 20) return coefs.low.default;
    return coefs.very_low.default;
  }

  getClimateCoef(climate) {
    return this.data.coefficients.climate[climate].default;
  }

  // Calculate market rating
  calculateRating(compositeCoef) {
    if (compositeCoef >= 2.5) return 5;
    if (compositeCoef >= 2.0) return 4;
    if (compositeCoef >= 1.5) return 3;
    if (compositeCoef >= 1.0) return 2;
    return 1;
  }

  // Display results
  displayResults() {
    // Hide form, show results
    document.getElementById('formContainer').classList.add('hidden');
    document.getElementById('resultContainer').classList.remove('hidden');

    // Fill result data
    this.fillResultCards();
    this.fillCalculationDetails();
    this.renderCharts();
    this.generateMarketAnalysis();
  }

  // Fill result cards
  fillResultCards() {
    const r = this.result;

    document.getElementById('totalDevicesValue').textContent =
      `${r.deviceCapacity.toFixed(2)} ${this.t('tenThousand')}`;

    document.getElementById('totalDevicesUnits').textContent =
      `(${r.totalDevices.toLocaleString()} ${this.t('devices')})`;

    document.getElementById('densityValue').textContent =
      `${Math.round(r.peoplePerDevice)} ${this.t('peoplePerDevice')}`;

    document.getElementById('densityBaseline').textContent =
      `${this.t('globalBaseline')}: ${r.baseline}${this.t('peoplePerDevice')} (${this.data.countryDefaults[r.country][this.currentLang === 'zh-CN' ? 'name_zh' : 'name_en']})`;

    // Rating stars
    const stars = '⭐'.repeat(r.rating);
    document.getElementById('densityRating').textContent = stars;
  }

  // Fill calculation details
  fillCalculationDetails() {
    const r = this.result;

    document.getElementById('urbanPopValue').textContent =
      `${r.urbanPopulation.toFixed(2)}${this.t('tenThousand')}`;

    document.getElementById('baselineValue').textContent =
      `${r.baseline}${this.t('peoplePerDevice')}`;

    document.getElementById('cityLevelValue').textContent = r.coefficients.cityLevel.toFixed(2);
    document.getElementById('economicValue').textContent = r.coefficients.economic.toFixed(2);
    document.getElementById('densityValue2').textContent = r.coefficients.density.toFixed(2);
    document.getElementById('commercialValue').textContent = r.coefficients.commercial.toFixed(2);
    document.getElementById('mobilePayValue').textContent = r.coefficients.mobilePay.toFixed(2);
    document.getElementById('climateValue').textContent = r.coefficients.climate.toFixed(2);
    document.getElementById('compositeValue').textContent = r.compositeCoef.toFixed(2);
  }

  // Render charts
  renderCharts() {
    this.renderRadarChart();
    this.renderComparisonChart();
  }

  // Render radar chart
  renderRadarChart() {
    const ctx = document.getElementById('radarChart');
    if (!ctx) return;

    if (this.chart) {
      this.chart.destroy();
    }

    const r = this.result;

    this.chart = new Chart(ctx, {
      type: 'radar',
      data: {
        labels: [
          this.t('cityLevelCoef'),
          this.t('economicCoef'),
          this.t('densityCoef'),
          this.t('commercialCoef'),
          this.t('mobilePayCoef'),
          this.t('climateCoef')
        ],
        datasets: [{
          label: r.cityName,
          data: [
            r.coefficients.cityLevel,
            r.coefficients.economic,
            r.coefficients.density,
            r.coefficients.commercial,
            r.coefficients.mobilePay,
            r.coefficients.climate
          ],
          backgroundColor: 'rgba(254, 113, 76, 0.2)',
          borderColor: '#FE714C',
          borderWidth: 2,
          pointBackgroundColor: '#FE714C',
          pointBorderColor: '#fff',
          pointHoverBackgroundColor: '#fff',
          pointHoverBorderColor: '#FE714C'
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          r: {
            beginAtZero: true,
            max: 2,
            ticks: {
              stepSize: 0.5
            }
          }
        },
        plugins: {
          legend: {
            display: false
          }
        }
      }
    });
  }

  // Render comparison chart
  renderComparisonChart() {
    const ctx = document.getElementById('comparisonChart');
    if (!ctx) return;

    const r = this.result;

    // Compare with reference cities
    const comparisons = this.data.referenceCities.slice(0, 5).map(city => {
      const result = this.performCalculation({
        cityName: city[this.currentLang === 'zh-CN' ? 'name_zh' : 'name_en'],
        country: city.country,
        population: city.population,
        area: city.area,
        gdp: city.gdp,
        malls: city.malls,
        mobilePay: city.mobilePay,
        climate: this.data.countryDefaults[city.country].climate,
        urbanRatio: city.urbanRatio
      });
      return {
        name: city[this.currentLang === 'zh-CN' ? 'name_zh' : 'name_en'],
        devices: result.deviceCapacity
      };
    });

    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: [r.cityName, ...comparisons.map(c => c.name)],
        datasets: [{
          label: this.t('totalDevices'),
          data: [r.deviceCapacity, ...comparisons.map(c => c.devices)],
          backgroundColor: [
            '#FE714C',
            '#E6F0EC',
            '#E6F0EC',
            '#E6F0EC',
            '#E6F0EC',
            '#E6F0EC'
          ],
          borderColor: [
            '#FE714C',
            '#070346',
            '#070346',
            '#070346',
            '#070346',
            '#070346'
          ],
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            title: {
              display: true,
              text: this.t('tenThousand')
            }
          }
        }
      }
    });
  }

  // Generate market analysis
  generateMarketAnalysis() {
    const r = this.result;
    const ratingText = this.t(`rating${r.rating}`);

    document.getElementById('marketRatingValue').textContent =
      `⭐`.repeat(r.rating) + ` ${ratingText}`;

    // Features
    let features = [];
    if (r.coefficients.density >= 1.2) {
      features.push(this.currentLang === 'zh-CN'
        ? '✓ 人口密度高，适合密集铺设'
        : '✓ High population density, suitable for dense deployment');
    }
    if (r.coefficients.economic >= 1.2) {
      features.push(this.currentLang === 'zh-CN'
        ? '✓ 经济发达，支付能力强'
        : '✓ Strong economy, high purchasing power');
    }
    if (r.coefficients.mobilePay < 1.0) {
      features.push(this.currentLang === 'zh-CN'
        ? '⚠ 移动支付普及率中等，需配套推广'
        : '⚠ Medium mobile payment penetration, requires promotion');
    }
    if (r.coefficients.commercial >= 1.2) {
      features.push(this.currentLang === 'zh-CN'
        ? '✓ 商业场景丰富，需求旺盛'
        : '✓ Rich commercial scenarios, high demand');
    }

    document.getElementById('marketFeatures').innerHTML =
      features.map(f => `<div class="mb-2">${f}</div>`).join('');

    // Suggestions
    const deviceDensityPerKm = (r.totalDevices / this.formData.area).toFixed(0);
    const marketSize = (r.totalDevices * 300 / 10000).toFixed(0); // Assume $300 per device

    const suggestions = this.currentLang === 'zh-CN' ? [
      `建议优先布局商业区和交通枢纽`,
      `建议铺设密度: ${deviceDensityPerKm}台/km²`,
      `预估市场规模: $${marketSize}万 (设备成本)`
    ] : [
      `Prioritize commercial areas and transport hubs`,
      `Suggested density: ${deviceDensityPerKm} devices/km²`,
      `Estimated market size: $${marketSize}0k (device cost)`
    ];

    document.getElementById('marketSuggestions').innerHTML =
      suggestions.map(s => `<li>${s}</li>`).join('');
  }

  // Reset
  reset() {
    this.currentStep = 1;
    this.formData = {};
    this.result = null;

    document.getElementById('calculatorForm').reset();
    document.getElementById('formContainer').classList.remove('hidden');
    document.getElementById('resultContainer').classList.add('hidden');

    this.updateStepDisplay();
  }

  // Export PDF
  async exportPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    const r = this.result;
    const title = this.currentLang === 'zh-CN'
      ? '共享充电宝市场容量预估报告'
      : 'Power Bank Market Estimation Report';

    doc.setFontSize(18);
    doc.text(title, 20, 20);

    doc.setFontSize(12);
    doc.text(`${this.t('cityName')}: ${r.cityName}`, 20, 40);
    doc.text(`${this.t('totalDevices')}: ${r.deviceCapacity.toFixed(2)} ${this.t('tenThousand')}`, 20, 50);
    doc.text(`${this.t('deviceDensity')}: ${Math.round(r.peoplePerDevice)} ${this.t('peoplePerDevice')}`, 20, 60);
    doc.text(`${this.t('compositeCoef')}: ${r.compositeCoef.toFixed(2)}`, 20, 70);

    doc.save(`${r.cityName}-powerbank-estimation.pdf`);
  }

  // Export Excel
  exportExcel() {
    const r = this.result;

    const data = [
      [this.t('cityName'), r.cityName],
      [this.t('country'), this.data.countryDefaults[r.country][this.currentLang === 'zh-CN' ? 'name_zh' : 'name_en']],
      [this.t('totalDevices'), `${r.deviceCapacity.toFixed(2)} ${this.t('tenThousand')}`],
      [this.t('deviceDensity'), `${Math.round(r.peoplePerDevice)} ${this.t('peoplePerDevice')}`],
      ['', ''],
      [this.t('coefficients'), ''],
      [this.t('cityLevelCoef'), r.coefficients.cityLevel.toFixed(2)],
      [this.t('economicCoef'), r.coefficients.economic.toFixed(2)],
      [this.t('densityCoef'), r.coefficients.density.toFixed(2)],
      [this.t('commercialCoef'), r.coefficients.commercial.toFixed(2)],
      [this.t('mobilePayCoef'), r.coefficients.mobilePay.toFixed(2)],
      [this.t('climateCoef'), r.coefficients.climate.toFixed(2)],
      [this.t('compositeCoef'), r.compositeCoef.toFixed(2)]
    ];

    let csv = data.map(row => row.join(',')).join('\n');
    const blob = new Blob(['\ufeff' + csv], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = `${r.cityName}-powerbank-estimation.csv`;
    link.click();
  }

  // Share link
  shareLink() {
    const params = new URLSearchParams({
      city: this.formData.cityName,
      country: this.formData.country,
      pop: this.formData.population,
      area: this.formData.area,
      gdp: this.formData.gdp,
      malls: this.formData.malls,
      mobilePay: this.formData.mobilePay,
      climate: this.formData.climate,
      urbanRatio: this.formData.urbanRatio,
      lang: this.currentLang
    });

    const url = `${window.location.origin}${window.location.pathname}?${params.toString()}`;

    navigator.clipboard.writeText(url).then(() => {
      alert(this.t('copiedLink'));
    });
  }

  // Load from URL parameters
  loadFromURL() {
    const params = new URLSearchParams(window.location.search);

    if (params.has('city')) {
      document.getElementById('cityName').value = params.get('city');
      document.getElementById('country').value = params.get('country');
      document.getElementById('population').value = params.get('pop');
      document.getElementById('area').value = params.get('area');
      document.getElementById('gdp').value = params.get('gdp');
      document.getElementById('malls').value = params.get('malls');
      document.getElementById('mobilePay').value = params.get('mobilePay');
      document.getElementById('climate').value = params.get('climate');
      document.getElementById('urbanRatio').value = params.get('urbanRatio');
    }
  }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', () => {
  const estimator = new PowerbankEstimator();
  estimator.init();
  estimator.loadFromURL();

  // Make globally accessible
  window.estimator = estimator;
});
