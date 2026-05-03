@extends('layouts.livewire')

@section('content')
<div class="min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8 bg-gray-50/50">
    <div class="sm:mx-auto sm:w-full sm:max-w-md select-none">
        <h2 class="mt-6 text-center text-4xl font-extrabold text-gray-900 tracking-tight">
            {{ __('Iniciar Sesión') }}
        </h2>
        <p class="text-center text-sm text-gray-500 mt-2">{{ __('Accede a tu cuenta de la academia profesional') }}</p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-10 px-6 shadow-xl border border-gray-100 rounded-3xl sm:px-12 relative overflow-hidden">
            <div class="absolute -top-10 -right-10 h-32 w-32 bg-indigo-50/60 rounded-full blur-2xl pointer-events-none select-none"></div>

            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-xl shadow-sm">
                    <h3 class="text-sm font-extrabold text-red-800">{{ __('Hay problemas con tu acceso:') }}</h3>
                    <ul class="mt-1 text-sm text-red-700 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="space-y-6" action="{{ route('login') }}" method="POST">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-extrabold text-gray-700 select-none">
                        {{ __('Correo electrónico') }}
                    </label>
                    <div class="mt-2">
                        <x-ui.input id="email" name="email" type="email" autocomplete="email" required autofocus class="rounded-xl border-gray-200" placeholder="correo@ejemplo.com" />
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-extrabold text-gray-700 select-none">
                        {{ __('Contraseña') }}
                    </label>
                    <div class="mt-2">
                        <x-ui.input id="password" name="password" type="password" autocomplete="current-password" required class="rounded-xl border-gray-200" placeholder="••••••••" />
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center select-none">
                        <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-sm font-bold text-gray-700">
                            {{ __('Recordarme') }}
                        </label>
                    </div>

                    <div class="text-sm">
                        <a href="{{ route('password.request') }}" class="font-bold text-indigo-600 hover:text-indigo-500 select-none">
                            {{ __('¿Olvidaste tu contraseña?') }}
                        </a>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full flex justify-center py-4 px-4 border border-transparent rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-0.5 text-base font-black text-white bg-indigo-600 hover:bg-indigo-700 transition-all duration-200 tracking-wide select-none">
                        {{ __('Entrar en mi cuenta') }}
                    </button>
                </div>
            </form>

            <div class="mt-8 border-t border-gray-100 pt-6">
                <p class="text-center text-sm text-gray-500 select-none">
                    {{ __('¿No tienes cuenta?') }} <a href="{{ route('register') }}" class="font-extrabold text-indigo-600 hover:text-indigo-500">{{ __('Regístrate gratis') }}</a>
                </p>
            </div>

            <!-- Botones temporales para login de desarrollo -->
            @if(app()->environment('local'))
            <div class="mt-8 pt-6 border-t border-gray-100 select-none">
                <h3 class="text-xs font-black text-gray-400 mb-4 text-center uppercase tracking-wider">{{ __('Acceso Rápido (Desarrollo)') }}</h3>
                <div class="flex flex-col gap-3">
                    <a href="/dev/login/admin" class="w-full flex justify-center px-4 py-3 bg-gray-900 text-white text-sm font-extrabold rounded-xl hover:bg-gray-800 transition-colors shadow-sm">{{ __('Entrar como Administrador') }}</a>
                    <a href="/dev/login/teacher" class="w-full flex justify-center px-4 py-3 bg-indigo-50 text-indigo-700 text-sm font-extrabold rounded-xl hover:bg-indigo-100 transition-colors">{{ __('Entrar como Profesor') }}</a>
                    <a href="/dev/login/student" class="w-full flex justify-center px-4 py-3 bg-green-50 text-green-700 text-sm font-extrabold rounded-xl hover:bg-green-100 transition-colors">{{ __('Entrar como Alumno') }}</a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
