@extends('layouts.doctor-main')

@section('title', 'Cabinet | Кабинет врача')

@section('content')
    <div class="grid grid-cols-3 gap-4 select-none">
        <div class="col-span-full lg:col-span-2 flex flex-col bg-white shadow-md py-4">
            <div class="flex items-center px-4">
                <p class="mr-auto text-xl sm:text-2xl text-green-light font-medium">Визит № {{ $visit->id }}</p>
            </div>
            <hr class="my-4"/>
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

            <div class="flex items-start sm:items-center mx-4 mb-2 leading-5">
                <p class="mr-2 sm:text-lg text-gray-400">Пациент:</p>
                <a href="{{ route('doctor-patient', ['id' => $visit->patient->id]) }}"
                   class="text-gray-500 hover:underline">{{ $visit->patient->last_name . ' ' . mb_substr($visit->patient->first_name, 0, 1) . '.' . mb_substr($visit->patient->middle_name, 0, 1) . '.' }}</a>
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
                    <i class="text-gray-500 text-sm sm:text-base">Вы ещё не составили заключение</i>
                @endif
            </div>
        </div>
        <div class="col-span-full lg:col-span-1 row-auto flex flex-col">
            <div class="py-4 bg-white shadow-md">
                <p class="mx-4 text-xl sm:text-2xl text-gray-400">Действия</p>
                <hr class="my-4"/>
                @php $hasActions = false; @endphp
                @if($visit->visit_status_id === 1)
                    @php $hasActions = true; @endphp
                    <a href=""
                       class="move-visit-btn flex justify-center items-center mb-2 mx-4 px-4 py-2 border border-indigo-100 bg-indigo-100 text-sm sm:text-base text-white rounded-md transition duration-300 ease hover:bg-indigo-200 hover:border-indigo-200 focus:outline-none focus:ring-4 focus:ring-indigo-100 focus:ring-opacity-50">
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
                @if(!in_array($visit->visit_status_id, [5, 6]))
                    @php $hasActions = true; @endphp
                    <a href=""
                       class="edit-visit-status-btn flex justify-center items-center mx-4 mb-2 last:mb-0 px-4 py-2 border border-gray-500 text-sm sm:text-base text-gray-500 rounded-md transition duration-300 ease hover:bg-gray-500 hover:border-gray-500 hover:text-white focus:outline-none focus:ring-4 focus:ring-gray-500 focus:ring-opacity-50">
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
                        Изменить статус
                    </a>
                    <a href=""
                       class="edit-visit-illness-btn flex justify-center items-center mx-4 mb-2 last:mb-0 px-4 py-2 border border-red-400 text-sm sm:text-base text-red-400 rounded-md transition duration-300 ease hover:bg-red-400 hover:border-red-400 hover:text-white focus:outline-none focus:ring-4 focus:ring-red-400 focus:ring-opacity-50">
                        <svg class="w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2
                                  0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2
                                  2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/>
                        </svg>
                        Привязать заболевание
                    </a>
                    <a href=""
                       class="edit-visit-result-btn flex justify-center items-center mx-4 mb-2 last:mb-0 px-4 py-2 border border-green-light text-sm sm:text-base text-green-light rounded-md transition duration-300 ease hover:bg-green-light hover:border-green-light hover:text-white focus:outline-none focus:ring-4 focus:ring-green-light focus:ring-opacity-50">
                        <svg class="w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0
                              01-2-2V5a2 2 0 012-2h5.586a1 1
                              0 01.707.293l5.414 5.414a1 1 0
                              01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Составить заключение
                    </a>
                @endif
                @if(!$hasActions)<i class="mx-4 text-gray-400">Нет доступных действий</i>@endif
            </div>
        </div>
        <div class="col-span-full lg:col-span-2 flex flex-col bg-white shadow-md py-4">
            <p class="mx-4 text-xl sm:text-2xl text-gray-400">Прикреплённые файлы</p>
            <hr class="mt-4"/>
            @if(count($attachments) !== 0)
                <div class="flex flex-col mt-4 mb-2">
                    @foreach($attachments as $index => $attachment)
                        <div class="flex items-center mx-4 mb-3 last:mb-0">
                            <p class="mr-auto text-gray-700 leading-5">{{ ++$index }}. {{ $attachment->name }}</p>
                            <a href="{{ route('doctor-attachment', ['id' => $attachment->id]) }}"
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
                            @if(!in_array($visit->visit_status_id, [5,6]))
                                <a href="{{ route('doctor-delete-attachment', ['id' => $attachment->id]) }}"
                                    class="flex items-center ml-4 text-red-400 text-sm font-medium focus:outline-none hover:opacity-80">
                                    <svg class="w-5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke="currentColor">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2
                                              2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0
                                              00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    <span class="hidden sm:block whitespace-nowrap">Удалить файл</span>
                                </a>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
            @if(!in_array($visit->visit_status_id, [5,6]))
                <form class="flex justify-center upload-attachment-form mt-4" method="POST"
                      action="{{ route('upload-attachment', ['id' => $visit->id]) }}" enctype="multipart/form-data">
                    <label class="flex justify-center items-center mx-4 px-4 py-2 border border-gray-500 text-gray-500 text-sm rounded-md transition duration-300 ease hover:bg-gray-500 hover:border-gray-500 hover:text-white cursor-pointer">
                        <svg class="w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M4 16v1a3 3 0 003 3h10a3 3 0
                                  003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                        </svg>
                        <span>Добавить файл</span>
                        <input type="file" name="attachment" hidden>
                        @csrf
                    </label>
                </form>
            @elseif(count($attachments) === 0)
                <i class="mx-4 mt-4 text-base text-gray-400">Файлы отсутствуют</i>
            @endif
        </div>
    </div>

    @include('popups.edit-visit-status')

    @if($visit->visit_status_id === 1)
        @include('popups.move-visit')
    @endif

    @if(!in_array($visit->visit_status_id, [5, 6]))
        @include('popups.attach-illness')
        @include('popups.edit-visit-result')
    @endif

@endsection
