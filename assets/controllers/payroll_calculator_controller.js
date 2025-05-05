import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
  static targets = [ 'months', 'years', 'results'];
  connect() {
    this.#populateYearOptions();
    this.#populateMonthOptions();
  }

  async calculate(event) {
    event.preventDefault();
    const results = await this.#callApi()
    if (results) {
      this.#showResults(results);
    }
  }

  #showResults(results) {
    const months = this.#getMonths();

    this.resultsTarget.innerHTML = `
      <p class="font-medium mb-2">
        The payroll dates for ${months[this.monthsTarget.value]}, ${this.yearsTarget.value} are:
      </p>
      <ul class="list-disc list-inside space-y-1">
        <li>
          <span class="font-semibold text-gray-700">Payment date:</span>
          <span class="text-cyan-600 font-medium">${results['payment_date']}</span>
        </li>
        <li>
          <span class="font-semibold text-gray-700">Payday:</span>
          <span class="text-cyan-600 font-medium">${results['payday']}</span>
        </li>
      </ul>
    `;
    this.resultsTarget.classList.remove('hidden')
  }

  #getYears() {
    const currentYear = new Date().getFullYear();
    let years = [];
    for (let i = 0; i < 5; i++) {
      years.push(currentYear + i);
    }
    return years;
  }

  #getMonths() {
    return  {
      1: 'January',
      2: 'February',
      3: 'March',
      4: 'April',
      5: 'May',
      6: 'June',
      7: 'July',
      8: 'August',
      9: 'September',
      10: 'October',
      11: 'November',
      12: 'December',
    };
  }

  #populateYearOptions() {
    const years = this.#getYears();
    this.yearsTarget.innerHTML = years
      .map(year => `<option value="${year}">${year}</option>`)
      .join('');
  }
  #populateMonthOptions() {
    const months = this.#getMonths();
    this.monthsTarget.innerHTML = Object.entries(months)
      .map(([value, label]) => `<option value="${value}">${label}</option>`)
      .join('');
  }

  async #callApi() {
    try {
      const response = await fetch("http://127.0.0.1:8000/api/payroll/dates", {
        method: "POST",
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          month: this.monthsTarget.value,
          year: this.yearsTarget.value,
        })
      });

      if (!response.ok) throw new Error(`HTTP ${response.status}`);

      return await response.json();
    } catch (error) {
      console.error("API error:", error);
      this.resultsTarget.innerHTML = `<p class="text-red-600">There was an error fetching the results. Please try again.</p>`;
      this.resultsTarget.classList.remove('hidden');

      return false;
    }
  }
}
