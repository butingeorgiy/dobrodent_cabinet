@extends('layouts.auth')

@section('title', 'Cabinet | Вход')

@section('content')

    <div id="patientLoginForm" class="flex flex-col pb-10 rounded-xl shadow bg-white overflow-hidden" style="width: 550px">
        <div><div class="bg-green-light h-3 {{ request()->step === '2' ? 'w-3/4' : 'w-1/4' }}"></div></div>
        <div class="px-8 mt-14 flex flex-col">
            <p class="text-5xl font-light mb-4 text-gray-700 select-none">Войти</p>
            @if(request()->step === '1' or request()->step === null)
                <label for="patientLoginPhone" class="font-light mb-2 text-gray-700 select-none">Введите номер телефона:</label>
                <div class="grid grid-cols-7 mb-2">
                    <input
                        type="text"
                        name="phone_code"
                        autocomplete="off"
                        value="+7"
                        placeholder="+_"
                        class="border border-gray-300 border-r-0 rounded-l-md px-3 py-2 outline-none bg-gray-200 text-center tracking-widest text-gray-500 cursor-not-allowed"
                        readonly>
                    <input
                        id="patientLoginPhone"
                        type="text"
                        name="phone"
                        placeholder="(___) ___ ____"
                        autocomplete="off"
                        class="border border-gray-300 rounded-r-md col-span-6 px-3 py-2 outline-none text-gray-600 tracking-widest">
                </div>
                <span id="phoneNotRegisteredMessage" class="flex items-center mb-4 text-red-500 text-sm select-none hidden">
                    <svg class="w-5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    Данный номер не зарегистрирован!
                </span>
                <label class="self-start flex items-center">
                    <input type="checkbox" name="need_to_save">
                    <span class="font-light text-sm ml-2 select-none text-gray-700">Запомнить меня</span>
                </label>
                <hr class="my-4" />
                <p class="font-light mb-2 text-gray-700 select-none">Войти с помощью:</p>
                <div class="flex mb-4">
                    <button id="authByPasswordBtn" class="mr-2 px-4 py-2 border border-indigo-100 bg-indigo-100 text-white rounded-md transition duration-300 ease select-none hover:bg-indigo-200 hover:border-indigo-200 focus:outline-none focus:ring-4 focus:ring-indigo-100 focus:ring-opacity-50 disabled:opacity-50 disabled:bg-indigo-100 disabled:border-indigo-100 disabled:cursor-not-allowed" disabled>
                        Пароль
                    </button>
                    <button id="authBySmsCodeBtn" class="px-4 py-2 border border-indigo-100 text-indigo-100 rounded-md transition duration-300 ease select-none hover:bg-indigo-100 hover:border-indigo-100 hover:text-white focus:outline-none focus:ring-4 focus:ring-indigo-100 focus:ring-opacity-50 disabled:opacity-50 disabled:border-indigo-100 disabled:text-indigo-100 disabled:bg-white disabled:cursor-not-allowed" disabled>
                        SMS-подтверждение
                    </button>
                </div>
                <button class="self-start px-4 py-2 border border-gray-500 text-gray-500 rounded-md transition duration-300 ease select-none hover:bg-gray-500 hover:border-gray-500 hover:text-white focus:outline-none focus:ring-4 focus:ring-gray-500 focus:ring-opacity-50">
                    Забыли пароль?
                </button>
                <span class="mx-auto mt-6 text-sm text-gray-700 font-light select-none">Нет аккаунта? <a href="{{ route('patient-reg-form') }}" class="text-blue-600 hover:underline">Загеристрируйтесь!</a></span>
            @elseif(request()->step === '2' and request()->type === 'code')
                <form id="patientLoginSMSCodeForm" class="flex flex-col" action="{{ route('patient-login-by-code') }}" method="POST">
                    <label for="patientLoginSMSCodeInput" class="font-light mb-4 text-gray-700 select-none">Введите код из полученного СМС-сообщения:</label>
                    <input
                        id="patientLoginSMSCodeInput"
                        type="text"
                        name="code"
                        maxlength="4"
                        autocomplete="off"
                        class="w-24 self-center mb-2 border border-gray-300 rounded-md px-3 py-2 outline-none text-gray-600 text-center tracking-widest"
                        required>
                    <input type="hidden" name="needToSave" value="{{ request()->get('save') }}">
                    @csrf
                </form>
                @foreach($errors->all() as $error)
                    <span class="flex items-center text-red-500 text-sm select-none error-message">
                        <svg class="w-5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        {{ $error }}
                    </span>
                @endforeach
                <hr class="mt-8 mb-4" />
                <div class="flex">
                    <a href="{{ route('patient-login-form') }}" class="mr-2 px-4 py-2 border border-gray-500 bg-gray-500 text-white rounded-md transition duration-300 ease select-none hover:bg-gray-600 hover:border-gray-600 focus:outline-none focus:ring-4 focus:ring-gray-500 focus:ring-opacity-50">
                        Назад
                    </a>
                    <button class="px-4 py-2 border border-gray-500 text-gray-500 rounded-md transition duration-300 ease select-none hover:bg-gray-500 hover:border-gray-500 hover:text-white focus:outline-none focus:ring-4 focus:ring-gray-500 focus:ring-opacity-50">
                        Отправить SMS-код заново
                    </button>
                </div>
            @elseif(request()->step === '2' and request()->type === 'password')
                <form id="patientLoginByPasswordFrom" class="flex flex-col" action="{{ route('patient-login-by-password') }}" method="POST">
                    <label for="patientLoginPasswordInput" class="font-light mb-4 text-gray-700 select-none">Введите пароль:</label>
                    <input
                        id="patientLoginPasswordInput"
                        type="password"
                        name="password"
                        autocomplete="off"
                        class="mb-2 border border-gray-300 rounded-md px-3 py-2 outline-none text-gray-600 tracking-widest"
                        required>
                    <input type="hidden" name="phone" value="{{ request()->get('phone') }}">
                    <input type="hidden" name="needToSave" value="{{ request()->get('save') }}">
                    @csrf
                </form>
                @foreach($errors->all() as $error)
                    <span class="flex items-center text-red-500 text-sm select-none">
                        <svg class="w-5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    {{ $error }}
                    </span>
                @endforeach
                <hr class="mt-8 mb-4" />
                <div class="flex">
                    <button form="patientLoginByPasswordFrom" class="mr-2 px-4 py-2 border border-indigo-100 bg-indigo-100 text-white rounded-md transition duration-300 ease select-none hover:bg-indigo-200 hover:border-indigo-200 focus:outline-none focus:ring-4 focus:ring-indigo-100 focus:ring-opacity-50">
                        Войти
                    </button>
                    <a href="{{ route('patient-login-form') }}" class="px-4 py-2 border border-gray-500 text-gray-500 rounded-md transition duration-300 ease select-none hover:bg-gray-500 hover:border-gray-500 hover:text-white focus:outline-none focus:ring-4 focus:ring-gray-500 focus:ring-opacity-50">
                        Назад
                    </a>
                </div>
            @endif
        </div>
    </div>

@endsection
