@extends('layouts.main')

@section('title', 'Cabinet | Кабинет пользователя')

@section('content')
    <div class="mb-4 pt-4 bg-white shadow-md select-none">
        <p class="mx-4 text-xl sm:text-2xl text-gray-400">Ваша медицинская карта</p>
        <hr class="mt-4" />
        <div class="illnesses-container flex flex-col">
            @forelse($illnesses as $illness)
                <div class="illness-item flex flex-col sm:flex-row sm:items-center p-4 even:bg-gray-50">
                    <div class="flex flex-col mr-auto">
                        <p class="mb-2 text-lg sm:text-xl text-green-light font-medium">{{ $illness->title }}</p>
                        <div class="flex mb-1 text-sm sm:text-base">
                            <span class="flex items-center items-center font-medium text-gray-400">
                                <svg class="w-5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M9 12l2 2 4-4m5.618-4.016A11.955
                                          11.955 0 0112 2.944a11.955 11.955 0
                                          01-8.618 3.04A12.02 12.02 0 003 9c0
                                          5.591 3.824 10.29 9 11.622 5.176-1.332
                                          9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                Статус:&numsp;&numsp;
                            </span>
                            <span class="text-gray-500">{{ $illness->status->name }}</span>
                        </div>
                    </div>
                    <a href="{{ route('patient-visits', ['illness' => $illness->id]) }}"
                       class="flex items-center justify-center mt-4 sm:mt-0 px-4 py-2 border border-gray-500 text-gray-500 text-sm rounded-md transition duration-300 ease select-none hover:bg-gray-500 hover:border-gray-500 hover:text-white focus:outline-none focus:ring-4 focus:ring-gray-500 focus:ring-opacity-50">
                        <svg class="mr-2 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M12 4.354a4 4 0 110
                              5.292M15 21H3v-1a6 6
                              0 0112 0v1zm0 0h6v-1a6
                              6 0 00-9-5.197M13 7a4 4
                              0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Перейти к визитам
                    </a>
                </div>
            @empty
                <i class="mx-4 text-gray-400 my-4">Ваша карта пуста</i>
            @endforelse
        </div>
    </div>
@endsection
