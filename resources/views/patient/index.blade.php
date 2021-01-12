@extends('layouts.main')

@section('title', 'Cabinet | Кабинет пользователя')

@section('content')
    <div class="flex">
        <div class="bg-green-light w-8 mr-4 shadow-sm"></div>
        <div class="w-full bg-white shadow-md p-4">
            <div class="flex items-center mb-2 rounded-md border border-gray-300 px-4 py-3">
                <svg class="w-6 mr-5 text-green-light" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M21 21l-6-6m2-5a7
                          7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input class="w-full text-gray-500 placeholder-gray-500 text-xl outline-none" type="text" placeholder="Поиск врачей...">
            </div>
            <div class="grid grid-cols-2">
                <div class="px-2">
                    <p class="text-gray-400 mb-1">Часто ищут:</p>
                    <div><i class="text-sm text-gray-300">Список пуст...</i></div>
                </div>
                <div class="px-2">
                    <p class="text-gray-400">Недавно искали:</p>
                    <div><i class="text-sm text-gray-300">Список пуст...</i></div>
                </div>
            </div>
        </div>
    </div>
@endsection
