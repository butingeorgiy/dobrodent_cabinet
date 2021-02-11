export default class FullSearchView {
    constructor(loader, container, containerWrapper, inputWrapper) {
        this.loader = loader;
        this.container = container;
        this.containerWrapper = containerWrapper;
        this.inputWrapper = inputWrapper;
        this.isShown = this.getResultsAmount() > 0;
    }

    showContainer() {
        if (!this.isShown) {
            this.isShown = true;
            this.containerWrapper.classList.remove('hidden');
            this.container.classList.add('border-t-0');
            this.inputWrapper.classList.remove('rounded-md');
            this.inputWrapper.classList.add('rounded-t-md');
        }
    }

    hideContainer() {
        if (this.isShown) {
            this.isShown = false;
            this.containerWrapper.classList.add('hidden');
            this.container.classList.remove('border-t-0');
            this.inputWrapper.classList.add('rounded-md');
            this.inputWrapper.classList.remove('rounded-t-md');
        }
    }

    showLoader() {
        this.loader.querySelector('.loader').classList.remove('hidden');
        this.loader.querySelector('.non-loader').classList.add('hidden');
    }

    hideLoader() {
        this.loader.querySelector('.loader').classList.add('hidden');
        this.loader.querySelector('.non-loader').classList.remove('hidden');
    }

    getResultsAmount() {
        return this.container.querySelectorAll('.global-search-item').length;
    }

    clearContainer() {
        this.container.innerHTML = '';
    }

    render(results, observeLinkListener, mode) {
        let isEmpty = true;
        const doctors = results.doctors || [];
        const visits = results.visits || [];
        const patients = results.patients || [];

        this.clearContainer();
        this.hideLoader();

        if (patients.length > 0) {
            isEmpty = false;
            this.container.innerHTML = `<p class="mx-4 first:mt-0 mb-2 text-sm text-gray-500">Пациенты:</p>`;

            patients.forEach(patient => {
                this.container.innerHTML += `
                    <a href="/${mode}/patients/${patient.id}" class="global-search-item observer-link flex min-h-14 px-4 py-2 hover:bg-gray-50 cursor-pointer">
                        <div class="min-w-10 min-h-10 w-10 h-10 mr-2 sm:mr-4 bg-center bg-no-repeat bg-contain rounded-full border border-gray-300"
                             style="background-image: url(${patient.profile_photo})"></div>
                        <div class="flex flex-col">
                            <p class="mb-1 text-green-light font-medium leading-5">${patient.full_name}</p>
                            <i class="text-sm text-gray-400 leading-4">${patient.phone}</i>
                        </div>
                    </a>
                `;

                observeLinkListener(this.container.querySelector('a.observer-link:last-child'));
            });
        }

        if (doctors.length > 0) {
            isEmpty = false;
            this.container.innerHTML += `<p class="mx-4 mt-4 mb-2 first:mt-0 text-sm text-gray-500">Врачи:</p>`;

            doctors.forEach(doctor => {
                this.container.innerHTML += `
                    <a href="/${mode}/doctors/${doctor.id}" class="global-search-item observer-link flex min-h-14 px-4 py-2 hover:bg-gray-50 cursor-pointer">
                        <div class="min-w-10 min-h-10 w-10 h-10 mr-2 sm:mr-4 bg-center bg-no-repeat bg-contain rounded-full border border-gray-300"
                             style="background-image: url(${doctor.profile_photo})"></div>
                        <div class="flex flex-col">
                            <p class="mb-1 text-green-light font-medium leading-5">${doctor.full_name}</p>
                            <i class="text-sm text-gray-400 leading-4">${doctor.occupation}</i>
                        </div>
                    </a>
                `;

                observeLinkListener(this.container.querySelector('a.observer-link:last-child'));
            });
        }

        if (visits.length > 0) {
            isEmpty = false;
            this.container.innerHTML += `<p class="mx-4 mt-4 first:mt-0 mb-2 text-sm text-gray-500">Визиты:</p>`;

            visits.forEach(visit => {
                this.container.innerHTML += `
                    <a href="/${mode}/visits/${visit.id}" class="global-search-item observer-link flex min-h-14 px-4 py-2 hover:bg-gray-50 cursor-pointer">
                        <div class="flex justify-center items-center min-w-10 min-h-10 w-10 h-10 mr-2 sm:mr-4 bg-center bg-no-repeat bg-contain rounded-full border border-yellow-300">
                            <p class="text-gray-500 text-xs font-medium">${visit.visit_date}</p>
                        </div>
                        <div class="flex flex-col">
                            <p class="mb-1 text-green-light font-medium leading-5">Визит № ${visit.id}</p>
                            <i class="text-sm text-gray-400 leading-4">${mode === 'doctor' ? 'Пациент:' : 'Леч. врач:'} <span class="text-gray-500">${mode === 'doctor' ? visit.patient_full_name : visit.doctor_full_name}</span></i>
                        </div>
                    </a>
                `;

                observeLinkListener(this.container.querySelector('a.observer-link:last-child'));
            });
        }

        if (isEmpty) {
            this.container.innerHTML = `<i class="mx-4 mb-2 text-gray-400 text-sm leading-5">По вашему запросу ничего не найдено ...</i>`;
        }
    }
}
