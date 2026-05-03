<div class="py-12 bg-gray-50/50 min-h-screen">
    <div class="max-w-3xl mx-auto px-4">
        <!-- Back Link -->
        <div class="mb-6">
            <a href="/catalogo" class="text-indigo-600 hover:text-indigo-800 font-bold text-sm flex items-center gap-2 select-none">
                &larr; {{ __('Volver al catálogo de cursos') }}
            </a>
        </div>

        <!-- Premium Box -->
        <div class="bg-white p-8 md:p-10 rounded-3xl border border-gray-100 shadow-xl overflow-hidden relative">
            <div class="absolute -top-10 -right-10 h-32 w-32 bg-indigo-50/60 rounded-full blur-2xl pointer-events-none select-none"></div>

            <div class="mb-8">
                <span class="bg-indigo-50 text-indigo-700 text-xs px-3 py-1 rounded-full font-bold uppercase tracking-wider">{{ __('Formulario de Matrícula') }}</span>
                <h2 class="text-3xl font-extrabold mt-3 text-gray-900 leading-tight">
                    {{ __('Inscripción en:') }} <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-violet-600">{{ $course->title }}</span>
                </h2>
                <p class="text-sm text-gray-500 mt-2">{{ __('Introduce los datos del estudiante para proceder con el alta y habilitar su acceso a la plataforma.') }}</p>
            </div>

            <!-- Messages -->
            @if (session()->has('message'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-xl shadow-sm mb-6 flex justify-between items-center animate-fade-in">
                    <p class="text-sm font-bold text-green-800">✔ {{ session('message') }}</p>
                    <button class="text-green-600 hover:text-green-800 font-bold" onclick="this.parentElement.remove()">✕</button>
                </div>
            @endif
            
            @if (session()->has('error'))
                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-xl shadow-sm mb-6 flex justify-between items-center animate-fade-in">
                    <p class="text-sm font-bold text-red-800">⚠ {{ session('error') }}</p>
                    <button class="text-red-600 hover:text-red-800 font-bold" onclick="this.parentElement.remove()">✕</button>
                </div>
            @endif

            <form wire:submit.prevent="enroll">
                 @auth
                 <!-- Summary of logged-in user -->
                 <div class="mb-6 p-5 bg-indigo-50/40 border border-indigo-100/50 rounded-2xl flex items-center justify-between">
                     <div>
                         <span class="text-xs text-indigo-500 font-bold uppercase tracking-wider block">{{ __('Vas a matricularte como') }}</span>
                         <span class="text-base font-black text-gray-900 block mt-0.5">{{ auth()->user()->name }}</span>
                         <span class="text-xs text-gray-400 block">{{ auth()->user()->email }}</span>
                     </div>
                     <span class="text-2xl select-none">👤</span>
                 </div>
                 @else
                 <!-- Link to login -->
                 <div class="mb-6 p-5 bg-yellow-50 border border-yellow-200 rounded-2xl">
                     <p class="text-sm font-bold text-yellow-800">{{ __('Inicia sesión o regístrate para matricularte.') }}</p>
                     <a href="/login" class="text-sm font-black text-indigo-600 hover:underline mt-1 inline-block">{{ __('Ir a Iniciar Sesión') }} &rarr;</a>
                 </div>
                 @endauth

                <!-- Course summary sidebar (Inline) -->
                <div class="bg-indigo-50/40 border border-indigo-100/50 rounded-2xl p-6 mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <h4 class="text-sm font-extrabold text-indigo-900 uppercase tracking-wider">{{ __('Inversión del curso') }}</h4>
                        <p class="text-xs text-indigo-600 font-medium">{{ __('Pago único y acceso inmediato de por vida') }}</p>
                    </div>
                    <span class="text-3xl font-black text-indigo-700 select-none">${{ number_format($course->price, 2) }}</span>
                </div>

                <div class="mt-8">
                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-black py-4 px-6 rounded-2xl shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-200 tracking-wide">
                        {{ __('Confirmar y Finalizar Matrícula') }} &nbsp; 🚀
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
