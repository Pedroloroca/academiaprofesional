<div>
    <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Nuestro Profesorado</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($teachers as $teacher)
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <div class="w-24 h-24 bg-indigo-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                <span class="text-indigo-600 text-2xl font-bold">{{ substr($teacher->user->name, 0, 1) }}</span>
            </div>
            <h3 class="text-xl font-bold text-gray-900">{{ $teacher->user->name }}</h3>
            <p class="text-gray-500 text-sm mt-2">{{ $teacher->bio ?: 'Profesor de la academia' }}</p>
            @if($teacher->website_url)
            <a href="{{ $teacher->website_url }}" target="_blank" class="text-indigo-600 hover:text-indigo-800 text-sm mt-4 inline-block">Ver sitio web</a>
            @endif
        </div>
        @endforeach
    </div>
</div>
