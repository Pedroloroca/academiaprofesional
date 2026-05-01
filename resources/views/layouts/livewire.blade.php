<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Academia Profesional') }} - @yield('title', 'Admin')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @vite(['resources/js/app.ts'])
    @livewireStyles
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900">
    <div class="min-h-screen">
        <nav class="bg-white border-b border-gray-200 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="shrink-0 flex items-center">
                            <a href="/" class="text-2xl font-black text-indigo-700 tracking-tighter">Academia</a>
                        </div>
                        <div class="hidden sm:-my-px sm:ml-8 sm:flex sm:space-x-8">
                            <a href="/" class="border-transparent text-gray-600 hover:text-indigo-700 hover:border-indigo-300 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Inicio</a>
                            <a href="/catalogo" class="border-transparent text-gray-600 hover:text-indigo-700 hover:border-indigo-300 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Catálogo</a>
                            <a href="/profesores" class="border-transparent text-gray-600 hover:text-indigo-700 hover:border-indigo-300 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Profesores</a>
                            
                            @auth
                            <a href="/admin/courses" class="border-transparent text-gray-600 hover:text-indigo-700 hover:border-indigo-300 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Mis Cursos</a>
                            @hasrole('admin|manager')
                            <a href="/admin/students" class="border-transparent text-gray-600 hover:text-indigo-700 hover:border-indigo-300 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Estudiantes</a>
                            @endhasrole
                            @endauth
                        </div>
                    </div>
                    <div class="hidden sm:flex sm:items-center sm:ml-6 space-x-4">
                        @auth
                            <span class="text-sm text-gray-500 font-medium">Hola, {{ auth()->user()->name }}</span>
                            <a href="/dashboard" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">Panel</a>
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf
                                <button type="submit" class="text-sm font-medium text-gray-500 hover:text-gray-700">Salir</button>
                            </form>
                        @else
                            <a href="/login" class="text-sm font-medium text-gray-500 hover:text-gray-700">Iniciar Sesión</a>
                            <a href="/register" class="text-sm font-medium bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Registrarse</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <main class="py-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                @yield('content', $slot ?? '')
            </div>
        </main>
    </div>

    @livewireScripts
</body>
</html>
