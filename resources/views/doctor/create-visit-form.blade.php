@extends('layouts.doctor-main')

@section('title', 'Cabinet | Кабинет врача')

@section('content')
    <div class="w-full mb-4 bg-white shadow-md select-none py-5">
        <p class="px-4 text-xl sm:text-2xl text-gray-400 select-none">Записать пациента на приём</p>
        <hr class="my-4" />
        <div class="flex flex-col lg:flex-row px-4">
            <div class="w-full lg:w-2/3 lg:mr-8">
                <p class="mb-1">Куда, или к кому назначить визит:</p>
                <select class="visit-destination-select" data-options="{{ $options }}" data-selected="{{ request()->get('dest') ?? '' }}"></select>
                <p class="mt-3 mb-1">Пациент:</p>
                <select class="visit-patient-select" data-options="{{ $patientsOptions }}" data-selected="{{ request()->get('patient') ?? '' }}"></select>
                <p class="mt-3 mb-1">Причина визита:</p>
                <textarea name="cause" class="w-full p-2 rounded-md border border-gray-400 text-sm sm:text-base text-gray-700 focus:outline-none disabled:opacity-50" rows="4" placeholder="Пожалуйста, вкратце опишите, что Вас беспокоит..."></textarea>
            </div>
            <div class="w-full lg:w-1/3">
                <p class="mb-1 mt-2 lg:mt-0">Дата, удобная для визита:</p>
                <label class="flex items-center bg-white px-3 py-1 text-gray-700 rounded-md border border-gray-400">
                    <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M8 7V3m8 4V3m-9 8h10M5
                                  21h14a2 2 0 002-2V7a2 2
                                  0 00-2-2H5a2 2 0 00-2 2v12a2
                                  2 0 002 2z" />w
                    </svg>
                    <input class="text-sm sm:text-base placeholder-gray-700 focus:outline-none disabled:bg-white" type="date" name="visit_date" placeholder="дд.мм.гггг">
                </label>

                <p class="mt-3 mb-1">Предпочитаемое время:</p>
                <label class="flex items-center bg-white px-3 py-1 text-gray-700 rounded-md border border-gray-400">
                    <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M12 8v4l3 3m6-3a9 9 0
                              11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <input class="text-sm sm:text-base placeholder-gray-700 focus:outline-none disabled:bg-white" type="time" name="visit_time" placeholder="--:--">
                </label>
            </div>
        </div>
        <hr class="mt-3 mb-4" />
        <div class="flex flex-col-reverse lg:flex-row px-4">
            <button type="button" class="create-visit-btn flex justify-center items-center sm:self-start lg:mr-4 px-4 py-2 border border-indigo-100 bg-indigo-100 text-sm sm:text-base text-white rounded-md transition duration-300 ease select-none hover:bg-indigo-200 hover:border-indigo-200 focus:outline-none">
                <svg class="w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M12 9v3m0 0v3m0-3h3m-3
                      0H9m12 0a9 9 0 11-18 0 9 9
                      0 0118 0z" />
                </svg>
                Записать
            </button>

            <span class="hidden flex items-start lg:items-center mb-4 lg:mb-0 text-red-500 select-none error-message">
                <svg class="min-w-5 w-5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M12 9v2m0 4h.01m-6.938
                          4h13.856c1.54 0 2.502-1.667
                          1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464
                          0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span class="leading-5"></span>
            </span>

            <span class="hidden flex items-start lg:items-center lg:mb-0 text-green-light select-none success-message">
                <svg class="min-w-5 w-5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M9 12l2 2 4-4m5.618-4.016A11.955
                          11.955 0 0112 2.944a11.955 11.955
                          0 01-8.618 3.04A12.02 12.02 0 003
                          9c0 5.591 3.824 10.29 9 11.622 5.176-1.332
                          9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                <span class="leading-5"></span>
            </span>
        </div>
    </div>
@endsection
