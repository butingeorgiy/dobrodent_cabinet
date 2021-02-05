@extends('layouts.main')

@section('title', 'Cabinet | Кабинет пользователя')

@section('content')
    <div class="flex flex-col xl:flex-row mb-4 bg-white shadow-md select-none">
        <div class="flex flex-col lg:flex-row w-full">
            <div class="p-4">
                <p class="text-xl sm:text-2xl text-green-light font-medium">Филиал на Навои</p>
                <p class="text-gray-500 text-sm sm:text-base">ул. Навои 210/2, 1 этаж</p>
                <p class="mt-4 mb-1 text-gray-500 font-medium">График работы:</p>
                <p class="text-gray-500">
                    пн, ср, пт, вс: 9.00-19.30;<br>
                    вт, чт, сб: 9.00-23.00
                </p>
                <p class="mt-4 mb-1 text-gray-500 font-medium">Телефон:</p>
                <a href="tel:+77750300909" class="text-gray-500">+7 (775) 030 09 09</a>
            </div>
            <div class="flex lg:justify-center lg:items-center lg:mx-auto">
                <div class="grid grid-cols-1 grid-rows-4 sm:grid-cols-2 sm:grid-rows-2 gap-2 mx-4 lg:mx-0 w-full lg:w-auto">
                    <a href="{{ route('patient-visits-create', ['dest' => 'c1']) }}"
                       class="flex items-center justify-center px-4 py-2 border border-gray-500 text-gray-500 text-sm rounded-md transition duration-300 ease select-none hover:bg-gray-500 hover:border-gray-500 hover:text-white focus:outline-none focus:ring-4 focus:ring-gray-500 focus:ring-opacity-50">
                        <svg class="w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M8 7V3m8 4V3m-9 8h10M5
                                  21h14a2 2 0 002-2V7a2 2 0
                                  00-2-2H5a2 2 0 00-2 2v12a2
                                  2 0 002 2z"/>
                        </svg>
                        Записаться на приём
                    </a>

                    <a href="https://2gis.kz/almaty/firm/70000001040728780?m=76.886122%2C43.204863%2F16&utm_source=bigMap&utm_medium=widget-source&utm_campaign=firmsonmap"
                       target="_blank"
                       class="flex items-center justify-center px-4 py-2 border border-gray-500 text-gray-500 text-sm rounded-md transition duration-300 ease select-none hover:bg-gray-500 hover:border-gray-500 hover:text-white focus:outline-none focus:ring-4 focus:ring-gray-500 focus:ring-opacity-50">
                        <svg class="w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1
                              0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553
                              2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                        </svg>
                        Показать на карте
                    </a>

                    <a href="https://2gis.kz/almaty/directions/tab/bus/points/%7C76.88613%2C43.204289?m=76.88613%2C43.204289%2F16&utm_source=route&utm_medium=widget-source&utm_campaign=firmsonmap"
                       target="_blank"
                       class="flex items-center justify-center px-4 py-2 border border-gray-500 text-gray-500 text-sm rounded-md transition duration-300 ease select-none hover:bg-gray-500 hover:border-gray-500 hover:text-white focus:outline-none focus:ring-4 focus:ring-gray-500 focus:ring-opacity-50">
                        <svg class="w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M17.657 16.657L13.414 20.9a1.998 1.998
                              0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Проложить маршрут
                    </a>
                </div>
            </div>
        </div>
        <div class="mt-6 xl:mt-0 min-w-80 w-full h-60 xl:w-80 xl:h-80 map-container overflow-hidden">
            <iframe style="border: none; box-sizing: border-box;"
                    src="https://widgets.2gis.com/widget?type=firmsonmap&amp;options=%7B%22pos%22%3A%7B%22lat%22%3A43.204863003578964%2C%22lon%22%3A76.8861222267151%2C%22zoom%22%3A16%7D%2C%22opt%22%3A%7B%22city%22%3A%22almaty%22%7D%2C%22org%22%3A%2270000001040728780%22%7D">
            </iframe>
        </div>
    </div>

    <div class="flex flex-col xl:flex-row mb-4 bg-white shadow-md select-none">
        <div class="flex flex-col lg:flex-row w-full">
            <div class="p-4">
                <p class="text-xl sm:text-2xl text-green-light font-medium">Филиал на Толе Би</p>
                <p class="text-gray-500 text-sm sm:text-base">ул. Толе Би 221, 1 этаж</p>
                <p class="mt-4 mb-1 text-gray-500 font-medium">График работы:</p>
                <p class="text-gray-500">
                    пн, ср, пт: 9.00-23.00;<br>
                    вт, чт, сб, вс: 9.00-19.30
                </p>
                <p class="mt-4 mb-1 text-gray-500 font-medium">Телефон:</p>
                <a href="tel:+77750300909" class="text-gray-500">+7 (775) 030 09 09</a>
            </div>
            <div class="flex lg:justify-center lg:items-center lg:mx-auto">
                <div class="grid grid-cols-1 grid-rows-4 sm:grid-cols-2 sm:grid-rows-2 gap-2 mx-4 lg:mx-0 w-full lg:w-auto">
                    <a href="{{ route('patient-visits-create', ['dest' => 'c2']) }}"
                       class="flex items-center justify-center px-4 py-2 border border-gray-500 text-gray-500 text-sm rounded-md transition duration-300 ease select-none hover:bg-gray-500 hover:border-gray-500 hover:text-white focus:outline-none focus:ring-4 focus:ring-gray-500 focus:ring-opacity-50">
                        <svg class="w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M8 7V3m8 4V3m-9 8h10M5
                                  21h14a2 2 0 002-2V7a2 2 0
                                  00-2-2H5a2 2 0 00-2 2v12a2
                                  2 0 002 2z"/>
                        </svg>
                        Записаться на приём
                    </a>

                    <a href="https://2gis.kz/almaty/firm/70000001018607728?m=76.88168%2C43.251423%2F16&utm_source=bigMap&utm_medium=widget-source&utm_campaign=firmsonmap"
                       target="_blank"
                       class="flex items-center justify-center px-4 py-2 border border-gray-500 text-gray-500 text-sm rounded-md transition duration-300 ease select-none hover:bg-gray-500 hover:border-gray-500 hover:text-white focus:outline-none focus:ring-4 focus:ring-gray-500 focus:ring-opacity-50">
                        <svg class="w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1
                              0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553
                              2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                        </svg>
                        Показать на карте
                    </a>

                    <a href="https://2gis.kz/almaty/directions/tab/bus/points/%7C76.881679%2C43.250843?m=76.881679%2C43.250843%2F16&utm_source=route&utm_medium=widget-source&utm_campaign=firmsonmap"
                       target="_blank"
                       class="flex items-center justify-center px-4 py-2 border border-gray-500 text-gray-500 text-sm rounded-md transition duration-300 ease select-none hover:bg-gray-500 hover:border-gray-500 hover:text-white focus:outline-none focus:ring-4 focus:ring-gray-500 focus:ring-opacity-50">
                        <svg class="w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M17.657 16.657L13.414 20.9a1.998 1.998
                              0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Проложить маршрут
                    </a>
                </div>
            </div>
        </div>
        <div class="mt-6 xl:mt-0 min-w-80 w-full h-60 xl:w-80 xl:h-80 map-container overflow-hidden">
            <iframe style="border: none; box-sizing: border-box;"
                    src="https://widgets.2gis.com/widget?type=firmsonmap&options=%7B%22pos%22%3A%7B%22lat%22%3A43.25142329420366%2C%22lon%22%3A76.88168048858644%2C%22zoom%22%3A16%7D%2C%22opt%22%3A%7B%22city%22%3A%22almaty%22%7D%2C%22org%22%3A%2270000001018607728%22%7D">
            </iframe>
        </div>
    </div>

    <div class="flex flex-col xl:flex-row mb-4 bg-white shadow-md select-none">
        <div class="flex flex-col lg:flex-row w-full">
            <div class="p-4">
                <p class="text-xl sm:text-2xl text-green-light font-medium">Филиал на Сейфуллина</p>
                <p class="text-gray-500 text-sm sm:text-base">пр. Сейфуллина 534, 1 этаж</p>
                <p class="mt-4 mb-1 text-gray-500 font-medium">График работы:</p>
                <p class="text-gray-500">
                    пн, пт, сб, вс: 9.00-19.30;<br>
                    вт, ср, чт: 9.00-23.00
                </p>
                <p class="mt-4 mb-1 text-gray-500 font-medium">Телефон:</p>
                <a href="tel:+77750300909" class="text-gray-500">+7 (775) 030 09 09</a>
            </div>
            <div class="flex lg:justify-center lg:items-center lg:mx-auto">
                <div class="grid grid-cols-1 grid-rows-4 sm:grid-cols-2 sm:grid-rows-2 gap-2 mx-4 lg:mx-0 w-full lg:w-auto">
                    <a href="{{ route('patient-visits-create', ['dest' => 'c3']) }}"
                       class="flex items-center justify-center px-4 py-2 border border-gray-500 text-gray-500 text-sm rounded-md transition duration-300 ease select-none hover:bg-gray-500 hover:border-gray-500 hover:text-white focus:outline-none focus:ring-4 focus:ring-gray-500 focus:ring-opacity-50">
                        <svg class="w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M8 7V3m8 4V3m-9 8h10M5
                                  21h14a2 2 0 002-2V7a2 2 0
                                  00-2-2H5a2 2 0 00-2 2v12a2
                                  2 0 002 2z"/>
                        </svg>
                        Записаться на приём
                    </a>

                    <a href="https://2gis.kz/almaty/firm/70000001025801936?m=76.934617%2C43.243046%2F16&utm_source=bigMap&utm_medium=widget-source&utm_campaign=firmsonmap"
                       target="_blank"
                       class="flex items-center justify-center px-4 py-2 border border-gray-500 text-gray-500 text-sm rounded-md transition duration-300 ease select-none hover:bg-gray-500 hover:border-gray-500 hover:text-white focus:outline-none focus:ring-4 focus:ring-gray-500 focus:ring-opacity-50">
                        <svg class="w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1
                              0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553
                              2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                        </svg>
                        Показать на карте
                    </a>

                    <a href="https://2gis.kz/almaty/directions/tab/bus/points/%7C76.934626%2C43.242465?m=76.934626%2C43.242465%2F16&utm_source=route&utm_medium=widget-source&utm_campaign=firmsonmap"
                       target="_blank"
                       class="flex items-center justify-center px-4 py-2 border border-gray-500 text-gray-500 text-sm rounded-md transition duration-300 ease select-none hover:bg-gray-500 hover:border-gray-500 hover:text-white focus:outline-none focus:ring-4 focus:ring-gray-500 focus:ring-opacity-50">
                        <svg class="w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M17.657 16.657L13.414 20.9a1.998 1.998
                              0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Проложить маршрут
                    </a>
                </div>
            </div>
        </div>
        <div class="mt-6 xl:mt-0 min-w-80 w-full h-60 xl:w-80 xl:h-80 map-container overflow-hidden">
            <iframe style="border: none; box-sizing: border-box;"
                    src="https://widgets.2gis.com/widget?type=firmsonmap&options=%7B%22pos%22%3A%7B%22lat%22%3A43.243045691901514%2C%22lon%22%3A76.93461656570436%2C%22zoom%22%3A16%7D%2C%22opt%22%3A%7B%22city%22%3A%22almaty%22%7D%2C%22org%22%3A%2270000001025801936%22%7D">
            </iframe>
        </div>
    </div>

    <div class="flex flex-col xl:flex-row mb-4 bg-white shadow-md select-none">
        <div class="flex flex-col lg:flex-row w-full">
            <div class="p-4">
                <p class="text-xl sm:text-2xl text-green-light font-medium">Филиал на Жамбыла</p>
                <p class="text-gray-500 text-sm sm:text-base">ул. Жамбыла 211, 1 этаж</p>
                <p class="mt-4 mb-1 text-gray-500 font-medium">График работы:</p>
                <p class="text-gray-500">
                    пн, пт, вс: 9.00-23.00;<br>
                    вт, ср, чт, сб: 9.00-19.30
                </p>
                <p class="mt-4 mb-1 text-gray-500 font-medium">Телефон:</p>
                <a href="tel:+77750300909" class="text-gray-500">+7 (775) 030 09 09</a>
            </div>
            <div class="flex lg:justify-center lg:items-center lg:mx-auto">
                <div class="grid grid-cols-1 grid-rows-4 sm:grid-cols-2 sm:grid-rows-2 gap-2 mx-4 lg:mx-0 w-full lg:w-auto">
                    <a href="{{ route('patient-visits-create', ['dest' => 'c4']) }}"
                       class="flex items-center justify-center px-4 py-2 border border-gray-500 text-gray-500 text-sm rounded-md transition duration-300 ease select-none hover:bg-gray-500 hover:border-gray-500 hover:text-white focus:outline-none focus:ring-4 focus:ring-gray-500 focus:ring-opacity-50">
                        <svg class="w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M8 7V3m8 4V3m-9 8h10M5
                                  21h14a2 2 0 002-2V7a2 2 0
                                  00-2-2H5a2 2 0 00-2 2v12a2
                                  2 0 002 2z"/>
                        </svg>
                        Записаться на приём
                    </a>

                    <a href="https://2gis.kz/almaty/firm/70000001033212622?m=76.896207%2C43.245406%2F16&utm_source=bigMap&utm_medium=widget-source&utm_campaign=firmsonmap"
                       target="_blank"
                       class="flex items-center justify-center px-4 py-2 border border-gray-500 text-gray-500 text-sm rounded-md transition duration-300 ease select-none hover:bg-gray-500 hover:border-gray-500 hover:text-white focus:outline-none focus:ring-4 focus:ring-gray-500 focus:ring-opacity-50">
                        <svg class="w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1
                              0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553
                              2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                        </svg>
                        Показать на карте
                    </a>

                    <a href="https://2gis.kz/almaty/directions/tab/bus/points/%7C76.896205%2C43.24482?m=76.896205%2C43.24482%2F16&utm_source=route&utm_medium=widget-source&utm_campaign=firmsonmap"
                       target="_blank"
                       class="flex items-center justify-center px-4 py-2 border border-gray-500 text-gray-500 text-sm rounded-md transition duration-300 ease select-none hover:bg-gray-500 hover:border-gray-500 hover:text-white focus:outline-none focus:ring-4 focus:ring-gray-500 focus:ring-opacity-50">
                        <svg class="w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M17.657 16.657L13.414 20.9a1.998 1.998
                              0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Проложить маршрут
                    </a>
                </div>
            </div>
        </div>
        <div class="mt-6 xl:mt-0 min-w-80 w-full h-60 xl:w-80 xl:h-80 map-container overflow-hidden">
            <iframe style="border: none; box-sizing: border-box;"
                    src="https://widgets.2gis.com/widget?type=firmsonmap&options=%7B%22pos%22%3A%7B%22lat%22%3A43.245405916588005%2C%22lon%22%3A76.8962073326111%2C%22zoom%22%3A16%7D%2C%22opt%22%3A%7B%22city%22%3A%22almaty%22%7D%2C%22org%22%3A%2270000001033212622%22%7D">
            </iframe>
        </div>
    </div>
@endsection
