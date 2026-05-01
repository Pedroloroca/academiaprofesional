<div class="flex flex-col lg:flex-row min-h-screen bg-gray-50/50">
    <!-- Modern Sidebar -->
    <div class="w-full lg:w-80 bg-white border-b lg:border-b-0 lg:border-r border-gray-100 flex flex-col justify-between flex-shrink-0 select-none">
        <div>
            <!-- Course header inside sidebar -->
            <div class="p-6 bg-gradient-to-tr from-indigo-600 via-indigo-700 to-violet-700 text-white shadow-sm flex flex-col justify-between h-36">
                <span class="bg-white/20 backdrop-blur-sm text-white text-[10px] px-2 py-0.5 rounded font-bold uppercase tracking-wider self-start select-none">Progreso del curso</span>
                <h2 class="text-lg md:text-xl font-black leading-tight tracking-tight mt-auto">{{ $course->title }}</h2>
            </div>

            <!-- Lessons list -->
            <ul class="divide-y divide-gray-50">
                @forelse($course->lessons as $index => $lesson)
                <li>
                    <button wire:click="selectLesson({{ $lesson->id }})" 
                            class="w-full text-left px-6 py-4 hover:bg-indigo-50/40 border-l-4 transition-all duration-200 flex items-center justify-between {{ $activeLesson && $activeLesson->id === $lesson->id ? 'border-indigo-600 bg-indigo-50/50 text-indigo-800 font-extrabold' : 'border-transparent text-gray-700 hover:text-gray-900' }}">
                        <div class="flex items-center gap-3">
                            <span class="text-xs font-black text-indigo-500/70 select-none">0{{ $index + 1 }}</span>
                            <span class="text-sm tracking-wide">{{ $lesson->title }}</span>
                        </div>
                        <span class="text-gray-300 text-sm">▶</span>
                    </button>
                </li>
                @empty
                <li class="px-6 py-4 text-gray-500 text-sm">No hay lecciones disponibles.</li>
                @endforelse
            </ul>
        </div>

        <div class="p-6 border-t border-gray-50 bg-gray-50/40 mt-auto">
            <a href="/catalogo" class="flex items-center gap-2 text-indigo-600 hover:text-indigo-800 font-extrabold text-xs select-none uppercase tracking-wider transition-colors">
                &larr; Volver al catálogo
            </a>
        </div>
    </div>

    <!-- Main Content Panel -->
    <div class="flex-1 p-6 md:p-12 lg:p-16">
        @if($activeLesson)
        <div class="bg-white rounded-3xl border border-gray-100 shadow-xl p-6 md:p-12 relative overflow-hidden">
            <div class="absolute -top-12 -right-12 h-40 w-40 bg-indigo-50/40 rounded-full blur-2xl pointer-events-none select-none"></div>
            
            <span class="bg-indigo-50 text-indigo-700 text-xs px-3 py-1 rounded-full font-bold uppercase tracking-wider">Lección Actual</span>
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mt-4 mb-6 tracking-tight leading-snug">{{ $activeLesson->title }}</h1>
            
            <!-- Dynamic Content -->
            <div class="prose max-w-none text-gray-700 mb-8 leading-relaxed">
                {!! nl2br(e($activeLesson->content)) !!}
            </div>

            <!-- Messages -->
            @if (session()->has('message'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-xl shadow-sm flex justify-between items-center animate-fade-in">
                    <p class="text-sm font-bold text-green-800">✔ {{ session('message') }}</p>
                    <button class="text-green-600 hover:text-green-800 font-bold" onclick="this.parentElement.remove()">✕</button>
                </div>
            @endif

            <!-- Footer Action Area -->
            <div class="border-t border-gray-50 pt-6 mt-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <button wire:click="completeLesson({{ $activeLesson->id }})" class="bg-indigo-600 hover:bg-indigo-700 text-white font-black px-6 py-3 rounded-2xl shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-200 tracking-wide select-none">
                    ✔ Marcar como Completada
                </button>
                <p class="text-xs text-gray-400 font-medium select-none">Registra tu avance para desbloquear certificados.</p>
            </div>
        </div>
        @else
        <div class="bg-white rounded-3xl border border-gray-100 shadow-xl p-12 text-center flex flex-col items-center justify-center min-h-[400px]">
            <span class="text-6xl mb-4 select-none">📂</span>
            <p class="text-gray-500 text-xl font-extrabold mb-1">Selecciona una lección para comenzar</p>
            <p class="text-gray-400 text-sm">Escoge cualquier tema de la barra lateral izquierda.</p>
        </div>
        @endif
    </div>
</div>
