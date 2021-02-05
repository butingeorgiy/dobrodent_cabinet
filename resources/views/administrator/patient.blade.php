@extends('layouts.admin-main')

@section('title', 'Cabinet | Кабинет администратора')

@section('content')
    <div class="grid grid-cols-3 gap-4 select-none">
        <div class="col-span-full lg:col-span-2 flex flex-col bg-white shadow-md p-4">
            <div class="flex mb-6">
                <div class="min-h-14 min-w-14 h-14 w-14 sm:min-h-16 sm:min-w-16 sm:w-16 sm:h-16 mr-3 sm:mr-6 border-2 border-gray-300 rounded-full bg-cover bg-center bg-no-repeat"
                     style="background-image: url({{ $patientAvatar }})"></div>
                <p class="mr-auto text-xl sm:text-2xl text-green-light font-medium leading-6">{{ $patient->full_name }}</p>
            </div>
            <div class="flex items-center mb-2">
                <p class="mr-2 sm:text-lg text-gray-400">Пол:</p>
                <span class="text-gray-500"
                      style="line-height: 1px">{{ $patient->gender === '0' ? 'Мужской' : 'Женский' }}</span>
            </div>
            <div class="flex items-center mb-2">
                <p class="mr-2 sm:text-lg text-gray-400">E-mail:</p>
                <span class="text-gray-500"
                      style="line-height: 1px">{{ $patient->email ?: 'Не указан' }}</span>
            </div>
            <div class="flex items-center">
                <p class="mr-2 sm:text-lg text-gray-400">Возраст:</p>
                <span class="text-gray-500"
                      style="line-height: 1px">
                    @php
                        /**
                         * @var $patient
                         */

                        $diff = Illuminate\Support\Carbon::now()->diffInYears(Illuminate\Support\Carbon::parse($patient->birthday));

                        $t1 = $diff % 10;
                        $t2 = $diff % 100;
                        if ($diff === 0) {
                            echo 'Не указан';
                        } else {
                            echo $diff . ($t1 == 1 && $t2 != 11 ? ' год' : ($t1 >= 2 && $t1 <= 4 && ($t2 < 10 || $t2 >= 20) ? ' года' : ' лет'));
                        }
                    @endphp
                </span>
            </div>
        </div>
        <div class="col-span-full lg:col-span-1 row-auto flex flex-col">
            <div class="mb-4 py-4 bg-white shadow-md">
                <p class="mx-4 text-xl sm:text-2x text-gray-400">Действия</p>
                <hr class="my-4" />
                <a href="{{ route('administrator-visits-create', ['patient' => $patient->id]) }}"
                   class="flex justify-center items-center mx-4 mb-2 px-4 py-2 last:mb-0 border border-indigo-100 bg-indigo-100 text-sm sm:text-base text-white rounded-md transition duration-300 ease hover:bg-indigo-200 hover:border-indigo-200 focus:outline-none focus:ring-4 focus:ring-indigo-100 focus:ring-opacity-50">
                    <svg class="w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M8 7V3m8 4V3m-9
                          8h10M5 21h14a2 2 0
                          002-2V7a2 2 0 00-2-2H5a2
                          2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Записать на приём
                </a>
                @if(\App\Facades\Authorization::user()->privileges_id === 2)
                    <a href=""
                       class="edit-patient-data-btn flex justify-center items-center mx-4 px-4 py-2 border border-gray-500 text-sm sm:text-base text-gray-500 rounded-md transition duration-300 ease hover:bg-gray-500 hover:border-gray-500 hover:text-white focus:outline-none focus:ring-4 focus:ring-gray-500 focus:ring-opacity-50">
                        <svg class="w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002
                              2h11a2 2 0 002-2v-5m-1.414-9.414a2 2
                              0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Редактировать данные
                    </a>
                @endif
            </div>
            <div class="py-4 bg-white shadow-md">
                <p class="mx-4 text-xl sm:text-2x text-gray-400">Контакты</p>
                <hr class="my-4" />
                <a href="tel:+7{{ $patient->phone }}" class="flex items-center mx-4 mb-2 last:mb-0 text-green-light">
                    <svg class="w-5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M3 5a2 2 0 012-2h3.28a1 1
                                  0 01.948.684l1.498 4.493a1 1
                                  0 01-.502 1.21l-2.257 1.13a11.042
                                  11.042 0 005.516 5.516l1.13-2.257a1
                                  1 0 011.21-.502l4.493 1.498a1 1 0
                                  01.684.949V19a2 2 0 01-2 2h-1C9.716
                                  21 3 14.284 3 6V5z"/>
                    </svg>
                    <span class="font-medium">+{{ $patient->phone_code }} {{ preg_replace('/([0-9]{3})([0-9]{3})([0-9]{4})/', '($1) $2 $3', $patient->phone) }}</span>
                </a>
            </div>
        </div>
        <div class="col-span-full lg:col-span-2 flex flex-col bg-white shadow-md pt-4">
            <p class="px-4 text-xl sm:text-2x text-gray-400">Ближайшие визиты</p>
            @if(count($visits) !== 0)
                <div class="flex flex-col mt-4">
                    @foreach($visits as $visit)
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
                                <a href="{{ route('administrator-visit', ['id' => $visit->id]) }}" class="text-gray-400 text-base sm:text-xl font-medium hover:underline">Визит № {{ $visit->id }}</a>
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
                                        <a href="{{ route('administrator-doctor', ['id' => $visit->doctor->id]) }}" class="text-gray-500 hover:underline">{{ $visit->doctor->last_name . ' ' . mb_substr($visit->doctor->first_name, 0, 1) . '.' . mb_substr($visit->doctor->middle_name, 0, 1) . '.' }}</a>
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
                <i class="mb-4 mx-4 text-gray-400">В ближайщую неделю у пациента не намечается визитов</i>
            @endif
        </div>
    </div>

    @if(\App\Facades\Authorization::user()->privileges_id === 2) @include('popups.edit-patient') @endif
@endsection
