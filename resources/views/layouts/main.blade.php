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
    <div class="sticky top-0">
        <header class="bg-white">
            <div class="container flex items-center mx-auto px-8">
                <a class="mr-auto py-4" href="{{ route('patient-index') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="logo" width="150px">
                </a>
                <div class="flex items-center py-4 relative">
                    <div class="flex flex-col text-right mr-5 select-none">
                        <p class="font-bold text-gray-500">+ 7 (747) 505 1903</p>
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
                    <div class="rounded-full bg-contain bg-no-repeat bg-center w-12 h-12 bg-gray-200"
                         style="background-image: {{ $profilePhoto !== null ? 'url(\'data:image/jpg;base64,' . base64_encode($profilePhoto) . '\'' : 'url(' . asset('images/default_profile.jpg') . ')' }}"></div>
                    <div class="extra-dropdown-menu flex flex-col z-10 hidden absolute top-full right-0 bg-white shadow-2xl border-t border-gray-200">
                        <a class="flex px-4 py-2 hover:bg-gray-100" href="{{ route('patient-profile') }}">
                            <svg class="w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <p class="whitespace-nowrap">Перейти в профиль</p>
                        </a>
                        <a class="flex px-4 py-2 text-red-500 hover:bg-gray-100" href="#">
                            <svg class="w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <p>Выйти из системы</p>
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <section id="openDropdownMenuBtn" class="xl:hidden bg-green-light py-2 cursor-pointer">
            <div class="container mx-auto flex items-center px-8">
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
            <div class="container flex flex-col xl:flex-row xl:justify-between mx-auto px-8 xl:px-16 select-none">
                <a class="flex mb-2 xl:mb-0 items-center text-white {{ !request()->is('patient') ? 'opacity-60' : '' }} hover:opacity-100" href="{{ route('patient-index') }}">
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

                <a class="flex mb-2 xl:mb-0 items-center text-white opacity-60 hover:opacity-100" href="#">
                    <svg class="mr-1 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M12 6.253v13m0-13C10.832
                          5.477 9.246 5 7.5 5S4.168
                          5.477 3 6.253v13C4.168 18.477
                          5.754 18 7.5 18s3.332.477 4.5
                          1.253m0-13C13.168 5.477 14.754
                          5 16.5 5c1.747 0 3.332.477 4.5
                          1.253v13C19.832 18.477 18.247
                          18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    Мед. карта
                </a>

                <a class="flex mb-2 xl:mb-0 items-center text-white opacity-60 hover:opacity-100" href="#">
                    <svg class="mr-1 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M8 7V3m8 4V3m-9
                          8h10M5 21h14a2 2 0
                          002-2V7a2 2 0 00-2-2H5a2
                          2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    События
                </a>

                <a class="flex mb-2 xl:mb-0 items-center text-white opacity-60 hover:opacity-100" href="#">
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

                <a class="flex mb-2 xl:mb-0 items-center text-white opacity-60 hover:opacity-100" href="#">
                    <svg class="mr-1 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M9 5H7a2 2 0 00-2
                          2v12a2 2 0 002 2h10a2
                          2 0 002-2V7a2 2 0
                          00-2-2h-2M9 5a2 2 0
                          002 2h2a2 2 0 002-2M9
                          5a2 2 0 012-2h2a2 2 0
                          012 2m-3 7h3m-3
                          4h3m-6-4h.01M9 16h.01" />
                    </svg>
                    Прайс лист
                </a>

                <a class="flex mb-2 xl:mb-0 items-center text-white opacity-60 hover:opacity-100" href="#">
                    <svg class="mr-1 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M16 4v12l-4-2-4
                          2V4M6 20h12a2 2 0
                          002-2V6a2 2 0 00-2-2H6a2
                          2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    База знаний
                </a>

                <a class="flex mb-2 xl:mb-0 items-center text-white opacity-60 hover:opacity-100" href="#">
                    <svg class="mr-1 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M19 21V5a2 2 0
                          00-2-2H7a2 2 0 00-2
                          2v16m14 0h2m-2 0h-5m-9
                          0H3m2 0h5M9 7h1m-1
                          4h1m4-4h1m-1 4h1m-5
                          10v-5a1 1 0 011-1h2a1
                          1 0 011 1v5m-4 0h4" />
                    </svg>
                    Клиники
                </a>

                <a class="flex mb-2 xl:mb-0 items-center text-white opacity-60 hover:opacity-100" href="#">
                    <svg class="mr-1 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M16 7a4 4 0 11-8 0
                          4 4 0 018 0zM12 14a7
                          7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Врачи
                </a>

                <a class="flex mb-4 xl:mb-0 items-center text-white opacity-60 hover:opacity-100" href="#">
                    <svg class="mr-1 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M7 4v16M17 4v16M3
                          8h4m10 0h4M3 12h18M3
                          16h4m10 0h4M4 20h16a1
                          1 0 001-1V5a1 1 0 00-1-1H4a1
                          1 0 00-1 1v14a1 1 0 001 1z" />
                    </svg>
                    Медиафайлы
                </a>
            </div>
        </nav>
    </div>

    <section class="my-5">
        <div class="container mx-auto px-8">@yield('content')</div>
    </section>
</body>
</html>
