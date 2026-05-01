<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10 select-none">
    <!-- Stat 1 -->
    <div class="group bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between">
        <div class="flex items-center justify-between mb-4">
            <span class="text-sm font-black text-gray-400 uppercase tracking-wider">Total Cursos</span>
            <span class="text-2xl h-10 w-10 bg-indigo-50 rounded-xl text-indigo-600 flex items-center justify-center font-bold">📚</span>
        </div>
        <p class="text-4xl font-black text-gray-900 tracking-tight">{{ $stats['total_courses'] }}</p>
    </div>
    
    <!-- Stat 2 -->
    <div class="group bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between">
        <div class="flex items-center justify-between mb-4">
            <span class="text-sm font-black text-gray-400 uppercase tracking-wider">Publicados</span>
            <span class="text-2xl h-10 w-10 bg-green-50 rounded-xl text-green-600 flex items-center justify-center font-bold">✔</span>
        </div>
        <p class="text-4xl font-black text-gray-900 tracking-tight">{{ $stats['published_courses'] }}</p>
    </div>
    
    <!-- Stat 3 -->
    <div class="group bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between">
        <div class="flex items-center justify-between mb-4">
            <span class="text-sm font-black text-gray-400 uppercase tracking-wider">Total Estudiantes</span>
            <span class="text-2xl h-10 w-10 bg-violet-50 rounded-xl text-violet-600 flex items-center justify-center font-bold">👨‍🎓</span>
        </div>
        <p class="text-4xl font-black text-gray-900 tracking-tight">{{ $stats['total_students'] }}</p>
    </div>
    
    <!-- Stat 4 -->
    <div class="group bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between">
        <div class="flex items-center justify-between mb-4">
            <span class="text-sm font-black text-gray-400 uppercase tracking-wider">Matrículas Activas</span>
            <span class="text-2xl h-10 w-10 bg-blue-50 rounded-xl text-blue-600 flex items-center justify-center font-bold">📄</span>
        </div>
        <p class="text-4xl font-black text-gray-900 tracking-tight">{{ $stats['active_enrollments'] }}</p>
    </div>
</div>
