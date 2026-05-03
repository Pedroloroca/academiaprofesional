<div class="py-12 bg-gray-50/50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Modern Header -->
        <div class="relative bg-gradient-to-r from-indigo-600 via-indigo-700 to-violet-700 rounded-3xl p-8 md:p-12 mb-12 overflow-hidden shadow-xl border border-indigo-50/10">
            <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(255,255,255,0.15),transparent)] pointer-events-none"></div>
            <div class="relative z-10 max-w-2xl">
                <span class="bg-indigo-500/30 backdrop-blur-sm border border-indigo-400/30 text-white text-xs px-3 py-1 rounded-full font-bold uppercase tracking-wider">{{ __('Cursos de Éxito') }}</span>
                <h1 class="text-4xl md:text-5xl font-extrabold text-white mt-4 mb-3 tracking-tight">{{ __('Catalog') }} de Cursos</h1>
                <p class="text-indigo-100 text-base md:text-lg">{{ __('Explora nuestra amplia oferta formativa y lleva tus habilidades al siguiente nivel con el mejor soporte docente.') }}</p>
            </div>
        </div>

        <!-- Grid of Courses -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($courses as $course)
            <div class="group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden flex flex-col justify-between">
                <div>
                    <!-- Decorative course image placeholder/gradient -->
                    <div class="h-44 w-full bg-gradient-to-tr from-indigo-100 via-purple-50 to-pink-50 flex items-center justify-center border-b border-gray-50 group-hover:scale-[1.01] transition-transform duration-300">
                        <span class="text-5xl select-none transform group-hover:scale-110 transition-transform duration-300">📚</span>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-3">
                            <span class="bg-indigo-50 text-indigo-700 text-xs px-2.5 py-1 rounded-lg font-semibold tracking-wide uppercase">
                                {{ $course->is_classroom ? __('Presencial / Apoyo') : 'Online' }}
                            </span>
                            <span class="text-gray-400 text-xs flex items-center gap-1">
                                📅 {{ $course->created_at ? $course->created_at->format('d/m/Y') : now()->format('d/m/Y') }}
                            </span>
                        </div>
                        <h3 class="text-xl font-black text-gray-900 mb-2 group-hover:text-indigo-600 transition-colors duration-200">
                            {{ $course->title }}
                        </h3>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-3 leading-relaxed">
                            {{ $course->description }}
                        </p>

                        @if($course->is_classroom && $course->schedule)
                        <div class="mb-4 bg-indigo-50/40 border border-indigo-100/50 rounded-xl p-3 text-xs flex justify-between items-center select-none">
                            <div>
                                <p class="text-indigo-900 font-extrabold uppercase tracking-wider">🗓 {{ __('Horario presencial') }}</p>
                                <p class="text-indigo-600 font-bold mt-0.5">{{ $course->schedule }}</p>
                            </div>
                            @if($course->classroom_pass_code)
                            <div class="text-right">
                                <p class="text-gray-400 uppercase font-bold">🎫 {{ __('Pase') }}</p>
                                <span class="text-indigo-700 font-black text-sm">{{ $course->classroom_pass_code }}</span>
                            </div>
                            @endif
                        </div>
                        @endif

                        <div class="flex justify-between items-center pt-4 border-t border-gray-50 mt-auto">
                            <div>
                                <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold">{{ __('Inversión') }}</p>
                                <span class="text-indigo-600 font-extrabold text-2xl">${{ number_format($course->price, 2) }}</span>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold">{{ __('Instructor') }}</p>
                                <span class="text-sm text-gray-800 font-bold">{{ $course->teacher->user->name ?? __('Profesor') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50/60 px-6 py-4 border-t border-gray-100/80">
                    <a href="/cursos/{{ $course->slug }}/enroll" class="block w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-xl shadow-sm hover:shadow-md transition-all duration-200 tracking-wide">
                        {{ __('Inscribirse al Curso') }}
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center py-16 bg-white rounded-3xl border border-dashed border-gray-200 shadow-sm">
                <span class="text-5xl mb-4 block">📂</span>
                <p class="text-gray-500 text-xl font-bold">{{ __('Actualmente no hay cursos publicados.') }}</p>
                <p class="text-gray-400 text-sm mt-1">{{ __('Vuelve pronto para ver las novedades.') }}</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
