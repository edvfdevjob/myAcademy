<div class="max-w-xl mx-auto p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-xl font-bold mb-4">
        {{ $student ? 'Editar Estudiante' : 'Crear Nueva Estudiante' }}
    </h2>

    <form wire:submit.prevent="save" class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Nombre</label>
            <input type="text" wire:model.defer="name"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
            @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Apellido</label>
            <input type="text" wire:model.defer="last_name"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
            @error('last_name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium">Fecha de Nacimiento</label>
            <input wire:model.defer="birth_date" type="date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
            @error('birth_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        @if (\Auth::user()->role==='admin')
        <div>
            <label class="block text-sm font-medium text-gray-700">Responsable</label>
            <select wire:model.defer="responsible_id"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Selecciona un responsable</option>
                @foreach($responsibles as $responsible)
                    <option value="{{ $responsible->id }}">{{ $responsible->user->name }}</option>
                @endforeach
            </select>
            @error('responsible_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>
        @endif

        <div class="flex justify-center">
            <a href="{{ route('student.index') }}"
                    class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 transition">
                Ir a Lista de Estudiantes
            </a>
            <button type="submit"
                    class="px-4 py-2 ms-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                {{ $student ? 'Actualizar' : 'Guardar' }}
            </button>
        </div>
    </form>
</div>
