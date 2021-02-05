@extends('layouts.admin-main')

@section('title', 'Cabinet | Кабинет администратора')

@section('content')
    <div class="grid grid-cols-3 gap-4 select-none">
        <div class="col-span-full lg:col-span-2 flex flex-col bg-white shadow-md p-4">
            <div class="flex mb-6">
                <div class="min-h-14 min-w-14 h-14 w-14 sm:min-h-16 sm:min-w-16 sm:w-16 sm:h-16 mr-3 sm:mr-6 border-2 border-gray-300 rounded-full bg-cover bg-center bg-no-repeat"
                     style="background-image: url({{ $doctorAvatar }})"></div>
                <p class="mr-auto text-xl sm:text-2xl text-green-light font-medium leading-6">{{ $doctor->full_name }}</p>
                <div class="flex items-center self-start ml-6 text-gray-400">
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
                    <span class="font-semibold" style="line-height: 1px">{{ $doctor->likes->count() }}</span>
                </div>
            </div>
            <div class="flex flex-col mb-4">
                <p class="mb-1 sm:text-lg text-gray-400">Инф. о враче:</p>
                <div class="text-gray-500">{!! $doctor->description !!}</div>
            </div>
            <div class="flex items-start sm:items-center flex-wrap mb-2 leading-5">
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
            <div class="flex items-start sm:items-center mb-2">
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
        <div class="col-span-full lg:col-span-1 row-auto flex flex-col">
            <div class="mb-4 py-4 bg-white shadow-md">
                <p class="mx-4 text-xl sm:text-2xl text-gray-400">Действия</p>
                <hr class="my-4" />
                <a href="{{ route('administrator-visits-create', ['dest' => 'd' . $doctor->id]) }}"
                   class="flex justify-center items-center mx-4 px-4 py-2 border border-indigo-100 bg-indigo-100 text-sm sm:text-base text-white rounded-md transition duration-300 ease hover:bg-indigo-200 hover:border-indigo-200 focus:outline-none focus:ring-4 focus:ring-indigo-100 focus:ring-opacity-50">
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
    </div>
@endsection
