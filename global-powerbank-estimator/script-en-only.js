// Global Powerbank Market Estimator - English Only Version
// Simplified and optimized

class PowerbankEstimator {
  constructor() {
    this.data = null;
    this.currentStep = 1;
    this.formData = {};
    this.result = null;
    this.chart = null;
  }

  // Initialize
  async init() {
    try {
      // Use WordPress localized path (passed from functions.php)
      // Fallback to absolute path if localized variable not available
      const dataUrl = (typeof powerbankPaths !== 'undefined' && powerbankPaths.dataJsonUrl)
        ? powerbankPaths.dataJsonUrl
        : window.location.origin + '/wp-content/themes/gempo_child/powerbank-calculator/data.json';

      console.log('Loading data from:', dataUrl);
      const response = await fetch(dataUrl);

      if (!response.ok) {
        throw new Error(`Failed to load data.json (Status: ${response.status})`);
      }

      this.data = await response.json();
      console.log('Data loaded successfully:', this.data);
      this.setupEventListeners();
      this.updateUI();
    } catch (error) {
      console.error('Initialization error:', error);
      console.error('Error details:', {
        message: error.message,
        powerbankPaths: typeof powerbankPaths !== 'undefined' ? powerbankPaths : 'undefined'
      });
      alert('Failed to load calculator data. Please check console for details.');
    }
  }

  // Setup event listeners
  setupEventListeners() {
    const countrySelect = document.getElementById('country');
    if (countrySelect) {
      countrySelect.addEventListener('change', () => this.onCountryChange());
    }

    const refCitySelect = document.getElementById('referenceCity');
    if (refCitySelect) {
      refCitySelect.addEventListener('change', () => this.fillReferenceCity());
    }

    document.getElementById('nextBtn')?.addEventListener('click', () => this.nextStep());
    document.getElementById('prevBtn')?.addEventListener('click', () => this.prevStep());
    document.getElementById('calculateBtn')?.addEventListener('click', () => this.calculate());
    document.getElementById('resetBtn')?.addEventListener('click', () => this.reset());

    document.getElementById('downloadPDF')?.addEventListener('click', () => this.exportPDF());
    document.getElementById('downloadExcel')?.addEventListener('click', () => this.exportExcel());
    document.getElementById('shareLink')?.addEventListener('click', () => this.shareLink());

    // Slider updates
    document.getElementById('mobilePay')?.addEventListener('input', (e) => {
      document.getElementById('mobilePayValue').textContent = e.target.value + '%';
    });

    document.getElementById('urbanRatio')?.addEventListener('input', (e) => {
      document.getElementById('urbanRatioValue').textContent = e.target.value + '%';
    });
  }

  // Update UI
  updateUI() {
    this.updateCountryOptions();
    this.updateReferenceCities();
  }

  // Update country options
  updateCountryOptions() {
    const select = document.getElementById('country');
    if (!select || !this.data) return;

    select.innerHTML = '<option value="">Select Country</option>';

    Object.keys(this.data.countryDefaults).forEach(key => {
      const country = this.data.countryDefaults[key];
      const option = document.createElement('option');
      option.value = key;
      option.textContent = country.name_en;
      select.appendChild(option);
    });
  }

  // Update reference cities
  updateReferenceCities() {
    const select = document.getElementById('referenceCity');
    if (!select || !this.data) return;

    select.innerHTML = '<option value="">Quick Fill</option>';

    this.data.referenceCities.forEach((city, index) => {
      const option = document.createElement('option');
      option.value = index;
      option.textContent = city.name_en;
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

    document.getElementById('mobilePayValue').textContent = defaults.mobilePay + '%';
    document.getElementById('urbanRatioValue').textContent = defaults.urbanRatio + '%';
  }

  // Fill reference city data
  fillReferenceCity() {
    const index = document.getElementById('referenceCity').value;
    if (index === '' || !this.data) return;

    const city = this.data.referenceCities[index];

    document.getElementById('cityName').value = city.name_en;
    document.getElementById('country').value = city.country;
    document.getElementById('population').value = city.population;
    document.getElementById('area').value = city.area;
    document.getElementById('gdp').value = city.gdp;
    document.getElementById('malls').value = city.malls;
    document.getElementById('mobilePay').value = city.mobilePay;
    document.getElementById('urbanRatio').value = city.urbanRatio;

    document.getElementById('mobilePayValue').textContent = city.mobilePay + '%';
    document.getElementById('urbanRatioValue').textContent = city.urbanRatio + '%';

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
        if (i <= this.currentStep) {
          indicator.classList.add('active');
        } else {
          indicator.classList.remove('active');
        }
      }
    }

    document.getElementById('prevBtn').disabled = this.currentStep === 1;
    document.getElementById('nextBtn').classList.toggle('hidden', this.currentStep === 4);
    document.getElementById('calculateBtn').classList.toggle('hidden', this.currentStep !== 4);
  }

  // Core calculation
  calculate() {
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

    if (!this.validateForm()) {
      alert('Please fill all required fields');
      return;
    }

    this.result = this.performCalculation(this.formData);
    this.displayResults();
  }

  validateForm() {
    const requiredStrings = ['cityName', 'country'];
    const requiredNumbers = ['population', 'area', 'gdp', 'malls'];

    console.log('=== Form Validation Debug ===');
    console.log('Form Data:', this.formData);

    // Check string fields
    const stringResults = {};
    requiredStrings.forEach(field => {
      const value = this.formData[field];
      const isValid = value !== '' && value !== null && value !== undefined;
      stringResults[field] = { value, isValid };
      console.log(`String field "${field}":`, value, '→', isValid);
    });

    // Check number fields
    const numberResults = {};
    requiredNumbers.forEach(field => {
      const value = this.formData[field];
      const isValid = value !== '' && value !== null && value !== undefined && !isNaN(value);
      numberResults[field] = { value, isValid, isNaN: isNaN(value) };
      console.log(`Number field "${field}":`, value, '→', isValid, '(isNaN:', isNaN(value), ')');
    });

    const stringsValid = requiredStrings.every(field => stringResults[field].isValid);
    const numbersValid = requiredNumbers.every(field => numberResults[field].isValid);

    console.log('Strings valid:', stringsValid);
    console.log('Numbers valid:', numbersValid);
    console.log('Overall valid:', stringsValid && numbersValid);
    console.log('=== End Validation Debug ===');

    return stringsValid && numbersValid;
  }

  performCalculation(data) {
    const baseline = this.data.countryDefaults[data.country].baseline;
    const urbanPopulation = data.population * (data.urbanRatio / 100);
    const actualDensity = (urbanPopulation * 10000) / data.area;

    const coefficients = {
      cityLevel: this.getCityLevelCoef(data.population),
      economic: this.getEconomicCoef(data.gdp),
      density: this.getDensityCoef(actualDensity),
      commercial: this.getCommercialCoef(data.malls),
      mobilePay: this.getMobilePayCoef(data.mobilePay),
      climate: this.getClimateCoef(data.climate)
    };

    const compositeCoef = Object.values(coefficients).reduce((a, b) => a * b, 1);
    const adjustedDensity = baseline / compositeCoef;
    const deviceCapacity = urbanPopulation / adjustedDensity;
    const totalDevices = deviceCapacity * 10000;
    const peoplePerDevice = (urbanPopulation * 10000) / totalDevices;
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

  calculateRating(compositeCoef) {
    if (compositeCoef >= 2.5) return 5;
    if (compositeCoef >= 2.0) return 4;
    if (compositeCoef >= 1.5) return 3;
    if (compositeCoef >= 1.0) return 2;
    return 1;
  }

  displayResults() {
    document.getElementById('formContainer').classList.add('hidden');
    document.getElementById('resultContainer').classList.remove('hidden');

    this.fillResultCards();
    this.fillCalculationDetails();
    this.renderCharts();
    this.generateMarketAnalysis();
  }

  fillResultCards() {
    const r = this.result;

    document.getElementById('totalDevicesValue').textContent = `${r.deviceCapacity.toFixed(2)} (10k)`;
    document.getElementById('totalDevicesUnits').textContent = `(${r.totalDevices.toLocaleString()} devices)`;
    document.getElementById('densityValue').textContent = `${Math.round(r.peoplePerDevice)} people/device`;
    document.getElementById('densityBaseline').textContent =
      `Global Baseline: ${r.baseline} people/device (${this.data.countryDefaults[r.country].name_en})`;
    document.getElementById('densityRating').textContent = '⭐'.repeat(r.rating);
  }

  fillCalculationDetails() {
    const r = this.result;

    document.getElementById('urbanPopValue').textContent = `${r.urbanPopulation.toFixed(2)} (10k)`;
    document.getElementById('baselineValue').textContent = `${r.baseline} people/device`;
    document.getElementById('cityLevelValue').textContent = r.coefficients.cityLevel.toFixed(2);
    document.getElementById('economicValue').textContent = r.coefficients.economic.toFixed(2);
    document.getElementById('densityValue2').textContent = r.coefficients.density.toFixed(2);
    document.getElementById('commercialValue').textContent = r.coefficients.commercial.toFixed(2);
    document.getElementById('mobilePayValue2').textContent = r.coefficients.mobilePay.toFixed(2);
    document.getElementById('climateValue').textContent = r.coefficients.climate.toFixed(2);
    document.getElementById('compositeValue').textContent = r.compositeCoef.toFixed(2);
  }

  renderCharts() {
    this.renderRadarChart();
    this.renderComparisonChart();
  }

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
        labels: ['City Level', 'Economic', 'Density', 'Commercial', 'Mobile Pay', 'Climate'],
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
            ticks: { stepSize: 0.5 }
          }
        },
        plugins: {
          legend: { display: false }
        }
      }
    });
  }

  renderComparisonChart() {
    const ctx = document.getElementById('comparisonChart');
    if (!ctx) return;

    const r = this.result;

    const comparisons = this.data.referenceCities.slice(0, 5).map(city => {
      const result = this.performCalculation({
        cityName: city.name_en,
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
        name: city.name_en,
        devices: result.deviceCapacity
      };
    });

    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: [r.cityName, ...comparisons.map(c => c.name)],
        datasets: [{
          label: 'Total Devices',
          data: [r.deviceCapacity, ...comparisons.map(c => c.devices)],
          backgroundColor: ['#FE714C', '#E6F0EC', '#E6F0EC', '#E6F0EC', '#E6F0EC', '#E6F0EC'],
          borderColor: ['#FE714C', '#070346', '#070346', '#070346', '#070346', '#070346'],
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
          y: {
            beginAtZero: true,
            title: { display: true, text: '10k units' }
          }
        }
      }
    });
  }

  generateMarketAnalysis() {
    const r = this.result;
    const ratings = ['Poor', 'Average', 'Fair', 'Good', 'Excellent'];
    const ratingText = ratings[r.rating - 1] || 'Unknown';

    document.getElementById('marketRatingValue').textContent = '⭐'.repeat(r.rating) + ` ${ratingText}`;

    let features = [];
    if (r.coefficients.density >= 1.2) features.push('✓ High population density, suitable for dense deployment');
    if (r.coefficients.economic >= 1.2) features.push('✓ Strong economy, high purchasing power');
    if (r.coefficients.mobilePay < 1.0) features.push('⚠ Medium mobile payment penetration, requires promotion');
    if (r.coefficients.commercial >= 1.2) features.push('✓ Rich commercial scenarios, high demand');

    document.getElementById('marketFeatures').innerHTML = features.map(f => `<div class="mb-2">${f}</div>`).join('');

    const deviceDensityPerKm = (r.totalDevices / this.formData.area).toFixed(0);
    const marketSize = (r.totalDevices * 300 / 10000).toFixed(0);

    const suggestions = [
      `Prioritize commercial areas and transport hubs`,
      `Suggested density: ${deviceDensityPerKm} devices/km²`,
      `Estimated market size: $${marketSize}0k (device cost)`
    ];

    document.getElementById('marketSuggestions').innerHTML = suggestions.map(s => `<li>${s}</li>`).join('');
  }

  reset() {
    this.currentStep = 1;
    this.formData = {};
    this.result = null;

    document.getElementById('calculatorForm').reset();
    document.getElementById('formContainer').classList.remove('hidden');
    document.getElementById('resultContainer').classList.add('hidden');

    this.updateStepDisplay();
  }

  exportPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();
    const r = this.result;

    doc.setFontSize(18);
    doc.text('Power Bank Market Estimation Report', 20, 20);

    doc.setFontSize(12);
    doc.text(`City: ${r.cityName}`, 20, 40);
    doc.text(`Total Devices: ${r.deviceCapacity.toFixed(2)} (10k)`, 20, 50);
    doc.text(`Device Density: ${Math.round(r.peoplePerDevice)} people/device`, 20, 60);
    doc.text(`Composite Coefficient: ${r.compositeCoef.toFixed(2)}`, 20, 70);

    doc.save(`${r.cityName}-powerbank-estimation.pdf`);
  }

  exportExcel() {
    const r = this.result;

    const data = [
      ['City', r.cityName],
      ['Country', this.data.countryDefaults[r.country].name_en],
      ['Total Devices', `${r.deviceCapacity.toFixed(2)} (10k)`],
      ['Device Density', `${Math.round(r.peoplePerDevice)} people/device`],
      ['', ''],
      ['Coefficients', ''],
      ['City Level', r.coefficients.cityLevel.toFixed(2)],
      ['Economic', r.coefficients.economic.toFixed(2)],
      ['Density', r.coefficients.density.toFixed(2)],
      ['Commercial', r.coefficients.commercial.toFixed(2)],
      ['Mobile Payment', r.coefficients.mobilePay.toFixed(2)],
      ['Climate', r.coefficients.climate.toFixed(2)],
      ['Composite', r.compositeCoef.toFixed(2)]
    ];

    let csv = data.map(row => row.join(',')).join('\n');
    const blob = new Blob(['\ufeff' + csv], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = `${r.cityName}-powerbank-estimation.csv`;
    link.click();
  }

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
      urbanRatio: this.formData.urbanRatio
    });

    const url = `${window.location.origin}${window.location.pathname}?${params.toString()}`;

    navigator.clipboard.writeText(url).then(() => {
      alert('Link copied to clipboard!');
    });
  }

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

// Initialize
document.addEventListener('DOMContentLoaded', () => {
  const estimator = new PowerbankEstimator();
  estimator.init();
  estimator.loadFromURL();
  window.estimator = estimator;
});
