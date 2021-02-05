@extends('layouts.main')

@section('title', 'Cabinet | Кабинет пользователя')

@section('content')
    <div class="w-full bg-white shadow-md p-4 mb-5">
        <div class="flex items-center rounded-md border border-gray-300 px-3 py-2 sm:px-4 sm:py-3">
            <div class="flex mr-2 sm:mr-4 doctors-search-loader">
                <svg class="non-loader w-5 sm:w-6 text-green-light" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M21 21l-6-6m2-5a7
                      7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <svg class="loader hidden animate-spin w-5 sm:w-6 text-green-light" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
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
            <input class="doctors-search-input w-full text-gray-500 placeholder-gray-500 text-lg sm:text-xl outline-none" type="text"
                   value="{{ request()->get('q') }}"
                   placeholder="Поиск врачей ...">
        </div>
        <div class="mt-2 px-2 select-none">
            <p class="text-gray-400 mb-1">Недавно искали:</p>
            <div class="recent-list flex flex-wrap">
                <i class="text-sm text-gray-300">Список пуст...</i>
            </div>
        </div>
    </div>

    <div class="doctors-search-container flex flex-col shadow-md w-full select-none">
        @foreach($doctors as $doctor)
            <div class="doctor-item flex flex-col lg:flex-row bg-white p-4 border-b border-gray-200 last:border-0">
                <div class="flex mr-auto w-full lg:w-auto">
                    <div class="flex lg:flex-col items-center w-full">
                        <div class="flex mr-auto">
                            <div class="min-w-12 min-h-12 w-12 h-12 sm:min-w-16 sm:min-h-16 sm:w-16 sm:h-16 mr-2 sm:mr-4 mb-4 border border-gray-200 rounded-full bg-center bg-cover bg-no-repeat"
                                 style="background-image: url({{ $doctor['profile_photo'] }})"></div>

                            <div class="flex flex-col">
                                <a href="{{ route('patient-doctor', ['id' => $doctor['id']]) }}" class="observable-link mb-1 text-green-light sm:text-xl font-medium leading-5 hover:underline">{{ $doctor['full_name'] }}</a>
                                <i class="mb-4 text-gray-400 text-sm sm:text-base">{{ $doctor['occupation'] }}</i>
                            </div>
                        </div>
                        <div class="flex items-center self-start ml-3.5 text-gray-400  {{ $doctor['is_liked'] ? 'active' : '' }} like-doctor-btn" data-doctor-id="{{ $doctor['id'] }}">
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
                            <span class="font-semibold" style="line-height: 1px">{{ $doctor['likes'] }}</span>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row items-center mt-2 lg:mt-0">
                    <a href="{{ route('patient-visits-create', ['dest' => 'd' . $doctor['id']]) }}"
                       class="flex items-center justify-center w-full lg:w-auto md:mr-4 mb-2 md:mb-0 px-4 py-2 border border-gray-500 text-gray-500 text-sm rounded-md transition duration-300 ease select-none hover:bg-gray-500 hover:border-gray-500 hover:text-white focus:outline-none focus:ring-4 focus:ring-gray-500 focus:ring-opacity-50">
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
                        Записаться на приём
                    </a>
                    <a href="{{ route('patient-doctor', ['id' => $doctor['id']]) }}#create-review"
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
                </div>
            </div>
        @endforeach
    </div>

    <div class="container mx-auto flex justify-center mt-8">
        <button class="show-more-doctors-btn transition duration-300 text-gray-500 border border-gray-500 rounded-md text-sm px-3 py-2 sm:px-5 hover:text-white hover:bg-gray-500 focus:outline-none">{{ count($doctors) === 0 ? 'Врачи не найдены' : 'Показать больше' }}</button>
    </div>
@endsection
