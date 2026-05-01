<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-indigo-500">
        <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wide">Total Cursos</h3>
        <p class="mt-2 text-3xl font-bold text-gray-900">{{ $stats['total_courses'] }}</p>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
        <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wide">Cursos Publicados</h3>
        <p class="mt-2 text-3xl font-bold text-gray-900">{{ $stats['published_courses'] }}</p>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500">
        <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wide">Total Estudiantes</h3>
        <p class="mt-2 text-3xl font-bold text-gray-900">{{ $stats['total_students'] }}</p>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
        <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wide">Matrículas Activas</h3>
        <p class="mt-2 text-3xl font-bold text-gray-900">{{ $stats['active_enrollments'] }}</p>
    </div>
</div>
