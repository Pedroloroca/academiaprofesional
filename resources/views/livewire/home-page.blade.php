<div class="relative bg-white overflow-hidden min-h-screen flex flex-col justify-between">
    <!-- Background grid decoration -->
    <div class="absolute inset-0 bg-[linear-gradient(to_right,#f0f0f0_1px,transparent_1px),linear-gradient(to_bottom,#f0f0f0_1px,transparent_1px)] bg-[size:6rem_4rem] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_50%,#000_70%,transparent_100%)] opacity-30"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-24 lg:pt-24 lg:pb-32 flex-1">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <!-- Left content -->
            <div class="col-span-1 lg:col-span-7 z-10 flex flex-col justify-center text-center lg:text-left">
                <div class="inline-flex items-center space-x-2 bg-indigo-50 border border-indigo-100 rounded-full px-4 py-1.5 mb-6 self-center lg:self-start">
                    <span class="flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-2 w-2 rounded-full bg-indigo-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                    </span>
                    <span class="text-xs font-semibold text-indigo-700 tracking-wider uppercase">¡Nuevos cursos disponibles!</span>
                </div>

                <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-gray-900 tracking-tight mb-6">
                    Potencia tu futuro en la <br/>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-violet-600">Academia Profesional</span>
                </h1>
                
                <p class="text-base sm:text-lg md:text-xl text-gray-600 max-w-2xl mx-auto lg:mx-0 mb-8 leading-relaxed">
                    Nuestra plataforma te ofrece los mejores cursos online creados por profesores expertos. Desarrolla habilidades demandadas y transforma tu carrera hoy mismo.
                </p>

                <div class="flex flex-col sm:flex-row justify-center lg:justify-start gap-4">
                    <a href="/catalogo" class="flex items-center justify-center px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-200">
                        Explorar Catálogo &nbsp; &rarr;
                    </a>
                    <a href="/login" class="flex items-center justify-center px-8 py-4 bg-white hover:bg-gray-50 text-gray-800 border border-gray-200 font-bold rounded-xl shadow-sm hover:shadow hover:-translate-y-0.5 transition-all duration-200">
                        Acceso Alumnos
                    </a>
                </div>

                <!-- Simple stats / badges -->
                <div class="mt-12 pt-8 border-t border-gray-100 grid grid-cols-3 gap-4 max-w-md mx-auto lg:mx-0">
                    <div>
                        <p class="text-2xl md:text-3xl font-black text-indigo-600">{{ $coursesCount }}</p>
                        <p class="text-xs text-gray-500 font-medium mt-1 uppercase tracking-wider">Cursos</p>
                    </div>
                    <div>
                        <p class="text-2xl md:text-3xl font-black text-indigo-600">{{ $studentsCount }}</p>
                        <p class="text-xs text-gray-500 font-medium mt-1 uppercase tracking-wider">Alumnos</p>
                    </div>
                    <div>
                        <p class="text-2xl md:text-3xl font-black text-indigo-600">{{ $teachersCount }}</p>
                        <p class="text-xs text-gray-500 font-medium mt-1 uppercase tracking-wider">Profesores</p>
                    </div>
                </div>
            </div>

            <!-- Right content (Decorative illustration cards) -->
            <div class="col-span-1 lg:col-span-5 relative flex justify-center items-center z-10 select-none">
                <div class="relative w-full max-w-md aspect-square bg-gradient-to-tr from-indigo-100 to-purple-50 rounded-3xl p-8 flex flex-col justify-between shadow-2xl border border-indigo-50/50 hover:scale-[1.02] transition-transform duration-300">
                    <div class="absolute -top-6 -right-6 h-24 w-24 bg-gradient-to-tr from-indigo-500 to-purple-500 rounded-2xl flex items-center justify-center text-4xl shadow-lg transform rotate-12">
                        🚀
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="bg-indigo-600 text-white text-xs px-3 py-1 rounded-full font-bold">Premium</span>
                        <div class="flex space-x-1">
                            <span class="h-3 w-3 rounded-full bg-red-400"></span>
                            <span class="h-3 w-3 rounded-full bg-yellow-400"></span>
                            <span class="h-3 w-3 rounded-full bg-green-400"></span>
                        </div>
                    </div>
                    <div class="flex flex-col flex-1 justify-center py-6">
                        <span class="text-xs font-semibold text-indigo-600 uppercase tracking-wider mb-2">Desarrollo Profesional</span>
                        <h3 class="text-2xl md:text-3xl font-extrabold text-gray-900 leading-tight">
                            Domina las tecnologías más avanzadas del mercado.
                        </h3>
                    </div>
                    <div class="flex items-center justify-between pt-4 border-t border-indigo-100/60">
                        <div class="flex items-center space-x-3">
                            <div class="h-10 w-10 rounded-full bg-indigo-500 flex items-center justify-center text-white font-bold text-lg">
                                👨‍💻
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-900">Aprende haciendo</p>
                                <p class="text-xs text-gray-500">Proyectos 100% reales</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
