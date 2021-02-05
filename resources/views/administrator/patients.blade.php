@extends('layouts.admin-main')

@section('title', 'Cabinet | Кабинет администратор')

@section('content')
    <div class="w-full bg-white shadow-md p-4 mb-5">
        <div class="flex items-center mb-2 rounded-md border border-gray-300 px-3 py-2 sm:px-4 sm:py-3">
            <div class="flex patients-search-loader">
                <svg class="non-loader w-5 sm:w-6 mr-2 sm:mr-5 text-green-light" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M21 21l-6-6m2-5a7
                      7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <svg class="loader hidden animate-spin w-5 sm:w-6 mr-2 sm:mr-5 text-green-light" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
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
                          5.824 3 7.938l3-2.647z" />
                </svg>
            </div>
            <input class="w-full patients-search-input text-gray-500 placeholder-gray-500 text-lg sm:text-xl outline-none" type="text"
                   value="{{ request()->get('q') }}"
                   placeholder="Поиск пациентов ...">
        </div>
        <div class="mt-2 px-2 select-none">
            <p class="text-gray-400 mb-1">Недавно искали:</p>
            <div class="recent-list flex flex-wrap">
                <i class="text-sm text-gray-300">Список пуст...</i>
            </div>
        </div>
    </div>
    <div class="patients-search-container flex flex-col shadow-md w-full select-none">
        @foreach($patients as $patient)
            <div class="flex patient-item flex-col md:flex-row p-4 bg-white border-b border-gray-200 last:border-0">
                <div class="flex items-center mr-auto">
                    <div class="mr-2 sm:mr-4 border border-gray-200 rounded-full min-w-12 min-h-12 w-12 h-12 sm:min-w-16 sm:min-h-16 sm:w-16 sm:h-16 bg-center bg-cover bg-no-repeat"
                         style="background-image: url({{ $patient['profile_photo'] }})"></div>

                    <div class="flex flex-col">
                        <a href="{{ route('administrator-patient', ['id' => $patient['id']]) }}" class="observable-link text-green-light sm:text-xl font-medium sm:mb-1 hover:underline">{{ $patient['full_name'] }}</a>
                        <i class="text-gray-400">{{ $patient['phone'] }}</i>
                    </div>
                </div>
                <div class="flex items-center mt-4 sm:mt-6 md:mt-0 w-full md:w-auto">
                    <a href="{{ route('administrator-visits-create', ['patient' => $patient['id']]) }}"
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
            </div>
        @endforeach
    </div>

    <div class="container mx-auto flex justify-center mt-8">
        <button class="show-more-patients-btn transition duration-300 text-gray-500 border border-gray-500 rounded-md text-sm px-3 py-2 sm:px-5 hover:text-white hover:bg-gray-500 focus:outline-none">{{ count($patients) === 0 ? 'Пациентов не найдено' : 'Показать больше' }}</button>
    </div>
@endsection
