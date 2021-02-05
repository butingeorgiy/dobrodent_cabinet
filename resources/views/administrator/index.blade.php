@extends('layouts.admin-main')

@section('title', 'Cabinet | Кабинет администратора')

@section('content')
    <div class="mb-4 pt-4 bg-white shadow-md select-none">
        <p class="mx-4 text-xl sm:text-2xl text-gray-400">Основные возможности</p>
        <hr class="mt-4" />
        <div class="grid grid-cols-1 md:grid-cols-2">
            <a href="{{ route('administrator-visits-create') }}" class="flex p-4 hover:bg-gray-50 cursor-pointer">
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
                    <p class="mb-2 font-medium text-lg sm:text-xl text-green-light">Онлайн запись пациентов на визит</p>
                    <p class="text-sm text-gray-700">
                        Тут будет описание данной возможности, а пока что программист не знает что тут написать.
                        Тут будет описание данной возможности, а пока что программист не знает что тут написать.
                    </p>
                </div>
            </a>

            <a href="{{ route('administrator-visits') }}" class="flex p-4 hover:bg-gray-50 cursor-pointer">
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
                    <p class="mb-2 font-medium text-lg sm:text-xl text-green-light">Отслеживание всех визитов сети Dobro Dent</p>
                    <p class="text-sm text-gray-700">
                        Тут будет описание данной возможности, а пока что программист не знает что тут написать.
                        Тут будет описание данной возможности, а пока что программист не знает что тут написать.
                    </p>
                </div>
            </a>

            <a href="{{ route('administrator-patients') }}" class="flex p-4 hover:bg-gray-50 cursor-pointer">
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

            <a href="{{ route('administrator-doctors') }}" class="flex p-4 hover:bg-gray-50 cursor-pointer">
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
                    <p class="mb-2 font-medium text-lg sm:text-xl text-green-light">База всех врачей в одном месте</p>
                    <p class="text-sm text-gray-700">
                        Тут будет описание данной возможности, а пока что программист не знает что тут написать.
                        Тут будет описание данной возможности, а пока что программист не знает что тут написать.
                    </p>
                </div>
            </a>
        </div>
    </div>
@endsection
