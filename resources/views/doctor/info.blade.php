@extends('layouts.doctor-main')

@section('title', 'Cabinet | Кабинет врача')

@section('content')
    <div class="mx-auto sm:max-w-xl bg-white shadow py-5">
        <p class="px-4 text-xl sm:text-2xl text-gray-400 select-none">Профессиональная информация</p>
        <hr class="my-4" />
        <form action="{{ route('doctor-info-update') }}" method="POST" id="doctorProfessionalInfoForm" class="flex flex-col px-4">
            <label class="flex flex-col w-full mb-3">
                <span class="mb-1">Ваша специализация</span>
                <select class="occupation-select" name="occupation" required multiple>
                    @foreach($occupations as $occupation)
                        <option value="{{ $occupation->id }}" {{ $doctor->occupations->contains($occupation->id) ? 'selected' : '' }}>{{ $occupation->title }}</option>
                    @endforeach
                </select>
                <input hidden type="text" name="occupation">
            </label>
            <div class="flex flex-col w-full mb-3">
                <span class="mb-1">Проф. описание</span>
                <div id="doctorDescriptionEditor">{!! $doctor->description !!}</div>
                <input type="text" name="description" hidden>
            </div>
            <span class="flex items-center text-red-500 text-sm select-none error-message {{ !$errors->any() ? 'hidden' : '' }}">
                <svg class="w-5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M12 9v2m0 4h.01m-6.938
                          4h13.856c1.54 0 2.502-1.667
                          1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464
                          0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                @forelse ($errors->all() ?? [] as $error)
                    <span>{{ $error }}</span>
                @empty
                    <span></span>
                @endforelse
            </span>
            @if(session('success'))
                <span class="flex items-center text-green-light text-sm select-none success-message">
                    <svg class="w-5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M9 12l2 2 4-4m5.618-4.016A11.955
                              11.955 0 0112 2.944a11.955 11.955
                              0 01-8.618 3.04A12.02 12.02 0 003
                              9c0 5.591 3.824 10.29 9 11.622 5.176-1.332
                              9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </span>
            @endif
            <label class="hidden flex flex-col px-4 py-3 bg-green-light bg-opacity-30">
                <span class="mb-1 text-gray-600">Введите пароль чтобы сохранить изменения</span>
                <input class="mb-3 border border-gray-300 rounded-md px-3 py-2 outline-none text-gray-500" type="password" name="password" required>
                <span class="flex">
                    <button id="confirmDoctorProfessionalInfoBtn" class="mr-2 px-4 py-2 border border-green-light bg-green-light text-sm sm:text-base text-white rounded-md transition duration-300 ease select-none hover:bg-green-light hover:border-green-light focus:outline-none focus:ring-4 focus:ring-green-light focus:ring-opacity-50">
                        Сохранить
                    </button>
                    <a href="" class="px-4 py-2 border border-gray-500 text-sm sm:text-base text-gray-500 rounded-md transition duration-300 ease select-none hover:bg-gray-500 hover:border-gray-500 hover:text-white focus:outline-none focus:ring-4 focus:ring-gray-500 focus:ring-opacity-50">
                        Отмена
                    </a>
                </span>
            </label>
            @csrf
            <button id="saveDoctorProfessionalInfoBtn" type="button" class="mt-4 px-4 py-2 border border-green-light bg-green-light text-sm sm:text-base text-white rounded-md transition duration-300 ease select-none hover:opacity-80 focus:outline-none focus:ring-4 focus:ring-green-light focus:ring-opacity-50">
                Сохранить изменения
            </button>
        </form>
    </div>
@endsection
