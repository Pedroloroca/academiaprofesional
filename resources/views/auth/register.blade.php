@extends('layouts.livewire')

@section('content')
<div class="min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8 bg-gray-50/50">
    <div class="sm:mx-auto sm:w-full sm:max-w-md select-none">
        <h2 class="mt-6 text-center text-4xl font-extrabold text-gray-900 tracking-tight">
            {{ __('Crear cuenta') }}
        </h2>
        <p class="text-center text-sm text-gray-500 mt-2">{{ __('Únete hoy a la academia y empieza a aprender') }}</p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-10 px-6 shadow-xl border border-gray-100 rounded-3xl sm:px-12 relative overflow-hidden">
            <div class="absolute -top-10 -right-10 h-32 w-32 bg-indigo-50/60 rounded-full blur-2xl pointer-events-none select-none"></div>

            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-xl shadow-sm">
                    <h3 class="text-sm font-extrabold text-red-800">{{ __('Error al registrarse:') }}</h3>
                    <ul class="mt-1 text-sm text-red-700 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="space-y-6" action="{{ route('register') }}" method="POST">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-extrabold text-gray-700 select-none">
                        {{ __('Nombre completo') }}
                    </label>
                    <div class="mt-2">
                        <x-ui.input id="name" name="name" type="text" autocomplete="name" required autofocus class="rounded-xl border-gray-200" placeholder="Ej: Pedro Loroca" />
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-extrabold text-gray-700 select-none">
                        {{ __('Correo electrónico') }}
                    </label>
                    <div class="mt-2">
                        <x-ui.input id="email" name="email" type="email" autocomplete="email" required class="rounded-xl border-gray-200" placeholder="correo@ejemplo.com" />
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-extrabold text-gray-700 select-none">
                        {{ __('Contraseña') }}
                    </label>
                    <div class="mt-2">
                        <x-ui.input id="password" name="password" type="password" autocomplete="new-password" required class="rounded-xl border-gray-200" placeholder="••••••••" />
                    </div>
                </div>
                
                <div>
                    <label for="password_confirmation" class="block text-sm font-extrabold text-gray-700 select-none">
                        {{ __('Confirmar contraseña') }}
                    </label>
                    <div class="mt-2">
                        <x-ui.input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required class="rounded-xl border-gray-200" placeholder="••••••••" />
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full flex justify-center py-4 px-4 border border-transparent rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-0.5 text-base font-black text-white bg-indigo-600 hover:bg-indigo-700 transition-all duration-200 tracking-wide select-none">
                        {{ __('Registrar mi cuenta') }}
                    </button>
                </div>
            </form>

            <div class="mt-8 border-t border-gray-100 pt-6">
                <p class="text-center text-sm text-gray-500 select-none">
                    {{ __('¿Ya tienes cuenta?') }} <a href="{{ route('login') }}" class="font-extrabold text-indigo-600 hover:text-indigo-500">{{ __('Inicia sesión') }}</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
