<div class="flex flex-col lg:flex-row min-h-screen bg-gray-50/50">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.js"></script>
    
    <!-- Sidebar -->
    <div class="w-full lg:w-80 bg-white border-b lg:border-b-0 lg:border-r border-gray-100 flex flex-col justify-between flex-shrink-0 select-none">
        <div>
            <!-- Course header inside sidebar -->
            <div class="p-6 bg-gradient-to-tr from-indigo-600 via-indigo-700 to-violet-700 text-white shadow-sm flex flex-col justify-between h-36">
                @if($isTeacherOrAdmin)
                <span class="bg-white/20 backdrop-blur-sm text-white text-[10px] px-2 py-0.5 rounded font-bold uppercase tracking-wider self-start select-none">Gestión del Curso</span>
                @else
                <span class="bg-white/20 backdrop-blur-sm text-white text-[10px] px-2 py-0.5 rounded font-bold uppercase tracking-wider self-start select-none">Progreso del curso</span>
                @endif
                <h2 class="text-lg md:text-xl font-black leading-tight tracking-tight mt-auto">{{ $course->title }}</h2>
            </div>

            <!-- Toggle Edit/Preview Mode Bar for Teachers -->
            @if($isTeacherOrAdmin)
            <div class="p-4 bg-indigo-50/60 border-b border-indigo-100 flex flex-col gap-2">
                <button wire:click="toggleEditMode" class="w-full inline-flex items-center justify-center gap-2 {{ $editMode ? 'bg-amber-500 hover:bg-amber-600' : 'bg-indigo-600 hover:bg-indigo-700' }} text-white font-extrabold px-4 py-2.5 rounded-xl shadow-sm text-sm transition-all">
                    @if($editMode)
                        <span>👁</span> Activar Vista Previa
                    @else
                        <span>✏</span> Activar Modo Edición
                    @endif
                </button>
                <p class="text-[10px] text-gray-500 font-medium text-center">
                    @if($editMode)
                        Modo Edición: cambia los contenidos en tiempo real.
                    @else
                        Modo Vista Previa: experimenta el curso como un alumno.
                    @endif
                </p>
            </div>
            @endif

            <!-- Lessons list -->
            <ul class="divide-y divide-gray-50">
                @forelse($course->lessons as $index => $lesson)
                <li class="flex items-center justify-between hover:bg-indigo-50/40 pr-4 transition-all duration-200">
                    <button wire:click="selectLesson({{ $lesson->id }})" 
                            class="w-full text-left px-6 py-4 border-l-4 transition-all duration-200 flex items-center justify-between {{ $activeLesson && $activeLesson->id === $lesson->id ? 'border-indigo-600 bg-indigo-50/50 text-indigo-800 font-extrabold' : 'border-transparent text-gray-700 hover:text-gray-900' }}">
                        <div class="flex items-center gap-3">
                            <span class="text-xs font-black text-indigo-500/70 select-none">0{{ $index + 1 }}</span>
                            <span class="text-sm tracking-wide">{{ $lesson->title }}</span>
                        </div>
                        <span class="text-gray-300 text-sm">▶</span>
                    </button>
                    @if($isTeacherOrAdmin && $editMode)
                    <button wire:click="deleteLesson({{ $lesson->id }})" onclick="confirm('¿Estás seguro de eliminar esta lección?') || event.stopImmediatePropagation()" class="text-red-400 hover:text-red-600 font-bold text-sm px-2 select-none">
                        🗑
                    </button>
                    @endif
                </li>
                @empty
                <li class="px-6 py-4 text-gray-500 text-sm">No hay lecciones disponibles.</li>
                @endforelse
            </ul>

            <!-- Add Lesson for Teachers (Mode Edition) -->
            @if($isTeacherOrAdmin && $editMode)
            <div class="p-6 border-t border-gray-100 bg-indigo-50/20" wire:ignore>
                <h4 class="text-xs font-black text-indigo-900 uppercase tracking-wider mb-3">➕ Nueva Lección</h4>
                <form x-data @submit.prevent="$wire.set('new_lesson_content', document.getElementById('new-lesson-content-input').value); $wire.addLesson()" class="space-y-3">
                    <div>
                        <input type="text" wire:model="new_lesson_title" id="new-lesson-title" placeholder="Título de la lección" class="w-full text-xs rounded-xl border-gray-200 p-2.5 bg-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" />
                        @error('new_lesson_title') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <input id="new-lesson-content-input" type="hidden" value="{{ $new_lesson_content }}">
                        <trix-editor input="new-lesson-content-input" class="bg-white border border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm mt-1 p-2 min-h-[80px] overflow-y-auto leading-relaxed text-xs"></trix-editor>
                        @error('new_lesson_content') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                    </div>
                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-black text-xs px-4 py-2.5 rounded-xl shadow-sm transition-all duration-200 tracking-wide select-none">
                        Guardar Lección
                    </button>
                </form>
            </div>
            @endif
        </div>

        <div class="p-6 border-t border-gray-50 bg-gray-50/40 mt-auto">
            <a href="/catalogo" class="flex items-center gap-2 text-indigo-600 hover:text-indigo-800 font-extrabold text-xs select-none uppercase tracking-wider transition-colors">
                &larr; Volver al catálogo
            </a>
        </div>
    </div>

    <!-- Main Content Panel -->
    <div class="flex-1 p-6 md:p-12 lg:p-16">
        
        <!-- COURSE EDITING (For teachers in Edit Mode) -->
        @if($isTeacherOrAdmin && $editMode)
        <div class="bg-white rounded-3xl border border-gray-100 shadow-xl p-6 md:p-12 mb-8 relative overflow-hidden" wire:ignore>
            <span class="bg-amber-50 text-amber-700 text-xs px-3 py-1 rounded-full font-bold uppercase tracking-wider">Gestión de Detalles del Curso</span>
            
            @if (session()->has('course_message'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-xl shadow-sm my-4 flex justify-between items-center select-none animate-fade-in">
                    <p class="text-sm font-bold text-green-800">✔ {{ session('course_message') }}</p>
                    <button class="text-green-600 hover:text-green-800 font-bold" onclick="this.parentElement.remove()">✕</button>
                </div>
            @endif

            <form x-data @submit.prevent="$wire.set('courseExplanation', document.getElementById('courseExplanation-input').value); $wire.updateCourse()" class="space-y-5 mt-6">
                <div>
                    <label class="text-sm font-extrabold text-gray-700 select-none">Título del Curso</label>
                    <input type="text" wire:model="courseTitle" class="mt-1 block w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500" />
                    @error('courseTitle') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="text-sm font-extrabold text-gray-700 select-none">Descripción del Curso</label>
                    <textarea wire:model="courseDescription" rows="3" class="mt-1 block w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                    @error('courseDescription') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="text-sm font-extrabold text-gray-700 select-none">Explicación General del Tema</label>
                    <input id="courseExplanation-input" type="hidden" value="{{ $courseExplanation }}">
                    <trix-editor input="courseExplanation-input" class="bg-white border border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm mt-1 p-3 min-h-[120px] overflow-y-auto leading-relaxed text-sm select-text"></trix-editor>
                    @error('courseExplanation') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="text-sm font-extrabold text-gray-700 select-none">Vídeo Explicativo del Tema (YouTube URL o mp4)</label>
                    <input type="text" wire:model="courseVideoUrl" class="mt-1 block w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500" placeholder="Ej: https://www.youtube.com/embed/..." />
                    @error('courseVideoUrl') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="pt-2">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold px-6 py-3 rounded-2xl shadow-md hover:shadow-lg transition-all duration-200">
                        💾 Actualizar Detalles del Curso
                    </button>
                </div>
            </form>
        </div>
        @else
        <!-- General Course Explanation & Video (Student or preview view) -->
        @if($course->explanation || $course->video_url)
        <div class="bg-white rounded-3xl border border-gray-100 shadow-xl p-6 md:p-12 mb-8 relative overflow-hidden">
            @if($course->explanation)
            <span class="bg-purple-50 text-purple-700 text-xs px-3 py-1 rounded-full font-bold uppercase tracking-wider">Explicación del Tema</span>
            <div class="prose max-w-none text-gray-800 my-6 leading-relaxed">
                {!! $course->explanation !!}
            </div>
            @endif

            @if($course->video_url)
            <div class="mt-6">
                <span class="bg-indigo-50 text-indigo-700 text-xs px-3 py-1 rounded-full font-bold uppercase tracking-wider">Vídeo Explicativo</span>
                <div class="aspect-video mt-4 rounded-2xl overflow-hidden border border-gray-100 shadow-sm">
                    @if(str_contains($course->video_url, 'youtube.com') || str_contains($course->video_url, 'youtu.be'))
                        @php
                            $videoId = '';
                            if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $course->video_url, $matches)) {
                                $videoId = $matches[1];
                            }
                        @endphp
                        @if($videoId)
                            <iframe class="w-full h-full" src="https://www.youtube.com/embed/{{ $videoId }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                        @else
                            <iframe class="w-full h-full" src="{{ $course->video_url }}" frameborder="0" allowfullscreen></iframe>
                        @endif
                    @else
                        <video controls class="w-full h-full object-cover">
                            <source src="{{ $course->video_url }}" type="video/mp4">
                            Tu navegador no soporta el formato de vídeo.
                        </video>
                    @endif
                </div>
            </div>
            @endif
        </div>
        @endif
        @endif

        <!-- LESSON SECTION -->
        @if($activeLesson)
        <div class="bg-white rounded-3xl border border-gray-100 shadow-xl p-6 md:p-12 relative overflow-hidden">
            <div class="absolute -top-12 -right-12 h-40 w-40 bg-indigo-50/40 rounded-full blur-2xl pointer-events-none select-none"></div>
            
            <span class="bg-indigo-50 text-indigo-700 text-xs px-3 py-1 rounded-full font-bold uppercase tracking-wider">Lección Actual</span>
            
            <!-- Messages -->
            @if (session()->has('lesson_message'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-xl shadow-sm my-4 flex justify-between items-center select-none animate-fade-in">
                    <p class="text-sm font-bold text-green-800">✔ {{ session('lesson_message') }}</p>
                    <button class="text-green-600 hover:text-green-800 font-bold" onclick="this.parentElement.remove()">✕</button>
                </div>
            @endif

            @if($isTeacherOrAdmin && $editMode)
            <!-- Edit active lesson fields -->
            <form x-data @submit.prevent="$wire.set('active_lesson_content', document.getElementById('active_lesson_content-input').value); $wire.updateLesson()" class="mt-6 space-y-4" wire:ignore>
                <div>
                    <label class="text-sm font-extrabold text-gray-700 select-none">Título de la Lección</label>
                    <input type="text" wire:model="active_lesson_title" class="mt-1 block w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500" />
                    @error('active_lesson_title') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="text-sm font-extrabold text-gray-700 select-none">Contenido de la Lección</label>
                    <input id="active_lesson_content-input" type="hidden" value="{{ $active_lesson_content }}">
                    <trix-editor input="active_lesson_content-input" class="bg-white border border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm mt-1 p-3 min-h-[150px] overflow-y-auto leading-relaxed text-sm select-text"></trix-editor>
                    @error('active_lesson_content') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="flex items-center gap-2 select-none">
                    <input type="checkbox" wire:model="active_lesson_is_published" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" id="active_lesson_is_published" />
                    <label for="active_lesson_is_published" class="text-sm font-bold text-gray-700">Marcar como publicada</label>
                </div>

                <div class="pt-2">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold px-6 py-3 rounded-2xl shadow-md hover:shadow-lg transition-all duration-200">
                        💾 Guardar Cambios en la Lección
                    </button>
                </div>
            </form>
            @else
            <!-- Standard dynamic Content viewer -->
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mt-4 mb-6 tracking-tight leading-snug">{{ $activeLesson->title }}</h1>
            
            <div class="prose max-w-none text-gray-700 mb-8 leading-relaxed">
                {!! $activeLesson->content !!}
            </div>

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
            @endif
        </div>
        @else
        <div class="bg-white rounded-3xl border border-gray-100 shadow-xl p-12 text-center flex flex-col items-center justify-center min-h-[400px]">
            <span class="text-6xl mb-4 select-none">📂</span>
            <p class="text-gray-500 text-xl font-extrabold mb-1">Selecciona una lección para comenzar</p>
            <p class="text-gray-400 text-sm">Escoge cualquier tema de la barra lateral izquierda.</p>
        </div>
        @endif
    </div>

    <!-- Trix Livewire Integration script -->
    <script>
        document.addEventListener('trix-change', function(e) {
            let inputId = e.target.getAttribute('input');
            let wireModel = null;
            if (inputId === 'courseExplanation-input') {
                wireModel = 'courseExplanation';
            } else if (inputId === 'active_lesson_content-input') {
                wireModel = 'active_lesson_content';
            } else if (inputId === 'new-lesson-content-input') {
                wireModel = 'new_lesson_content';
            }
            
            if (wireModel) {
                let hiddenInput = document.getElementById(inputId);
                let val = hiddenInput ? hiddenInput.value : '';
                let wireId = e.target.closest('[wire:id]').getAttribute('wire:id');
                if (window.Livewire) {
                    window.Livewire.find(wireId).set(wireModel, val);
                }
            }
        });
    </script>
</div>
