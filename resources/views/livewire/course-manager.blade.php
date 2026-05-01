<div class="py-6">
    <!-- Header Area -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div>
            <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Gestión de Cursos</h2>
            <p class="text-sm text-gray-500 mt-1">Administra los contenidos, precios y estados de los cursos de la academia.</p>
        </div>
        <button wire:click="create()" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-xl shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">
            <span>➕</span> Crear Nuevo Curso
        </button>
    </div>

    <!-- Alert Message -->
    @if (session()->has('message'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-xl shadow-sm mb-8 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <span class="text-green-600 text-lg">✔</span>
                <p class="text-sm font-medium text-green-800">{{ session('message') }}</p>
            </div>
            <button class="text-green-500 hover:text-green-700 font-bold" onclick="this.parentElement.remove()">✕</button>
        </div>
    @endif

    <!-- Premium Table Container -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-xl overflow-hidden mb-12">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50/60 select-none">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Título del Curso</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Profesor</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Precio</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Ámbito</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Estado</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @foreach($courses as $course)
                    <tr class="hover:bg-indigo-50/30 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <span class="text-2xl select-none">📘</span>
                                <div class="text-sm font-extrabold text-gray-900 group-hover:text-indigo-600 transition-colors">{{ $course->title }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                <div class="h-8 w-8 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold text-xs">
                                    {{ substr($course->teacher->user->name ?? 'P', 0, 1) }}
                                </div>
                                <span class="text-sm font-bold text-gray-700">{{ $course->teacher->user->name ?? 'Instructor' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-extrabold text-indigo-600">
                            ${{ number_format($course->price, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-black rounded-full select-none {{ $course->scope === 'profesional' ? 'bg-indigo-100 text-indigo-800' : 'bg-purple-100 text-purple-800' }}">
                                {{ $course->scope === 'profesional' ? 'Profesional' : 'Escolar' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-black rounded-full select-none {{ $course->status === 'published' ? 'bg-green-100 text-green-800' : ($course->status === 'draft' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                {{ ucfirst($course->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold">
                            <button wire:click="edit({{ $course->id }})" class="text-indigo-600 hover:text-indigo-800 mr-4 inline-flex items-center gap-1 transition-colors">
                                ✏ Editar
                            </button>
                            <button wire:click="delete({{ $course->id }})" class="text-red-600 hover:text-red-800 inline-flex items-center gap-1 transition-colors">
                                🗑 Eliminar
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal for Create/Update -->
    @if($isOpen)
    <div class="fixed z-50 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" aria-hidden="true" wire:click="closeModal()"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100">
                <form wire:submit.prevent="store">
                    <div class="bg-white px-6 pt-6 pb-4 sm:p-8 sm:pb-6">
                        <div class="flex justify-between items-center mb-6 border-b pb-4">
                            <h3 class="text-xl font-extrabold text-gray-900">{{ $course_id ? '✏ Editar Curso' : '➕ Crear Nuevo Curso' }}</h3>
                            <button type="button" wire:click="closeModal()" class="text-gray-400 hover:text-gray-600 font-bold">✕</button>
                        </div>
                        
                        <div class="mb-5">
                            <x-ui.label for="title" value="Título del Curso" class="font-bold text-gray-700" />
                            <x-ui.input type="text" id="title" wire:model="title" class="mt-1 block w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500" placeholder="Ej: Introducción a Laravel" />
                            @error('title') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-5">
                            <x-ui.label for="description" value="Descripción" class="font-bold text-gray-700" />
                            <textarea id="description" wire:model="description" class="border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm mt-1 block w-full text-sm leading-relaxed" rows="4" placeholder="Escribe un resumen detallado del contenido del curso..."></textarea>
                            @error('description') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-5">
                            <x-ui.label for="price" value="Precio ($)" class="font-bold text-gray-700" />
                            <x-ui.input type="number" step="0.01" id="price" wire:model="price" class="mt-1 block w-full rounded-xl border-gray-200" placeholder="0.00" />
                            @error('price') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-5">
                            <x-ui.label for="teacher_id" value="Asignar Profesor" class="font-bold text-gray-700" />
                            <x-ui.select id="teacher_id" wire:model="teacher_id" class="mt-1 block w-full rounded-xl border-gray-200">
                                <option value="">Seleccione un profesor</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}">{{ $teacher->user->name }}</option>
                                @endforeach
                            </x-ui.select>
                            @error('teacher_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-5">
                            <x-ui.label for="status" value="Estado" class="font-bold text-gray-700" />
                            <x-ui.select id="status" wire:model="status" class="mt-1 block w-full rounded-xl border-gray-200">
                                <option value="draft">Borrador</option>
                                <option value="published">Publicado</option>
                                <option value="archived">Archivado</option>
                            </x-ui.select>
                            @error('status') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-5">
                            <x-ui.label for="scope" value="Ámbito del Curso / Formación" class="font-bold text-gray-700" />
                            <x-ui.select id="scope" wire:model="scope" class="mt-1 block w-full rounded-xl border-gray-200">
                                <option value="profesional">Profesional</option>
                                <option value="escolar">Escolar (Colegio / Instituto)</option>
                            </x-ui.select>
                            @error('scope') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Extra school/classroom fields -->
                        <div class="mb-5 flex items-center">
                            <input id="is_classroom" type="checkbox" wire:model.live="is_classroom" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" />
                            <label for="is_classroom" class="ml-2 block text-sm font-bold text-gray-700 select-none">
                                ¿Es clase presencial / apoyo escolar?
                            </label>
                            @error('is_classroom') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        @if($is_classroom)
                        <div class="mb-5">
                            <x-ui.label for="schedule" value="Horario de clase" class="font-bold text-gray-700" />
                            <x-ui.input type="text" id="schedule" wire:model="schedule" class="mt-1 block w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500" placeholder="Ej: Lunes y Miércoles 17:00 - 18:30" />
                            @error('schedule') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-5">
                            <x-ui.label for="classroom_pass_code" value="Pase de asistencia / Código de acceso" class="font-bold text-gray-700" />
                            <x-ui.input type="text" id="classroom_pass_code" wire:model="classroom_pass_code" class="mt-1 block w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500" placeholder="Ej: PASS-1234" />
                            @error('classroom_pass_code') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        @endif
                    </div>
                    <div class="bg-gray-50/60 px-6 py-4 sm:px-8 sm:flex sm:flex-row-reverse gap-3 border-t border-gray-100">
                        <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-base font-extrabold text-white sm:w-auto sm:text-sm tracking-wide">
                            Guardar Cambios
                        </button>
                        <button type="button" wire:click="closeModal()" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-200 shadow-sm px-6 py-3 bg-white hover:bg-gray-50 text-base font-extrabold text-gray-700 sm:mt-0 sm:w-auto sm:text-sm tracking-wide">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>
