@extends('layouts.doctor-main')

@section('title', 'Cabinet | Кабинет врача')

@section('content')
    <div class="flex mb-4 select-none">
        <div class="w-full relative bg-white shadow-md p-4">
            <div class="flex items-center {{ request()->has('q') ? 'rounded-t-md' : 'rounded-md' }} border border-gray-300 px-3 py-2 sm:px-4 sm:py-3">
                <div class="flex mr-2 sm:mr-4 global-search-loader">
                    <svg class="non-loader w-5 h-5 sm:w-6 sm:h-6 text-green-light" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M21 21l-6-6m2-5a7
                      7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <svg class="loader hidden animate-spin w-5 h-5 sm:w-6 sm:h-6 text-green-light" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
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
                <input class="global-search-input w-full text-gray-500 placeholder-gray-500 text-lg sm:text-xl outline-none"
                       type="text"
                       value="{{ request()->get('q') }}"
                       placeholder="Поиск по кабинету ...">
                <div class="global-search-clear-btn {{ request()->has('q') ? '' : 'hidden' }} ml-4 cursor-pointer">
                    <svg class="min-w-5 min-h-5 w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                              clip-rule="evenodd"
                              d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1
                              0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414
                              1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414
                              10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"/>
                    </svg>
                </div>
            </div>
            <div class="{{ request()->has('q') ? '' : 'hidden' }} absolute left-0 w-full px-4 max-h-64">
                <div class="global-search-container flex flex-col w-full max-h-64 pt-2 bg-white border border-t-0 border-gray-300 rounded-b-md overflow-y-scroll shadow-2xl">
                    @php $isEmpty = true; @endphp
                    @if(count($global['patients'] ?? []) > 0)
                        @php $isEmpty = false; @endphp
                        <p class="mx-4 mb-2 first:mt-0 text-sm text-gray-500">Пациенты:</p>
                    @endif
                    @foreach($global['patients'] ?? [] as $patient)
                        <a href="{{ route('doctor-patient', ['id' => $patient['id']]) }}" class="global-search-item flex min-h-14 px-4 py-2 hover:bg-gray-50 cursor-pointer">
                            <div class="min-w-10 min-h-10 w-10 h-10 mr-2 sm:mr-4 bg-center bg-no-repeat bg-contain rounded-full border border-gray-300"
                                 style="background-image: url({{$patient['profile_photo']}})"></div>
                            <div class="flex flex-col">
                                <p class="mb-1 text-green-light font-medium leading-5">{{$patient['full_name']}}</p>
                                <i class="text-sm text-gray-400 leading-4">{{$patient['phone']}}</i>
                            </div>
                        </a>
                    @endforeach
                    @if(count($global['visits'] ?? []) > 0)
                        @php $isEmpty = false; @endphp
                        <p class="mx-4 mt-4 first:mt-0 mb-2 text-sm text-gray-500">Визиты:</p>
                    @endif
                    @foreach($global['visits'] ?? [] as $visit)
                        <a href="{{ route('doctor-visit', [$visit['id']]) }}" class="global-search-item flex px-4 min-h-14 py-2 hover:bg-gray-50 cursor-pointer">
                            <div class="flex justify-center items-center min-w-10 min-h-10 w-10 h-10 mr-2 sm:mr-4 bg-center bg-no-repeat bg-contain rounded-full border border-yellow-300">
                                <p class="text-gray-500 text-xs font-medium">{{$visit['visit_date']}}</p>
                            </div>
                            <div class="flex flex-col">
                                <p class="mb-1 text-green-light font-medium leading-5">Визит № {{$visit['id']}}</p>
                                <i class="text-sm text-gray-400 leading-4">Пациент: <span class="text-gray-500">{{$visit['patient_full_name']}}</span></i>
                            </div>
                        </a>
                    @endforeach
                    @if($isEmpty)
                        <i class="mx-4 mb-2 text-gray-400 text-sm leading-5">По вашему запросу ничего не найдено ...</i>
                    @endif
                </div>
            </div>
            <div class="mt-2 px-2 select-none">
                <p class="text-gray-400 mb-1">Недавно искали:</p>
                <div class="recent-list flex flex-wrap">
                    <i class="text-sm text-gray-300">Список пуст...</i>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-4 pt-4 bg-white shadow-md select-none">
        <p class="mx-4 text-xl sm:text-2xl text-gray-400">Основные возможности</p>
        <hr class="mt-4" />
        <div class="grid grid-cols-1 md:grid-cols-2">
            <div class="flex p-4 hover:bg-gray-50">
                <div class="mr-2">
                    <svg class="text-green-light w-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5
                              16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z" />
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z" />
                    </svg>
                </div>
                <div class="flex flex-col">
                    <p class="mb-2 font-medium text-lg sm:text-xl text-green-light">Онлайн ведение историй болезней</p>
                    <p class="text-sm text-gray-700">
                        Тут будет описание данной возможности, а пока что программист не знает что тут написать.
                        Тут будет описание данной возможности, а пока что программист не знает что тут написать.
                    </p>
                </div>
            </div>

            <a href="{{ route('doctor-visits') }}" class="flex p-4 hover:bg-gray-50 cursor-pointer">
                <div class="mr-2">
                    <svg class="text-green-light w-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943
                              9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </div>
                <div class="flex flex-col">
                    <p class="mb-2 font-medium text-lg sm:text-xl text-green-light">Отслеживание всех визитов своих пациентов</p>
                    <p class="text-sm text-gray-700">
                        Тут будет описание данной возможности, а пока что программист не знает что тут написать.
                        Тут будет описание данной возможности, а пока что программист не знает что тут написать.
                    </p>
                </div>
            </a>

            <a href="{{ route('doctor-patients') }}" class="flex p-4 hover:bg-gray-50 cursor-pointer">
                <div class="mr-2">
                    <svg class="text-green-light w-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2
                              2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114
                              0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000
                              4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001
                              0 00-2.83 2M15 11h3m-3 4h2" />
                    </svg>
                </div>
                <div class="flex flex-col">
                    <p class="mb-2 font-medium text-lg sm:text-xl text-green-light">База всех пациентов в одном месте</p>
                    <p class="text-sm text-gray-700">
                        Тут будет описание данной возможности, а пока что программист не знает что тут написать.
                        Тут будет описание данной возможности, а пока что программист не знает что тут написать.
                    </p>
                </div>
            </a>

            <div class="flex p-4 hover:bg-gray-50">
                <div class="mr-2">
                    <svg class="text-green-light w-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2
                              2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1
                              0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div class="flex flex-col">
                    <p class="mb-2 font-medium text-lg sm:text-xl text-green-light">Онлайн хранение мед. документов</p>
                    <p class="text-sm text-gray-700">
                        Тут будет описание данной возможности, а пока что программист не знает что тут написать.
                        Тут будет описание данной возможности, а пока что программист не знает что тут написать.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-col mb-4 pt-4 bg-white shadow-md select-none">
        <p class="mx-4 text-xl sm:text-2xl text-gray-400">Сегодняшние визиты</p>
        @if(count($visits) !== 0)
            <div class="flex flex-col mt-4">
                @foreach($visits ?? [] as $visit)
                    <div class="flex px-4 odd:bg-gray-50 visit-item">
                        <div class="flex flex-col justify-center mr-3 sm:mr-5">
                            <div class="h-14 border-l-2 sm:border-l-4 border-yellow-300 self-center"></div>
                            <div class="flex flex-col justify-center items-center min-h-14 w-14 h-14 sm:min-h-18 sm:h-18 sm:w-18 rounded-full border-2 sm:border-4 border-yellow-300">
                                <span class="text-gray-500 text-xs font-medium">{{ $visit->visit_date ? \Illuminate\Support\Carbon::parse($visit->visit_date)->format('m.d') : '--.--' }}</span>
                                <span class="text-gray-500 text-xs sm:text-sm font-bold sm:font-semibold">{{ $visit->visit_time ? \Illuminate\Support\Carbon::parse($visit->visit_time)->format('H:i') : '--:--' }}</span>
                            </div>
                            <div class="h-full border-l-2 sm:border-l-4 border-yellow-300 self-center"></div>
                        </div>
                        <div class="py-4 text-sm sm:text-base">
                            <a href="{{ route('doctor-visit', ['id' => $visit->id]) }}" class="text-gray-400 text-base sm:text-xl font-medium hover:underline">Визит № {{ $visit->id }}</a>
                            <div class="flex mt-2 sm:mt-4 mb-1">
                                <span class="flex items-center items-center sm:min-w-36 sm:w-36 font-medium text-md text-green-light">
                                    <svg class="w-5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M9 12l2 2 4-4m5.618-4.016A11.955
                                              11.955 0 0112 2.944a11.955 11.955 0
                                              01-8.618 3.04A12.02 12.02 0 003 9c0
                                              5.591 3.824 10.29 9 11.622 5.176-1.332
                                              9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                    Статус:&nbsp;&nbsp;
                                </span>
                                <span class="text-gray-500">{{ $visit->status->name }}</span>
                            </div>
                            @if($visit->doctor)
                                <div class="flex mb-1">
                                    <span class="flex items-center items-center sm:min-w-36 sm:w-36 font-medium text-md text-green-light">
                                        <svg class="w-5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  stroke-width="2"
                                                  d="M16 7a4 4 0 11-8 0
                                                  4 4 0 018 0zM12 14a7
                                                  7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        Врач:&nbsp;&nbsp;
                                    </span>
                                    <a href="{{ route('patient-doctor', ['id' => $visit->doctor->id]) }}" class="text-gray-500 hover:underline">{{ $visit->doctor->last_name . ' ' . mb_substr($visit->doctor->first_name, 0, 1) . '.' . mb_substr($visit->doctor->middle_name, 0, 1) . '.' }}</a>
                                </div>
                            @endif
                            @if($visit->cause)
                                <div class="flex">
                                    <span class="flex items-center self-start sm:min-w-36 sm:w-36 font-medium text-md text-green-light">
                                        <svg class="w-5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none"
                                             viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  stroke-width="2"
                                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0
                                                  01-2-2V5a2 2 0 012-2h5.586a1 1
                                                  0 01.707.293l5.414 5.414a1 1 0
                                                  01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        Причина:&nbsp;&nbsp;
                                    </span>
                                    <span class="text-gray-500">{{ \Illuminate\Support\Str::limit($visit->cause, 50) }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <hr class="my-4" />
            <i class="mb-4 mx-4 text-gray-400">У вас сегодня нет визитов</i>
        @endif
    </div>
@endsection
