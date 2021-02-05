@extends('layouts.auth')

@section('title', 'Cabinet | Регистрация')

@section('content')

    <div id="patientRegForm" class="flex flex-col pb-10 mx-3 w-full sm:w-550px rounded-xl shadow bg-white overflow-hidden">
        <div><div class="bg-green-light h-3 {{ 'w-' . (request()->step ?? '1') . '/4' }}"></div></div>
        <div class="px-4 sm:px-8 mt-14 flex flex-col">
            <p class="text-5xl font-light mb-4 text-gray-700 select-none">Создать аккаунт</p>
            @if(request()->step === '1' or request()->step === null)
                <label for="patientRegPhone" class="font-light mb-1 text-gray-700 select-none">Введите номер телефона:</label>
                <div class="grid grid-cols-7 mb-2">
                    <input
                        type="text"
                        name="phone_code"
                        autocomplete="off"
                        value="+7"
                        placeholder="+_"
                        class="border border-gray-300 border-r-0 rounded-l-md px-3 py-2 outline-none bg-gray-200 text-center tracking-widest text-gray-500 cursor-not-allowed"
                        readonly required>
                    <input
                        id="patientLoginPhone"
                        type="text"
                        name="phone"
                        placeholder="(___) ___ ____"
                        autocomplete="off"
                        class="border border-gray-300 rounded-r-md col-span-6 px-3 py-2 outline-none text-gray-600 tracking-widest"
                        required>
                </div>
                <span id="phoneNotRegisteredMessage" class="flex items-center mb-4 text-red-500 text-sm select-none hidden">
                    <svg class="w-5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    Данный номер уже зарегистрирован!
                </span>
                <hr class="mt-4 mb-6" />
                <button id="moveToSecondStepBtn" class="self-start px-4 py-2 border border-indigo-100 bg-indigo-100 text-white rounded-md transition duration-300 ease select-none hover:bg-indigo-200 hover:border-indigo-200 focus:outline-none focus:ring-4 focus:ring-indigo-100 focus:ring-opacity-50 disabled:opacity-50 disabled:bg-indigo-100 disabled:border-indigo-100 disabled:cursor-not-allowed" disabled>
                    Продолжить
                </button>
                <span class="mx-auto mt-6 text-sm text-gray-700 font-light select-none">Уже есть аккаунт? <a href="{{ route('patient-login-form') }}" class="text-blue-600 hover:underline">Войдите!</a></span>
            @elseif(request()->step === '2')
                <form id="patientRegSMSCodeForm" class="flex flex-col" action="{{ route('patient-reg-form') }}" method="get">
                    <label for="patientRegSMSCodeInput" class="font-light mb-4 text-gray-700 select-none">Введите код из полученного СМС-сообщения:</label>
                    <input
                        id="patientRegSMSCodeInput"
                        type="text"
                        name="code"
                        maxlength="4"
                        autocomplete="off"
                        class="w-24 self-center mb-2 border border-gray-300 rounded-md px-3 py-2 outline-none text-gray-600 text-center tracking-widest"
                        required>
                    <input type="hidden" name="step" value="3">
                    <input type="hidden" name="phone" value="{{ request()->phone }}">
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
                    <a href="{{ route('patient-reg-form') }}" class="mr-2 px-4 py-2 border border-gray-500 bg-gray-500 text-white rounded-md transition duration-300 ease select-none hover:bg-gray-600 hover:border-gray-600 focus:outline-none focus:ring-4 focus:ring-gray-500 focus:ring-opacity-50">
                        Назад
                    </a>
{{--                    <button class="px-4 py-2 border border-gray-500 text-gray-500 rounded-md transition duration-300 ease select-none hover:bg-gray-500 hover:border-gray-500 hover:text-white focus:outline-none focus:ring-4 focus:ring-gray-500 focus:ring-opacity-50">--}}
{{--                        Отправить SMS-код заново--}}
{{--                    </button>--}}
                </div>
            @elseif(request()->step === '3')
                <form id="createNewPatientForm" class="flex flex-col max-h-52 overflow-y-scroll" method="POST" action="{{ route('create-patient') }}">
                    <label for="patientRegFirstName" class="font-light mb-1 text-gray-700 select-none">Введите Ваше имя:</label>
                    <input
                        id="patientRegFirstName"
                        type="text"
                        name="first_name"
                        placeholder="Иван"
                        autocomplete="off"
                        value="{{ old('first_name') }}"
                        class="mb-3 border border-gray-300 rounded-md px-3 py-2 outline-none text-gray-600 tracking-widest"
                        required>

                    <label for="patientRegLastName" class="font-light mb-1 text-gray-700 select-none">Введите Вашу фамилию:</label>
                    <input
                        id="patientRegLastName"
                        type="text"
                        name="last_name"
                        placeholder="Иванов"
                        autocomplete="off"
                        value="{{ old('last_name') }}"
                        class="mb-3 border border-gray-300 rounded-md px-3 py-2 outline-none text-gray-600 tracking-widest"
                        required>

                    <label for="patientRegMiddleName" class="font-light mb-1 text-gray-700 select-none">Введите Ваше отчество (необязательно):</label>
                    <input
                        id="patientRegMiddleName"
                        type="text"
                        name="middle_name"
                        placeholder="Иванович"
                        autocomplete="off"
                        value="{{ old('middle_name') }}"
                        class="mb-6 border border-gray-300 rounded-md px-3 py-2 outline-none text-gray-600 tracking-widest">

                    <label for="patientRegPassword" class="font-light mb-1 text-gray-700 select-none">Придумайте пароль (мин. 8 символов):</label>
                    <input
                        id="patientRegPassword"
                        type="password"
                        name="password"
                        autocomplete="off"
                        class="mb-3 border border-gray-300 rounded-md px-3 py-2 outline-none text-gray-600 tracking-widest"
                        required>

                    <label for="patientRegPasswordConfirm" class="font-light mb-1 text-gray-700 select-none">Подтвердите пароль:</label>
                    <input
                        id="patientRegPasswordConfirm"
                        type="password"
                        name="password_confirmation"
                        autocomplete="off"
                        class="border border-gray-300 rounded-md px-3 py-2 outline-none text-gray-600 tracking-widest"
                        required>
                    @csrf
                </form>
                @foreach($errors->all() as $error)
                    <span class="flex items-center mt-3 text-red-500 text-sm select-none">
                        <svg class="w-5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        {{ $error }}
                    </span>
                @endforeach
                <hr class="mt-4 mb-6" />
                <div class="flex mb-4">
                    <button form="createNewPatientForm" class="mr-2 px-4 py-2 border border-indigo-100 bg-indigo-100 text-white rounded-md transition duration-300 ease select-none hover:bg-indigo-200 hover:border-indigo-200 focus:outline-none focus:ring-4 focus:ring-indigo-100 focus:ring-opacity-50">
                        Создать
                    </button>
                    <a href="{{ route('patient-reg-form') }}" class="px-4 py-2 border border-gray-500 text-gray-500 rounded-md transition duration-300 ease select-none hover:bg-gray-500 hover:border-gray-500 hover:text-white focus:outline-none focus:ring-4 focus:ring-gray-500 focus:ring-opacity-50">
                        Отменить
                    </a>
                </div>
            @endif
        </div>
    </div>

@endsection
