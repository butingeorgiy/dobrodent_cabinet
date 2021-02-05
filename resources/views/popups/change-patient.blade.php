<div class="hidden edit-visit-patient-popup popup-wrapper flex justify-center items-center fixed w-screen h-screen z-50 top-0 left-0 bg-black bg-opacity-50">
    <div class="popup relative mx-4 sm:mx-0 transition-top duration-300 ease-out top-350px py-4 bg-white select-none"
         style="width: 600px">
        <p class="mx-4 text-gray-400 text-xl sm:text-2xl">Изменить пациента</p>
        <hr class="my-4"/>
        <div class="mx-4">
            <label class="flex flex-col">
                <select class="edit-visit-patient-select" data-options="{{ $patients }}" data-selected="{{ $visit->patient->id }}"></select>
            </label>
            <span class="hidden flex items-start text-red-500 select-none error-message">
                <svg class="min-w-5 w-5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M12 9v2m0 4h.01m-6.938
                          4h13.856c1.54 0 2.502-1.667
                          1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464
                          0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <span class="leading-5"></span>
            </span>
            <span class="hidden flex items-start text-green-light select-none success-message">
                <svg class="min-w-5 w-5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M9 12l2 2 4-4m5.618-4.016A11.955
                          11.955 0 0112 2.944a11.955 11.955
                          0 01-8.618 3.04A12.02 12.02 0 003
                          9c0 5.591 3.824 10.29 9 11.622 5.176-1.332
                          9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                <span class="leading-5"></span>
            </span>
            <button class="save-visit-patient-btn flex justify-center items-center w-full mt-6 px-4 py-2 bg-green-light text-sm sm:text-base text-white rounded-md transition duration-300 hover:opacity-80 focus:outline-none focus:ring-4 focus:ring-green-light focus:ring-opacity-50">
                <svg class="non-loader w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5
                                  2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                </svg>
                <svg class="loader hidden animate-spin w-5 mr-1 text-white" xmlns="http://www.w3.org/2000/svg"
                     fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25"
                            cx="12"
                            cy="12"
                            r="10"
                            stroke="currentColor"
                            stroke-width="4"></circle>
                    <path class="opacity-75"
                          fill="currentColor"
                          d="M4 12a8 8 0 018-8V0C5.373
                              0 0 5.373 0 12h4zm2 5.291A7.962
                              7.962 0 014 12H0c0 3.042 1.135
                              5.824 3 7.938l3-2.647z"/>
                </svg>
                <span>Сохранить изменения</span>
            </button>
        </div>
    </div>
</div>
