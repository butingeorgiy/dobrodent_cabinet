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
    <title>Cabinet | Добро пожаловать</title>
</head>
<body class="bg-gray-100 h-screen flex flex-col justify-center items-center overflow-hidden select-none px-10">
    <h1 class="mb-10 text-4xl font-light text-center">Добро пожаловать в
        <span class="text-green-light font-semibold">Dobro</span><span class="text-gray-400 font-semibold"> Dent!</span>
    </h1>
    <p class="mb-3 text-gray-500 font-light text-center">Войти в систему как:</p>
    <div class="flex flex-col sm:flex-row">
        <a href="{{ route('patient-index') }}" class="flex justify-center w-full mb-3 sm:mb-0 text-white bg-gray-400 hover:bg-gray-500 rounded-md text-sm px-5 py-2">
            <svg class="w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M5.121 17.804A13.937
                      13.937 0 0112 16c2.5 0
                      4.847.655 6.879 1.804M15
                      10a3 3 0 11-6 0 3 3 0 016
                      0zm6 2a9 9 0 11-18 0 9 9 0
                      0118 0z" />
            </svg>
            Пациент
        </a>

        <a href="{{ route('doctor-index') }}" class="flex justify-center w-full mb-3 sm:mb-0 sm:mx-5 text-white bg-gray-400 hover:bg-gray-500 rounded-md text-sm px-5 py-2">
            <svg class="w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M9 5H7a2 2 0 00-2
                      2v12a2 2 0 002 2h10a2
                      2 0 002-2V7a2 2 0
                      00-2-2h-2M9 5a2 2 0 002
                      2h2a2 2 0 002-2M9 5a2 2
                      0 012-2h2a2 2 0 012 2m-3
                      7h3m-3 4h3m-6-4h.01M9 16h.01" />
            </svg>
            Доктор
        </a>

        <a href="{{ route('administrator-index') }}" class="flex justify-center w-full text-white bg-gray-400 hover:bg-gray-500 rounded-md text-sm px-5 py-2">
            <svg class="w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M16 8v8m-4-5v5m-4-2v2m-2
                      4h12a2 2 0 002-2V6a2 2 0
                      00-2-2H6a2 2 0 00-2 2v12a2
                      2 0 002 2z" />
            </svg>
            Администратор
        </a>
    </div>
</body>
</html>
