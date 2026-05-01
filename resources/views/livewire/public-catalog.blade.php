<div>
    <div class="mb-8 text-center">
        <h1 class="text-4xl font-extrabold text-indigo-700 mb-2">Catálogo de Cursos</h1>
        <p class="text-lg text-gray-600">Explora nuestra oferta formativa y lleva tu carrera al siguiente nivel.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($courses as $course)
        <div class="bg-white rounded-lg shadow-lg overflow-hidden border border-gray-100 transition-transform transform hover:scale-105">
            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $course->title }}</h3>
                <p class="text-gray-600 mb-4 h-20 overflow-hidden">{{ $course->description }}</p>
                <div class="flex justify-between items-center mt-4">
                    <span class="text-indigo-600 font-bold text-lg">${{ number_format($course->price, 2) }}</span>
                    <span class="text-sm text-gray-500">Por {{ $course->teacher->user->name }}</span>
                </div>
            </div>
            <div class="bg-gray-50 px-6 py-4">
                <a href="/cursos/{{ $course->slug }}/enroll" class="block w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded transition-colors">
                    Matricularse
                </a>
            </div>
        </div>
        @empty
        <div class="col-span-3 text-center py-12">
            <p class="text-gray-500 text-lg">Actualmente no hay cursos publicados.</p>
        </div>
        @endforelse
    </div>
</div>
