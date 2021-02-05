@extends('layouts.admin-main')

@section('title', 'Cabinet | Кабинет администратора')

@section('content')
    <div class="grid grid-cols-3 gap-4 select-none">
        <div class="col-span-full lg:col-span-2 flex flex-col bg-white shadow-md py-4">
            <div class="flex items-center px-4">
                <p class="mr-auto text-xl sm:text-2xl text-green-light font-medium">Визит № {{ $visit->id }}</p>
            </div>
            <hr class="my-4" />
            @if($visit->visit_date)
                <div class="flex items-start sm:items-center mx-4 mb-2">
                    <p class="mr-2 sm:text-lg text-gray-400">Дата:</p>
                    <span class="text-gray-500">{{ \Illuminate\Support\Carbon::parse($visit->visit_date)->format('d.m.Y') }}</span>
                </div>
            @endif
            @if($visit->visit_time)
                <div class="flex items-start sm:items-center mx-4 mb-2">
                    <p class="mr-2 sm:text-lg text-gray-400">Время:</p>
                    <span class="text-gray-500">{{ \Illuminate\Support\Carbon::parse($visit->visit_time)->format('H:i') }}</span>
                </div>
            @endif
            @if($visit->doctor)
                <div class="flex items-start sm:items-center mx-4 mb-2">
                    <p class="mr-2 sm:text-lg text-gray-400">Врач:</p>
                    <a href="{{ route('administrator-doctor', ['id' => $visit->doctor->id]) }}" class="text-gray-500 hover:underline">{{ $visit->doctor->last_name . ' ' . mb_substr($visit->doctor->first_name, 0, 1) . '.' . mb_substr($visit->doctor->middle_name, 0, 1) . '.' }}</a>
                </div>
            @endif

            <div class="flex items-start sm:items-center mx-4 mb-2">
                <p class="mr-2 sm:text-lg text-gray-400">Пациент:</p>
                <a href="{{ route('administrator-patient', ['id' => $visit->patient->id]) }}" class="text-gray-500 hover:underline">{{ $visit->patient->last_name . ' ' . mb_substr($visit->patient->first_name, 0, 1) . '.' . mb_substr($visit->patient->middle_name, 0, 1) . '.' }}</a>
            </div>

            <div class="flex items-start sm:items-center mx-4 mb-2">
                <p class="mr-2 sm:text-lg text-gray-400">Статус:</p>
                <span class="text-gray-500">{{ $visit->status->name }}</span>
            </div>
            @if($visit->illness)
                <div class="flex items-start sm:items-center mx-4 mb-2 leading-5">
                    <p class="mr-2 sm:text-lg text-gray-400">Заболевание:</p>
                    <a href="#" class="text-gray-500 hover:underline">{{ $visit->illness->title }}</a>
                </div>
            @endif
            <div class="flex flex-col mt-4 mx-4">
                <p class="mr-2 mb-1 sm:text-lg text-gray-400">Причина визита:</p>
                @if($visit->cause)
                    <div class="text-gray-500 leading-5">{{ $visit->cause }}</div>
                @else
                    <i class="text-gray-500 text-sm sm:text-base">Не указана</i>
                @endif
            </div>
            <div class="flex flex-col mt-4 mx-4 mb-2">
                <p class="mr-2 mb-1 sm:text-lg text-gray-400">Заключение врача:</p>
                @if($visit->result)
                    <div class="text-gray-500 leading-5">{!! $visit->result !!}</div>
                @else
                    <i class="text-gray-500 text-sm sm:text-base">Врач ещё не составили заключение</i>
                @endif
            </div>
        </div>
        <div class="col-span-full lg:col-span-1 row-auto flex flex-col">
            <div class="py-4 bg-white shadow-md">
                <p class="mx-4 text-xl sm:text-2xl text-gray-400">Действия</p>
                <hr class="my-4" />
                @if($visit->visit_status_id === 1 or \App\Facades\Authorization::user()->privileges_id === 2)
                    <a href="" class="move-visit-btn flex justify-center items-center mb-2 last:mb-0 mx-4 px-4 py-2 border border-indigo-100 bg-indigo-100 text-sm sm:text-base text-white rounded-md transition duration-300 ease hover:bg-indigo-200 hover:border-indigo-200 focus:outline-none focus:ring-4 focus:ring-indigo-100 focus:ring-opacity-50">
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
                        Сместить визит
                    </a>
                @endif
                <a href="" class="edit-visit-status-btn flex justify-center items-center mx-4 mb-2 last:mb-0 px-4 py-2 border border-gray-500 text-sm sm:text-base text-gray-500 rounded-md transition duration-300 ease hover:bg-gray-500 hover:border-gray-500 hover:text-white focus:outline-none focus:ring-4 focus:ring-gray-500 focus:ring-opacity-50">
                    <svg class="min-w-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
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
                    Изменить статус
                </a>
                @if(\App\Facades\Authorization::user()->privileges_id === 2)
                    <a href=""
                       class="edit-visit-illness-btn flex justify-center items-center mx-4 mb-2 last:mb-0 px-4 py-2 border border-red-400 text-sm sm:text-base text-red-400 rounded-md transition duration-300 ease hover:bg-red-400 hover:border-red-400 hover:text-white focus:outline-none focus:ring-4 focus:ring-red-400 focus:ring-opacity-50">
                        <svg class="min-w-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2
                                      0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2
                                      2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/>
                        </svg>
                        Ред. заболевание
                    </a>
                    <a href=""
                       class="edit-visit-result-btn flex justify-center items-center mx-4 mb-2 last:mb-0 px-4 py-2 border border-green-light text-sm sm:text-base text-green-light rounded-md transition duration-300 ease hover:bg-green-light hover:border-green-light hover:text-white focus:outline-none focus:ring-4 focus:ring-green-light focus:ring-opacity-50">
                        <svg class="min-w-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0
                              01-2-2V5a2 2 0 012-2h5.586a1 1
                              0 01.707.293l5.414 5.414a1 1 0
                              01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Ред. заключение
                    </a>
                    <a href=""
                       class="edit-visit-doctor-btn flex justify-center items-center mx-4 mb-2 last:mb-0 px-4 py-2 border border-blue-500 text-sm sm:text-base text-blue-500 rounded-md transition duration-300 ease hover:bg-blue-500 hover:border-blue-500 hover:text-white focus:outline-none focus:ring-4 focus:ring-blue-500 focus:ring-opacity-50">
                        <svg class="min-w-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2
                                  2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0
                                  114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2
                                  2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9
                                  14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                        </svg>
                        Изменить врача
                    </a>
                    <a href=""
                       class="edit-visit-patient-btn flex justify-center items-center mx-4 mb-2 last:mb-0 px-4 py-2 border border-yellow-500 text-sm sm:text-base text-yellow-500 rounded-md transition duration-300 ease hover:bg-yellow-500 hover:border-yellow-500 hover:text-white focus:outline-none focus:ring-4 focus:ring-yellow-500 focus:ring-opacity-50">
                        <svg class="min-w-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018
                                  0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Изменить пациента
                    </a>
                @endif
            </div>
        </div>
        <div class="col-span-full lg:col-span-2 flex flex-col bg-white shadow-md py-4">
            <p class="mx-4 text-xl sm:text-2xl text-gray-400">Прикреплённые файлы</p>
            <hr class="my-4"/>
            @forelse($attachments as $index => $attachment)
                <div class="flex items-center mx-4 mb-3 last:mb-0">
                    <p class="mr-auto text-gray-700 leading-5">{{ ++$index }}. {{ $attachment->name }}</p>
                    <a href="{{ route('administrator-attachment', ['id' => $attachment->id]) }}"
                       target="_blank"
                       class="flex items-center ml-8 text-green-light text-sm font-medium focus:outline-none hover:opacity-80">
                        <svg class="w-5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M4 16v1a3 3 0 003 3h10a3 3
                                          0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        <span class="hidden sm:block whitespace-nowrap">Скачать файл</span>
                    </a>
                </div>
            @empty
                <i class="mx-4 text-center text-gray-400">Файлы отсутствуют</i>
            @endforelse
        </div>
    </div>

    @include('popups.edit-visit-status')

    @if($visit->visit_status_id === 1 or \App\Facades\Authorization::user()->privileges_id === 2)
        @include('popups.move-visit')
    @endif

    @if(\App\Facades\Authorization::user()->privileges_id === 2)
        @include('popups.attach-illness')
        @include('popups.edit-visit-result')
        @include('popups.change-doctor')
        @include('popups.change-patient')
    @endif
@endsection
