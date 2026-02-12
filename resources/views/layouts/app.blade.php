<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-gray-100">
    <div id="app">
        <nav class="bg-white shadow-sm" x-data="{ open: false }">
            <div class="container mx-auto px-4">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="shrink-0 flex items-center">
                            <a class="text-xl font-bold text-gray-800 no-underline hover:text-gray-700" href="{{ url('/') }}">
                                {{ config('app.name', 'Laravel') }}
                            </a>
                        </div>

                        <div class="hidden md:flex md:items-center md:ms-6">
                            </div>
                    </div>

                    <div class="hidden md:flex md:items-center md:ms-6">
                        <div class="flex items-center space-x-4">
                            @guest
                                @if (Route::has('login'))
                                    <a class="text-gray-500 hover:text-gray-700 focus:outline-none transition ease-in-out duration-150" href="{{ route('login') }}">{{ __('Login') }}</a>
                                @endif

                                @if (Route::has('register'))
                                    <a class="text-gray-500 hover:text-gray-700 focus:outline-none transition ease-in-out duration-150" href="{{ route('register') }}">{{ __('Register') }}</a>
                                @endif
                            @else
                                @if (Route::has('home'))
                                    <a class="text-gray-500 hover:text-gray-700 focus:outline-none transition ease-in-out duration-150" href="{{ route('home') }}">{{ __('My Friends') }}</a>
                                @endif

                                @if (Route::has('friend-requests.index'))
                                    <a class="text-gray-500 hover:text-gray-700 focus:outline-none transition ease-in-out duration-150" href="{{ route('friend-requests.index') }}">{{ __('Request List') }}</a>
                                @endif

                                @if (Route::has('users.search'))
                                    <a class="text-gray-500 hover:text-gray-700 focus:outline-none transition ease-in-out duration-150" href="{{ route('users.search') }}">{{ __('Find Friends') }}</a>
                                @endif
                                <div class="relative" x-data="{ dropdownOpen: false }">
                                    <button @click="dropdownOpen = ! dropdownOpen" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                        <div>{{ Auth::user()->name }}</div>

                                        <div class="ms-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>

                                    <div x-show="dropdownOpen" 
                                         @click.away="dropdownOpen = false"
                                         style="display: none;"
                                         class="absolute right-0 z-50 mt-2 w-48 rounded-md shadow-lg origin-top-right bg-white ring-1 ring-black ring-opacity-5 py-1">
                                        
                                        <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            @endguest
                        </div>
                    </div>

                    <div class="-me-2 flex items-center md:hidden">
                        <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div :class="{'block': open, 'hidden': ! open}" class="hidden md:hidden">
                <div class="pt-2 pb-3 space-y-1">
                    </div>

                <div class="pt-4 pb-1 border-t border-gray-200">
                    @guest
                        <div class="mt-3 space-y-1">
                            @if (Route::has('login'))
                                <a href="{{ route('login') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                                    {{ __('Login') }}
                                </a>
                            @endif
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                                    {{ __('Register') }}
                                </a>
                            @endif
                        </div>
                    @else
                        <div class="px-4">
                            <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                            </div>

                        <div class="mt-3 space-y-1">
                            <a class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                        </div>
                    @endguest
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    {{-- Alerts --}}
    @include('partials.alerts')

</body>
</html>