@extends('layouts.main')

@section('title', 'Cabinet | Кабинет пользователя')

@section('content')
    <div class="grid grid-cols-3 gap-4 select-none">
        <div class="col-span-full lg:col-span-2">
            <div class="flex flex-col bg-white shadow-md p-4 mb-4">
                <div class="flex mb-6">
                    <div class="min-h-14 min-w-14 h-14 w-14 sm:min-h-16 sm:min-w-16 sm:w-16 sm:h-16 mr-3 sm:mr-6 border-2 border-gray-300 rounded-full bg-cover bg-center bg-no-repeat"
                         style="background-image: url({{ $doctorAvatar }})"></div>
                    <p class="mr-auto text-xl sm:text-2xl text-green-light font-medium leading-6">{{ $doctor->full_name }}</p>
                    <div class="flex items-center self-start ml-6 text-gray-400 cursor-pointer {{ $doctor->likes->contains(\App\Facades\Authorization::user()) ? 'active' : '' }} like-doctor-btn">
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
                        <span class="font-semibold" style="line-height: 1px">{{ $likes }}</span>
                    </div>
                </div>
                <div class="flex flex-col mb-4">
                    <p class="mb-1 sm:text-lg text-gray-400">Инф. о враче:</p>
                    <div class="text-gray-500">{!! $doctor->description !!}</div>
                </div>
                <div class="flex items-start sm:items-center flex-wrap leading-5 mb-2">
                    <p class="mr-2 sm:text-lg text-gray-400">Специализация:</p>
                    @php
                        /**
                         * @var $doctor
                         */

                        $occupations = $doctor->occupations()->get();
                        $occupationsStr = '';

                        foreach ($occupations as $item => $occupation) {
                            $occupationsStr .= $occupation->title;

                            if ($item < count($occupations) - 1) {
                                $occupationsStr .= ', ';
                            }
                        }

                        if (count($occupations) === 0) {
                            $occupationsStr = 'Не указана';
                        }
                    @endphp
                    <span class="text-gray-500">{{ $occupationsStr }}</span>
                </div>
                <div class="flex items-center mb-2">
                    <p class="mr-2 sm:text-lg text-gray-400">Стаж работы:</p>
                    <span class="text-gray-500">
                    @php
                        /**
                         * @var $doctor
                         */

                        $diff = Illuminate\Support\Carbon::now()->diffInYears(Illuminate\Support\Carbon::parse($doctor->working_since));

                        if ($diff === 0) {
                            echo 'меньше года';
                        } else {
                            $t1 = $diff % 10;
                            $t2 = $diff % 100;
                            echo $diff . ($t1 == 1 && $t2 != 11 ? ' год' : ($t1 >= 2 && $t1 <= 4 && ($t2 < 10 || $t2 >= 20) ? ' года' : ' лет'));
                        }
                    @endphp
                </span>
                </div>
                <div class="flex items-center">
                    <p class="mr-2 sm:text-lg text-gray-400">Возраст:</p>
                    <span class="text-gray-500"
                          style="line-height: 1px">
                    @php
                        /**
                         * @var $doctor
                         */

                        $diff = Illuminate\Support\Carbon::now()->diffInYears(Illuminate\Support\Carbon::parse($doctor->birthday));

                        $t1 = $diff % 10;
                        $t2 = $diff % 100;
                        echo $diff . ($t1 == 1 && $t2 != 11 ? ' год' : ($t1 >= 2 && $t1 <= 4 && ($t2 < 10 || $t2 >= 20) ? ' года' : ' лет'));
                    @endphp
                </span>
                </div>
            </div>
            <div class="flex flex-col bg-white shadow-md py-4">
                <p class="mx-4 text-xl sm:text-2xl text-gray-400">Заметка к врачу</p>
                <hr class="my-4" />
                <div class="flex flex-col px-4">
                    <textarea class="doctor-note w-full focus:outline-none" rows="2" placeholder="Введите что-нибудь ..."></textarea>
                    <i class="mt-2 text-sm text-red-400">Это будете видеть только вы!</i>
                </div>
            </div>
        </div>
        <div class="col-span-full lg:col-span-1 row-auto flex flex-col">
            <div class="mb-4 py-4 bg-white shadow-md">
                <p class="mx-4 text-xl sm:text-2xl text-gray-400">Действия</p>
                <hr class="my-4" />
                <a href="{{ route('patient-visits-create', ['dest' => 'd' . $doctor->id]) }}"
                   class="flex justify-center items-center mx-4 mb-2 px-4 py-2 border border-indigo-100 bg-indigo-100 text-sm sm:text-base text-white rounded-md transition duration-300 ease hover:bg-indigo-200 hover:border-indigo-200 focus:outline-none focus:ring-4 focus:ring-indigo-100 focus:ring-opacity-50">
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
                    Записаться на приём
                </a>
                <a href="#"
                   class="open-review-popup-btn flex justify-center items-center mx-4 px-4 py-2 border border-gray-500 text-sm sm:text-base text-gray-500 rounded-md transition duration-300 ease hover:bg-gray-500 hover:border-gray-500 hover:text-white focus:outline-none focus:ring-4 focus:ring-gray-500 focus:ring-opacity-50">
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
            <div class="py-4 bg-white shadow-md">
                <p class="mx-4 text-xl sm:text-2xl text-gray-400">Контакты</p>
                <hr class="my-4" />
                @forelse($doctorPhones as $phone)
                    <a href="tel:+7{{ $phone->phone }}" class="flex items-center mx-4 mb-2 last:mb-0 text-green-light">
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
                        <span class="font-medium">+7 {{ preg_replace('/([0-9]{3})([0-9]{3})([0-9]{4})/', '($1) $2 $3', $phone->phone) }}</span>
                    </a>
                @empty
                    <i class="mx-4 text-gray-400">Данные отсутствуют</i>
                @endforelse
            </div>
        </div>
        <div class="col-span-full lg:col-span-2 flex flex-col bg-white shadow-md pt-4">
            <p class="px-4 text-xl sm:text-2xl text-gray-400">История обращений</p>
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
                                <a href="{{ route('patient-visit', ['id' => $visit->id]) }}" class="text-gray-400 text-base sm:text-xl font-medium hover:underline">Визит № {{ $visit->id }}</a>
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
                <i class="mx-4 mb-4 text-gray-400">Вы ещё не обращались к этому врачу</i>
            @endif
        </div>
    </div>

    @include('popups.create-doctor-review')
@endsection
