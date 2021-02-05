import Helper from "../../Helper";

export default class VisitsListView {
    constructor(btnNode, containerNode, amountIndicator) {
        this.btnNode = btnNode;
        this.containerNode = containerNode;
        this.amountIndicator = amountIndicator;
        this.shown = this._getAmount();
        this.step = 15;
        this.full = false;

        this.clear = this.clear.bind(this);
    }

    getOffset() {
        return this.shown;
    }

    reset(addListener, removeListener) {
        this.shown = 0;
        this.full = false;
        removeListener();
        addListener();
    }

    _getAmount() {
        return this.containerNode.querySelectorAll('.visit-item').length;
    }

    clear() {
        this.containerNode.innerHTML = '';
    }

    showLoader() {
        this.btnNode.innerText = 'Идёт загрузка ...';
    }

    render(visits, removeListener, mode) {
        if (!this.full) {
            this.shown += this.step;

            if (visits.length !== 0 && this.containerNode.classList.contains('hidden')) {
                this.containerNode.classList.remove('hidden');
            }

            visits.forEach(visit => {
                const row = document.createElement('div');
                row.className = 'flex px-4 even:bg-gray-50 visit-item';

                let doctorRow = '',
                    causeRow = '',
                    patientRow = '';

                if (visit.doctor !== null && (mode === 'administrator' || mode === 'patient')) {
                    doctorRow = `
                        <div class="flex mb-1">
                            <span class="flex items-center items-center sm:min-w-36 sm:w-36 font-medium text-green-light">
                                <svg class="w-5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M5.121 17.804A13.937 13.937
                                          0 0112 16c2.5 0 4.847.655 6.879
                                          1.804M15 10a3 3 0 11-6 0 3 3 0 016
                                          0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Врач:&nbsp;&nbsp;
                            </span>
                            <a href="${location.origin}/${mode}/doctors/${visit.doctor[0]}" class="text-gray-500 hover:underline">${visit.doctor[1]}</a>
                        </div>
                    `;
                }

                if (visit.patient !== null && (mode === 'administrator' || mode === 'doctor')) {
                    patientRow = `
                        <div class="flex mb-1">
                            <span class="flex items-center items-center sm:min-w-36 sm:w-36 font-medium text-green-light">
                                <svg class="w-5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M16 7a4 4 0 11-8 0
                                          4 4 0 018 0zM12 14a7
                                          7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Пациент:&nbsp;&nbsp;
                            </span>
                            <a href="${location.origin}/${mode}/patients/${visit.patient[0]}" class="text-gray-500 hover:underline">${visit.patient[1]}</a>
                        </div>
                    `;
                }

                if (visit.cause !== null) {
                    causeRow = `
                        <div class="flex">
                            <span class="flex items-center self-start sm:min-w-36 sm:w-36 font-medium text-green-light">
                                <svg class="w-5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M9 12h6m-6 4h6m2 5H7a2 2 0
                                          01-2-2V5a2 2 0 012-2h5.586a1 1
                                          0 01.707.293l5.414 5.414a1 1 0
                                          01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Причина:&nbsp;&nbsp;
                            </span>
                            <span class="text-gray-500">${Helper.strLimit(visit.cause, 50)}</span>
                        </div>
                    `;
                }

                row.innerHTML = `
                    <div class="flex flex-col justify-center mr-3 sm:mr-5">
                        <div class="h-14 border-l-2 sm:border-l-4 border-yellow-300 self-center"></div>
                        <div class="flex flex-col justify-center items-center min-h-14 w-14 h-14 sm:min-h-18 sm:h-18 sm:w-18 rounded-full border-2 sm:border-4 border-yellow-300">
                            <span class="text-gray-500 text-xs font-medium">${visit.date}</span>
                            <span class="text-gray-500 text-xs sm:text-sm font-bold sm:font-semibold">${visit.time}</span>
                        </div>
                        <div class="h-full border-l-2 sm:border-l-4 border-yellow-300 self-center"></div>
                    </div>
                    <div class="py-4 text-sm sm:text-base">
                        <a href="/${mode}/visits/${visit.id}" class="text-gray-400 text-base sm:text-xl font-medium hover:underline">Визит № ${visit.id}</a>
                        <div class="flex mt-2 sm:mt-4 mb-1">
                            <span class="flex items-center items-center sm:min-w-36 sm:w-36 font-medium text-green-light">
                                <svg class="w-5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M9 12l2 2 4-4m5.618-4.016A11.955
                                          11.955 0 0112 2.944a11.955 11.955 0
                                          01-8.618 3.04A12.02 12.02 0 003 9c0
                                          5.591 3.824 10.29 9 11.622 5.176-1.332
                                          9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                Статус:&nbsp;&nbsp;
                            </span>
                            <span class="text-gray-500">${visit.status}</span>
                        </div>
                        ${doctorRow}
                        ${patientRow}
                        ${causeRow}
                    </div>
            `;

                this.containerNode.append(row);
            });

            this.amountIndicator.innerText = this._getAmount();

            if (this.shown - this._getAmount() > 0) {
                this.full = true;
                this.btnNode.innerText = 'Показаны все визиты';
                removeListener();
            } else {
                this.btnNode.innerText = 'Показать больше';
            }

            if (this._getAmount() === 0) {
                this.btnNode.innerText = 'Визиты отсутствуют';
            }
        }
    }
}
