<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    <title>@yield('title')</title>
</head>
<body class="bg-gray-100">
<div class="sticky top-0 z-40">
    <header class="bg-white">
        <div class="container flex items-center mx-auto px-4 sm:px-8">
            <a class="mr-auto py-4" href="{{ route('doctor-index') }}">
                <img class="h-7 sm:h-8" src="{{ asset('images/logo.png') }}" alt="logo">
            </a>
            <div class="flex items-center py-4 relative">
                <div class="hidden sm:flex flex-col text-right mr-5 select-none">
                    <p class="font-bold text-gray-500">
                        @php
                            $doctor = App\Facades\Authorization::user();

                            echo $doctor->last_name . ' ' . mb_substr($doctor->first_name, 0, 1) . '.' . mb_substr($doctor->middle_name, 0, 1) . '.';
                        @endphp
                    </p>
                    <span class="open-extra-dropdown-menu-btn flex items-center justify-end text-sm font-medium text-gray-400 cursor-pointer hover:opacity-70">
                        <svg class="mr-1 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M13 9l3 3m0 0l-3
                                  3m3-3H8m13 0a9 9 0
                                  11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Мой аккаунт
                    </span>
                </div>
                <div class="open-extra-dropdown-menu-btn rounded-full border-2 border-gray-300 bg-contain bg-no-repeat bg-center w-12 h-12 bg-gray-200"
                     style="background-image: {{ $profilePhoto !== null ? 'url(\'data:image/jpg;base64,' . base64_encode($profilePhoto) . '\'' : 'url(' . asset('images/default_profile.jpg') . ')' }}"></div>
                <div class="extra-dropdown-menu flex flex-col z-10 hidden absolute top-full right-0 bg-white shadow-2xl border-t border-gray-200">
                    <a class="flex px-4 py-2 hover:bg-gray-100" href="{{ route('doctor-profile') }}">
                        <svg class="w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M10.325 4.317c.426-1.756 2.924-1.756
                                  3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94
                                  3.31.826 2.37 2.37a1.724 1.724 0 001.065
                                  2.572c1.756.426 1.756 2.924 0 3.35a1.724
                                  1.724 0 00-1.066 2.573c.94 1.543-.826
                                  3.31-2.37 2.37a1.724 1.724 0 00-2.572
                                  1.065c-.426 1.756-2.924 1.756-3.35 0a1.724
                                  1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724
                                  1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724
                                  1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608
                                  2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <p class="whitespace-nowrap">Перейти в профиль</p>
                    </a>
                    <a class="flex px-4 py-2 text-red-500 hover:bg-gray-100" href="{{ route('doctor-logout') }}">
                        <svg class="w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M17 16l4-4m0 0l-4-4m4
                                  4H7m6 4v1a3 3 0 01-3 3H6a3 3 0
                                  01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <p>Выйти из системы</p>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <section id="openDropdownMenuBtn" class="xl:hidden bg-green-light py-2 cursor-pointer">
        <div class="container mx-auto flex items-center px-4 sm:px-8">
            <p class="mr-auto text-white select-none">Меню</p>
            <svg class="w-7 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </div>
    </section>

    <nav class="hidden xl:block bg-green-light xl:pt-4 xl:pb-4 transition-max-h duration-500 ease-linear max-h-0 xl:max-h-full xl:h-auto overflow-hidden">
        <div class="container flex flex-col xl:flex-row xl:justify-between mx-auto px-4 sm:px-8 xl:px-40 select-none">
            <a class="flex mb-2 xl:mb-0 items-center text-white {{ !request()->is('doctor') ? 'opacity-60' : '' }} hover:opacity-100" href="{{ route('doctor-index') }}">
                <svg class="mr-1 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M3 12l2-2m0 0l7-7
                          7 7M5 10v10a1 1 0 001
                          1h3m10-11l2 2m-2-2v10a1
                          1 0 01-1 1h-3m-6 0a1 1 0
                          001-1v-4a1 1 0 011-1h2a1 1
                          0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Мой кабинет
            </a>
            <a class="flex mb-2 xl:mb-0 items-center text-white {{ !request()->is('doctor/info') ? 'opacity-60' : '' }} hover:opacity-100" href="{{ route('doctor-info') }}">
                <svg class="mr-1 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M10 6H5a2 2 0 00-2
                          2v9a2 2 0 002 2h14a2 2
                          0 002-2V8a2 2 0 00-2-2h-5m-4
                          0V5a2 2 0 114 0v1m-4 0a2 2 0
                          104 0m-5 8a2 2 0 100-4 2 2 0
                          000 4zm0 0c1.306 0 2.417.835
                          2.83 2M9 14a3.001 3.001 0 00-2.83
                          2M15 11h3m-3 4h2" />
                </svg>
                Проф. информация
            </a>
            <a class="flex mb-2 xl:mb-0 items-center text-white {{ !request()->is('doctor/visits', 'doctor/visits/*') ? 'opacity-60' : '' }} hover:opacity-100" href="{{ route('doctor-visits') }}">
                <svg class="mr-1 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M12 4.354a4 4 0 110
                          5.292M15 21H3v-1a6 6
                          0 0112 0v1zm0 0h6v-1a6
                          6 0 00-9-5.197M13 7a4 4
                          0 11-8 0 4 4 0 018 0z" />
                </svg>
                Визиты
            </a>
            <a class="flex mb-2 xl:mb-0 items-center text-white {{ !request()->is('doctor/patients', 'doctor/patients/*') ? 'opacity-60' : '' }} hover:opacity-100" href="{{ route('doctor-patients') }}">
                <svg class="mr-1 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M16 7a4 4 0 11-8 0
                          4 4 0 018 0zM12 14a7
                          7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                Пациенты
            </a>
        </div>
    </nav>
</div>

<section class="mt-5 mb-10">
    <div class="container mx-auto sm:px-8">@yield('content')</div>
</section>
</body>
</html>
