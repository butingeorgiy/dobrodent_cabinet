export default class PatientsListView {
    constructor(btn, container, searchLoader) {
        this.btn = btn;
        this.container = container;
        this.searchLoader = searchLoader;
        this.shown = this._getAmount();
        this.full = false;
        this.step = 15;

        this.clear = this.clear.bind(this);
    }

    _getAmount() {
        return this.container.querySelectorAll('.patient-item').length;
    }

    getOffset() {
        return this.shown;
    }

    clear() {
        this.container.innerHTML = '';
    }

    reset(addListener, removeListener) {
        this.shown = 0;
        this.full = false;
        removeListener();
        addListener();
    }

    showLoader() {
        this.searchLoader.querySelector('.loader').classList.remove('hidden');
        this.searchLoader.querySelector('.non-loader').classList.add('hidden');
        this.btn.innerText = 'Идёт поиск ...';
    }

    hideLoader() {
        this.searchLoader.querySelector('.loader').classList.add('hidden');
        this.searchLoader.querySelector('.non-loader').classList.remove('hidden');
        this.btn.innerText = this.full ? 'Показаны все пациенты' : 'Показать больше';

        if (this._getAmount() === 0) {
            this.btn.innerText = 'Пациенты не найдены';
        }
    }

    render(patients, removeListener, mode, observeLinkListener) {
        this.shown += this.step;

        patients.forEach(patient => {
            const row = document.createElement('div');
            row.className = `flex patient-item flex-col md:flex-row ${patient.was_visit ? 'bg-yellow-50' : 'bg-white'} p-4 border-b border-gray-200 last:border-0`;

            row.innerHTML = `
                <div class="flex items-center mr-auto">
                    <div class="mr-2 sm:mr-4 border border-gray-200 rounded-full min-w-12 min-h-12 w-12 h-12 sm:min-w-16 sm:min-h-16 sm:w-16 sm:h-16 bg-center bg-cover bg-no-repeat"
                         style="background-image: url(${patient.profile_photo})"></div>
                    <div class="flex flex-col">
                        <a href="/${mode}/patients/${patient.id}" class="observer-link text-green-light sm:text-xl font-medium sm:mb-1 hover:underline">${ patient.full_name }</a>
                        <i class="text-gray-400">${patient.phone}</i>
                    </div>
                </div>
                <div class="flex items-center mt-4 sm:mt-6 md:mt-0 w-full md:w-auto">
                    <a href="/${mode}/visits/create?patient=${patient.id}"
                       class="flex items-center justify-center w-full px-4 py-2 border border-gray-500 text-gray-500 text-sm rounded-md transition duration-300 ease select-none hover:bg-gray-500 hover:border-gray-500 hover:text-white focus:outline-none focus:ring-4 focus:ring-gray-500 focus:ring-opacity-50">
                        <svg class="w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M8 7V3m8 4V3m-9 8h10M5
                                  21h14a2 2 0 002-2V7a2 2 0
                                  00-2-2H5a2 2 0 00-2 2v12a2
                                  2 0 002 2z"/>
                        </svg>
                        Записать на приём
                    </a>
                </div>
            `;

            observeLinkListener(row.querySelector('a.observer-link'));

            this.container.append(row);
        });

        if (this.shown - this._getAmount() > 0) {
            this.full = true;
            this.btn.innerText = 'Показаны все пациенты';
            removeListener();
        } else {
            this.btn.innerText = 'Показать больше';
        }
    }
}
