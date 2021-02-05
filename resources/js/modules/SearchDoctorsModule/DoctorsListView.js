export default class DoctorsListView {
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
        return this.container.querySelectorAll('.doctor-item').length;
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
        this.btn.innerText = this.full ? 'Показаны все врачи' : 'Показать больше';

        if (this._getAmount() === 0) {
            this.btn.innerText = 'Врачи не найдены';
        }
    }

    render(doctors, removeListener, mode, addToFavoriteListener, observeLinkListener) {
        this.shown += this.step;

        doctors.forEach(item => {
            const row = document.createElement('div');
            row.className = 'doctor-item flex flex-col lg:flex-row bg-white p-4 border-b border-gray-200 last:border-0';

            const createVisitBtn = `
                <a href="/${mode}/visits/create/?dest=d${item.id}"
                   class="flex items-center justify-center w-full lg:w-auto ${mode === 'patient' ? 'md:mr-4 mb-2 md:mb-0' : ''} px-4 py-2 border border-gray-500 text-gray-500 text-sm rounded-md transition duration-300 ease select-none hover:bg-gray-500 hover:border-gray-500 hover:text-white focus:outline-none focus:ring-4 focus:ring-gray-500 focus:ring-opacity-50">
                    <svg class="w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M8 7V3m8 4V3m-9 8h10M5
                              21h14a2 2 0 002-2V7a2 2 0
                              00-2-2H5a2 2 0 00-2 2v12a2
                              2 0 002 2z" />
                    </svg>
                    ${mode === 'administrator' ? 'Записать на приём' : 'Записаться на приём'}
                </a>
            `;

            const createReviewBtn = `
                <a href="/${mode}/doctors/${item.id}/#create-review"
                   class="flex items-center justify-center w-full lg:w-auto px-4 py-2 border border-gray-500 text-gray-500 text-sm rounded-md transition duration-300 ease select-none hover:bg-gray-500 hover:border-gray-500 hover:text-white focus:outline-none focus:ring-4 focus:ring-gray-500 focus:ring-opacity-50">
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
            `;

            row.innerHTML = `
                <div class="flex mr-auto w-full lg:w-auto">
                    <div class="flex lg:flex-col items-center w-full">
                        <div class="flex mr-auto">
                            <div class="min-w-12 min-h-12 w-12 h-12 sm:min-w-16 sm:min-h-16 sm:w-16 sm:h-16 mr-2 sm:mr-4 mb-4 border border-gray-200 rounded-full bg-center bg-cover bg-no-repeat"
                                 style="background-image: url(${item.profile_photo})"></div>

                            <div class="flex flex-col">
                                <a href="/${mode}/doctors/${item.id}" class="observer-link mb-1 text-green-light sm:text-xl font-medium leading-5 hover:underline">${item.full_name}</a>
                                <i class="mb-4 text-gray-400 text-sm sm:text-base">${item.occupation}</i>
                            </div>
                        </div>
                        <div class="flex items-center self-start ml-3.5 text-gray-400 like-doctor-btn ${item.is_liked ? 'active' : ''} ${mode === 'patient' ? 'cursor-pointer' : ''}">
                            <svg class="w-5 mr-1 non-active" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M4.318 6.318a4.5 4.5 0 000
                                  6.364L12 20.364l7.682-7.682a4.5 4.5
                                  0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5
                                  4.5 0 00-6.364 0z"/>
                            </svg>
                            <svg class="w-5 mr-1 active" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M3.172 5.172a4 4 0 015.656
                              0L10 6.343l1.172-1.171a4 4 0
                              115.656 5.656L10 17.657l-6.828-6.829a4
                              4 0 010-5.656z" clip-rule="evenodd" />
                            </svg>
                            <span class="font-semibold" style="line-height: 1px">${item.likes}</span>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row items-center mt-2 lg:mt-0">
                    ${createVisitBtn}
                    ${mode === 'patient' ? createReviewBtn : ''}
                </div>
            `;

            if (mode === 'patient') {
                addToFavoriteListener(item.id, row.querySelector('.like-doctor-btn'));
            }

            observeLinkListener(row.querySelector('a.observer-link'));

            this.container.append(row);
        });

        if (this.shown - this._getAmount() > 0) {
            this.full = true;
            this.btn.innerText = 'Показаны все врачи';
            removeListener();
        } else {
            this.btn.innerText = 'Показать больше';
        }
    }
}
