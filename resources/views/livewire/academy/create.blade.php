<div class="max-w-xl mx-auto p-6 bg-white shadow rounded-lg">
    <h2 class="text-xl font-bold mb-4">
        {{ $academy ? 'Editar Academia' : 'Crear Nueva Academia' }}
    </h2>

    <form wire:submit.prevent="save" class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Nombre</label>
            <input type="text" wire:model.defer="name"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                   placeholder="Nombre de la academia">
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Teléfono</label>
            <input type="text" wire:model.defer="phone"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                   placeholder="Ej: 5551234567">
            @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="flex justify-center">
            <a href="{{ route('academy.index') }}"
                    class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 transition">
                Ir a Lista de Academia
            </a>
            <button type="submit"
                    class="px-4 py-2 ms-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                {{ $academy ? 'Actualizar' : 'Guardar' }}
            </button>
        </div>
    </form>
</div>
