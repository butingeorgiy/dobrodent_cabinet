export default class DoctorsSearchView {
    constructor(containerNode, emptyIndicator, loader) {
        this._containerNode = containerNode;
        this._emptyIndicator = emptyIndicator;
        this._loader = loader;
        this._searchInProccessing = false;
    }

    render(doctors) {
        this._clearContainer();
        this._manageEmptyIndicator(true);

        if (doctors.length === 0) {
            this._manageEmptyIndicator(false);
        } else {
            doctors.forEach(item => {
                const row = document.createElement('div');
                row.className = 'flex bg-white p-4 border-b border-gray-200 last:border-0';

                row.innerHTML = `
                    <div class="flex mr-auto">
                        <div class="flex flex-col items-center mr-6">
                            <div class="mb-4 border border-gray-200 rounded-full w-16 h-16 bg-center bg-cover bg-no-repeat"
                                 style="background-image: url(${item.profile_photo})"></div>
                            <div class="flex items-center text-gray-400">
                                <svg class="w-5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M4.318 6.318a4.5 4.5 0 000
                                      6.364L12 20.364l7.682-7.682a4.5 4.5
                                      0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5
                                      4.5 0 00-6.364 0z"/>
                                </svg>
                                <span class="font-semibold" style="line-height: 1px">0</span>
                            </div>
                        </div>

                        <div class="flex flex-col">
                            <a href="/patient/doctors/${item.id}" class="text-green-light text-xl font-medium mb-2 hover:underline">${item.full_name}</a>
                            <i class="text-gray-400">Эндодонтист, Стоматолог-терапевт, Стоматолог-ортопед</i>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <a href="/patient/visits/create/?dest=d${item.id}"
                           class="flex items-center mr-4 px-4 py-2 border border-gray-500 text-gray-500 text-sm rounded-md transition duration-300 ease select-none hover:bg-gray-500 hover:border-gray-500 hover:text-white focus:outline-none focus:ring-4 focus:ring-gray-500 focus:ring-opacity-50">
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
                            Записаться на приём
                        </a>
                        <a href="#"
                           class="flex items-center px-4 py-2 border border-gray-500 text-gray-500 text-sm rounded-md transition duration-300 ease select-none hover:bg-gray-500 hover:border-gray-500 hover:text-white focus:outline-none focus:ring-4 focus:ring-gray-500 focus:ring-opacity-50">
                            <svg class="w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M8 12h.01M12 12h.01M16
                                      12h.01M21 12c0 4.418-4.03
                                      8-9 8a9.863 9.863 0 01-4.255-.949L3
                                      20l1.395-3.72C3.512 15.042 3 13.574
                                      3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            Оставить отзыв
                        </a>
                    </div>
                `;

                this._containerNode.append(row);
            });
        }
    }

    _clearContainer() {
        this._containerNode.innerHTML = '';
    }

    _manageEmptyIndicator(needToHide) {
        if (typeof needToHide !== 'boolean') {
            console.error(`Undefined value of needToHide variable: ${needToHide}`);
            return false;
        }

        if (needToHide) {
            this._emptyIndicator.classList.add('hidden');
        } else {
            this._emptyIndicator.classList.remove('hidden');
        }
    }

    manageLoaderIcon(needToShow) {
        if (typeof needToShow !== 'boolean') {
            console.error(`Undefined value of needToHide variable: ${needToShow}`);
            return false;
        }

        if (needToShow) {
            if (!this._searchInProccessing) {
                this._loader.querySelector('.loader').classList.remove('hidden');
                this._loader.querySelector('.non-loader').classList.add('hidden');

                this._searchInProccessing = true;
            }
        } else {
            if (this._searchInProccessing) {
                this._loader.querySelector('.loader').classList.add('hidden');
                this._loader.querySelector('.non-loader').classList.remove('hidden');

                this._searchInProccessing = false;
            }
        }
    }
}
