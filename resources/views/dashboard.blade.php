@extends('layouts.livewire')

@section('content')
<div class="py-12 bg-gray-50/50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Dashboard Premium Header -->
        <div class="bg-gradient-to-r from-indigo-600 via-indigo-700 to-violet-700 rounded-3xl p-8 md:p-12 mb-10 overflow-hidden shadow-xl border border-indigo-50/10 relative">
            <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(255,255,255,0.15),transparent)] pointer-events-none"></div>
            <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div>
                    <span class="bg-indigo-500/30 backdrop-blur-sm border border-indigo-400/30 text-white text-xs px-3 py-1 rounded-full font-bold uppercase tracking-wider select-none">{{ __('¡Bienvenido de nuevo!') }}</span>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-white mt-4 mb-2 tracking-tight">{{ __('Bienvenido a tu Panel de Control') }}</h2>
                    <p class="text-indigo-100 text-sm md:text-base max-w-xl leading-relaxed">{{ __('Accede de forma rápida y sencilla a todas las herramientas de la plataforma.') }}</p>
                </div>
                <div class="text-6xl select-none hidden md:block">🛡</div>
            </div>
        </div>

        <!-- Navigation Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Courses Module -->
            <div class="group bg-white rounded-2xl border border-gray-100 p-8 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between">
                <div>
                    <div class="h-12 w-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-2xl mb-5 select-none transform group-hover:scale-110 transition-all">
                        📚
                    </div>
                    <h3 class="text-xl font-extrabold text-gray-900 group-hover:text-indigo-600 transition-colors duration-200">{{ __('Mis Cursos') }}</h3>
                    <p class="mt-2 text-sm text-gray-500 leading-relaxed mb-6">{{ __('Accede a tus cursos activos, revisa los materiales y sigue avanzando hacia tus objetivos profesionales.') }}</p>
                </div>
                <div class="border-t border-gray-50 pt-4 mt-auto">
                    <a href="/admin/courses" class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-800 font-extrabold text-sm tracking-wide select-none transition-all">
                        {{ __('Explorar mis cursos') }} &nbsp; &rarr;
                    </a>
                </div>
            </div>
            
            <!-- Students Module -->
            @hasrole('admin|manager')
            <div class="group bg-white rounded-2xl border border-gray-100 p-8 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between">
                <div>
                    <div class="h-12 w-12 rounded-xl bg-violet-50 text-violet-600 flex items-center justify-center font-bold text-2xl mb-5 select-none transform group-hover:scale-110 transition-all">
                        👨‍🎓
                    </div>
                    <h3 class="text-xl font-extrabold text-gray-900 group-hover:text-violet-600 transition-colors duration-200">{{ __('Gestión de Estudiantes') }}</h3>
                    <p class="mt-2 text-sm text-gray-500 leading-relaxed mb-6">{{ __('Administra alumnos matriculados, controla inscripciones y supervisa el progreso de los estudiantes.') }}</p>
                </div>
                <div class="border-t border-gray-50 pt-4 mt-auto">
                    <a href="/admin/students" class="inline-flex items-center gap-2 text-violet-600 hover:text-violet-800 font-extrabold text-sm tracking-wide select-none transition-all">
                        {{ __('Administrar alumnos') }} &nbsp; &rarr;
                    </a>
                </div>
            </div>
            @endhasrole
        </div>
    </div>
</div>
@endsection
