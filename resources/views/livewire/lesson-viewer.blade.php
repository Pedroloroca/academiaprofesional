<div class="flex flex-col md:flex-row min-h-screen bg-gray-100">
    <!-- Sidebar -->
    <div class="w-full md:w-64 bg-white shadow-md">
        <div class="p-4 bg-indigo-700 text-white">
            <h2 class="text-xl font-bold">{{ $course->title }}</h2>
        </div>
        <ul class="py-2">
            @forelse($course->lessons as $lesson)
            <li>
                <button wire:click="selectLesson({{ $lesson->id }})" 
                        class="w-full text-left px-4 py-3 hover:bg-indigo-50 border-l-4 transition-colors {{ $activeLesson && $activeLesson->id === $lesson->id ? 'border-indigo-600 bg-indigo-50 text-indigo-700 font-medium' : 'border-transparent text-gray-700' }}">
                    {{ $lesson->title }}
                </button>
            </li>
            @empty
            <li class="px-4 py-3 text-gray-500">No hay lecciones disponibles.</li>
            @endforelse
        </ul>
        <div class="p-4 border-t mt-auto">
            <a href="/catalogo" class="text-indigo-600 hover:text-indigo-800 text-sm">&larr; Volver al catálogo</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 p-8">
        @if($activeLesson)
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-6">{{ $activeLesson->title }}</h1>
            <div class="prose max-w-none text-gray-700">
                {!! nl2br(e($activeLesson->content)) !!}
            </div>
        </div>
        @else
        <div class="bg-white rounded-lg shadow-lg p-8 text-center">
            <p class="text-gray-500 text-lg">Seleccione una lección del menú para comenzar.</p>
        </div>
        @endif
    </div>
</div>
