@extends('layouts.auth')

@section('title', 'Cabinet | Вход как администратор')

@section('content')
    <div class="flex flex-col pb-10 mx-3 w-full sm:w-550px rounded-xl shadow bg-white overflow-hidden">
        <div><div class="bg-green-light h-3 w-1/4"></div></div>
        <div class="px-4 sm:px-8 mt-14 flex flex-col">
            <p class="text-5xl font-light mb-4 text-gray-700 select-none">Войти</p>
            <form id="administratorLoginForm" class="flex flex-col" method="POST" action="{{ route('administrator-login') }}">
                <label for="administratorPhone" class="font-light mb-1 text-gray-700 select-none">Введите Ваш номер:</label>
                <input
                    id="administratorPhone"
                    type="text"
                    name="login"
                    autocomplete="off"
                    placeholder="+7 (___) ___ ____"
                    value="{{ old('login') }}"
                    class="mb-2 border border-gray-300 rounded-md px-3 py-2 outline-none text-gray-600 tracking-widest"
                    required>

                <label for="administratorPassword" class="font-light mb-1 text-gray-700 select-none">Введите Ваш пароль:</label>
                <input
                    id="administratorPassword"
                    type="password"
                    name="password"
                    autocomplete="off"
                    class="mb-2 border border-gray-300 rounded-md px-3 py-2 outline-none text-gray-600 tracking-widest"
                    required>
                <label class="self-start flex items-center">
                    <input type="checkbox" name="save">
                    <span class="font-light text-sm ml-2 select-none text-gray-700">Запомнить меня</span>
                </label>
                @csrf
            </form>
            @foreach($errors->all() as $error)
                <span class="flex items-center mt-4 text-red-500 text-sm select-none">
                    <svg class="w-5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    {{ $error }}
                </span>
            @endforeach
            <hr class="mt-4 mb-6" />
            <div class="flex mb-4">
                <button form="administratorLoginForm" class="mr-2 px-4 py-2 border border-indigo-100 bg-indigo-100 text-white rounded-md transition duration-300 ease select-none hover:bg-indigo-200 hover:border-indigo-200 focus:outline-none focus:ring-4 focus:ring-indigo-100 focus:ring-opacity-50">
                    Войти
                </button>
{{--                <button class="px-4 py-2 border border-gray-500 text-gray-500 rounded-md transition duration-300 ease select-none hover:bg-gray-500 hover:border-gray-500 hover:text-white focus:outline-none focus:ring-4 focus:ring-gray-500 focus:ring-opacity-50">--}}
{{--                    Забыли пароль?--}}
{{--                </button>--}}
            </div>
        </div>
    </div>
@endsection
