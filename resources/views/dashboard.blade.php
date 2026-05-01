@extends('layouts.livewire')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-bold mb-4">Bienvenido a tu Panel de Control</h2>
                <p class="text-gray-600">¡Has iniciado sesión exitosamente!</p>
                
                <div class="mt-8 grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div class="bg-indigo-50 rounded-lg p-6">
                        <h3 class="text-lg font-medium text-indigo-900">Mis Cursos</h3>
                        <p class="mt-2 text-sm text-indigo-700">Accede al material de los cursos en los que estás matriculado o que impartes.</p>
                        <div class="mt-4">
                            <a href="/admin/courses" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">Ir a mis cursos &rarr;</a>
                        </div>
                    </div>
                    
                    @hasrole('admin|manager')
                    <div class="bg-green-50 rounded-lg p-6">
                        <h3 class="text-lg font-medium text-green-900">Estudiantes</h3>
                        <p class="mt-2 text-sm text-green-700">Gestiona los estudiantes y matrículas de la academia.</p>
                        <div class="mt-4">
                            <a href="/admin/students" class="text-sm font-medium text-green-600 hover:text-green-500">Ir a estudiantes &rarr;</a>
                        </div>
                    </div>
                    @endhasrole
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
