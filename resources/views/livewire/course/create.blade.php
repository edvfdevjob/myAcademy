<div class="max-w-xl mx-auto p-6 bg-white shadow rounded-lg">
        <h2 class="text-xl font-bold mb-4">
        {{ $course ? 'Editar Curso' : 'Crear Nuevo Curso' }}
    </h2>

    <form wire:submit.prevent="save" class="bg-white shadow-md rounded-lg p-6 space-y-4">

        <div>
        <label class="block text-sm font-medium text-gray-700">Nombre</label>
        <input type="text" wire:model="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
            @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block font-medium text-sm text-gray-700">Descripción</label>
            <textarea wire:model="description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
            @error('description') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block font-medium text-sm text-gray-700">Precio</label>
            <input type="text" wire:model="price" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
            @error('price') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block font-medium text-sm text-gray-700">Duración (horas)</label>
            <input type="number" wire:model="duration" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" min="60" max="4000" />
            @error('duration') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block font-medium text-sm text-gray-700">Academia</label>
            <select wire:model="academy_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Seleccione una academia</option>
                @foreach($academies as $academy)
                    <option value="{{ $academy->id }}">{{ $academy->name }}</option>
                @endforeach
            </select>
            @error('academy_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="flex justify-center">
            <a href="{{ route('course.index') }}"
                    class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 transition">
                Ir a Lista de Cursos
            </a>
            <button type="submit" class="px-4 py-2 ms-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                {{ $course ? 'Actualizar' : 'Guardar' }}
            </button>
        </div>

    </form>
</div>
