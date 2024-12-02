<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Instagrato') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <nav class="bg-white border-b">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="{{ route('home') }}" class="text-xl font-bold text-gray-900">
                            Instagrato
                        </a>
                    </div>
                </div>

                @auth
                    <div class="flex items-center space-x-4">
                        <form action="{{ route('search') }}" method="GET" class="hidden md:block">
                            <input type="text" name="q" placeholder="Search..." 
                                class="w-64 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500">
                        </form>
                        
                        <a href="{{ route('posts.create') }}" class="p-2 text-gray-600 hover:text-gray-900">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                        </a>
                        
                        <a href="{{ route('profile.show', auth()->user()) }}" class="flex items-center">
                            <img src="{{ auth()->user()->profile_photo 
                                ? Storage::url(auth()->user()->profile_photo) 
                                : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}" 
                                alt="{{ auth()->user()->name }}" 
                                class="h-8 w-8 rounded-full object-cover">
                        </a>
                    </div>
                @else
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900">Login</a>
                        <a href="{{ route('register') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                            Register
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    <main class="py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            @yield('content')
        </div>
    </main>
</body>
</html>