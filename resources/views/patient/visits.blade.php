@extends('layouts.main')

@section('title', 'Cabinet | Кабинет пользователя')

@section('content')
    <div class="w-full mb-4 bg-white shadow-md p-4 select-none">
        <div class="flex">
            <button class="show-visits-filters-btn mr-5 flex justify-center items-center transition duration-300 text-gray-500 border border-gray-500 rounded-md text-sm px-3 py-2 sm:px-5 hover:text-white hover:bg-gray-500 focus:outline-none">
                <svg class="w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M12 6V4m0 2a2 2 0
                      100 4m0-4a2 2 0 110 4m-6
                      8a2 2 0 100-4m0 4a2 2 0
                      110-4m0 4v2m0-6V4m6 6v10m6-2a2
                      2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                </svg>
                Фильтры
            </button>
            <span class="hidden sm:block self-center text-gray-400 text-sm md:text-base">Всего найдено: <span class="visits-amount">{{ count($visits) }}</span></span>
            <a href="{{ route('patient-visits-create') }}" class="flex items-center ml-auto px-3 py-2 sm:px-5 border border-indigo-100 bg-indigo-100 text-sm text-white rounded-md transition duration-300 ease select-none hover:bg-indigo-200 hover:border-indigo-200 focus:outline-none">
                <svg class="w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M12 9v3m0 0v3m0-3h3m-3
                      0H9m12 0a9 9 0 11-18 0 9 9
                      0 0118 0z" />
                </svg>
                Записаться
            </a>
        </div>
        <div class="flex flex-col justify-items-start visits-filters hidden max-h-0 overflow-hidden transition-max-h transition-all ease-linear duration-700 mt-4 bg-gray-100 rounded-md border border-gray-300 px-4">
            <div style="min-height: 0.725rem"></div>
            <div class="flex flex-col overflow-hidden">
                <span class="mb-2">Статус:</span>
                <select class="visit-statuses-select" name="status" autocomplete="off" multiple>
                    <option value="1" selected>На рассмотрении</option>
                    <option value="2" selected>Утвержден</option>
                    <option value="3" selected>В процессе</option>
                    <option value="4" selected>Заполняется</option>
                    <option value="5" selected>Завершенный</option>
                    <option value="6" selected>Отмененный</option>
                </select>
                <span class="mt-2 mb-2">Заболевание:</span>
                <select class="visit-illnesses-select" name="illnesses" autocomplete="off" multiple>
                    @foreach($illnesses as $illness)
                        <option value="{{ $illness->id }}" {{ intval(request()->get('illness')) === $illness->id ? 'selected' : '' }}>{{ $illness->title }}</option>
                    @endforeach
                </select>
                <span class="mt-2 mb-2">По дате:</span>
                <div class="flex flex-col sm:flex-row">
                    <label class="flex items-center bg-white px-3 py-1 text-gray-700 rounded-md border border-gray-300">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M8 7V3m8 4V3m-9 8h10M5
                                  21h14a2 2 0 002-2V7a2 2
                                  0 00-2-2H5a2 2 0 00-2 2v12a2
                                  2 0 002 2z" />
                        </svg>
                        <input class="text-center bg-white w-28 placeholder-gray-700 focus:outline-none" type="date" name="date_start" placeholder="дд.мм.гггг">
                    </label>
                    <span class="mx-3 self-center"> – </span>
                    <label class="flex items-center bg-white px-3 py-1 text-gray-700 rounded-md border border-gray-300">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M8 7V3m8 4V3m-9 8h10M5
                                  21h14a2 2 0 002-2V7a2 2
                                  0 00-2-2H5a2 2 0 00-2 2v12a2
                                  2 0 002 2z" />
                        </svg>
                        <input class="text-center bg-white w-28 placeholder-gray-700 focus:outline-none" type="date" name="date_end" placeholder="дд.мм.гггг">
                    </label>
                </div>
            </div>
            <div class="flex flex-col sm:flex-row mt-6 sm:mt-8">
                <button class="accept-filters-btn flex justify-center items-center mr-0 sm:mr-5 mb-2 sm:mb-0 transition duration-300 text-white bg-green-light border border-green-light rounded-md text-sm px-3 py-2 sm:px-5 focus:outline-none hover:opacity-80">
                    <svg class="w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M5 13l4 4L19 7" />
                    </svg>
                    Применить
                </button>
                <a href="" class="flex justify-center items-center transition duration-300 text-gray-500 border border-gray-500 rounded-md text-sm px-3 py-1 py-2 sm:px-5 hover:text-white hover:bg-gray-500 focus:outline-none">
                    <svg class="w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M4 4v5h.582m15.356 2A8.001 8.001
                              0 004.582 9m0 0H9m11 11v-5h-.581m0
                              0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Очистить
                </a>
            </div>
            <div style="min-height: 0.725rem"></div>
        </div>
    </div>

    <div class="visit-list w-full bg-white shadow-md select-none {{ count($visits) === 0 ? 'hidden' : ''  }}">
        @foreach($visits as $visit)
            <div class="flex px-4 even:bg-gray-50 visit-item">
                <div class="flex flex-col justify-center mr-3 sm:mr-5">
                    <div class="h-14 border-l-2 sm:border-l-4 border-yellow-300 self-center"></div>
                    <div class="flex flex-col justify-center items-center min-h-14 w-14 h-14 sm:min-h-18 sm:h-18 sm:w-18 rounded-full border-2 sm:border-4 border-yellow-300">
                        <span class="text-gray-500 text-xs font-medium">{{ $visit->visit_date ? \Illuminate\Support\Carbon::parse($visit->visit_date)->format('m.d') : '--.--' }}</span>
                        <span class="text-gray-500 text-xs sm:text-sm font-bold sm:font-semibold">{{ $visit->visit_time ? \Illuminate\Support\Carbon::parse($visit->visit_time)->format('H:i') : '--:--' }}</span>
                    </div>
                    <div class="h-full border-l-2 sm:border-l-4 border-yellow-300 self-center"></div>
                </div>
                <div class="py-4 text-sm sm:text-base">
                    <a href="{{ route('patient-visit', ['id' => $visit->id]) }}" class="text-gray-400 text-base sm:text-xl font-medium hover:underline">Визит № {{ $visit->id }}</a>
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
                        <span class="text-gray-500">{{ $visit->status->name }}</span>
                    </div>
                    @if($visit->doctor)
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
                            <a href="{{ route('patient-doctor', ['id' => $visit->doctor->id]) }}" class="text-gray-500 hover:underline">{{ $visit->doctor->last_name . ' ' . mb_substr($visit->doctor->first_name, 0, 1) . '.' . mb_substr($visit->doctor->middle_name, 0, 1) . '.' }}</a>
                        </div>
                    @endif
                    @if($visit->cause)
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
                            <span class="text-gray-500">{{ \Illuminate\Support\Str::limit($visit->cause, 50) }}</span>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <div class="flex justify-center w-full mt-8 mb-16">
        <button id="showMoreVisitsBtn" class="transition duration-300 text-gray-500 border border-gray-500 rounded-md text-sm px-3 py-1 py-2 sm:px-5 hover:text-white hover:bg-gray-500 focus:outline-none">{{ count($visits) === 0 ? 'Визиты отсутствуют' : 'Показать больше' }}</button>
    </div>
@endsection
