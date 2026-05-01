<div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-6">Matricularse en: <span class="text-indigo-600">{{ $course->title }}</span></h2>

    @if (session()->has('message'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p>{{ session('message') }}</p>
        </div>
    @endif
    
    @if (session()->has('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
            <p>{{ session('error') }}</p>
        </div>
    @endif

    <form wire:submit.prevent="enroll">
        <div class="mb-4">
            <x-ui.label for="student_id" value="Seleccione el Estudiante" />
            <x-ui.select id="student_id" wire:model="student_id" class="mt-1 block w-full">
                <option value="">-- Seleccione Estudiante --</option>
                @foreach($students as $student)
                    <option value="{{ $student->id }}">{{ $student->user->name }} ({{ $student->user->email }})</option>
                @endforeach
            </x-ui.select>
            @error('student_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="mt-6">
            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded transition-colors">
                Confirmar Matrícula
            </button>
        </div>
        
        <div class="mt-4 text-center">
            <a href="/catalogo" class="text-indigo-600 hover:text-indigo-800 text-sm">Volver al catálogo</a>
        </div>
    </form>
</div>
