<div class="p-4 space-y-4">
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-semibold">Listado de Academias</h2>

        <input
            type="text"
            placeholder="Buscar por nombre..."
            class="border rounded px-3 py-1 focus:outline-none focus:ring"
            wire:model.live.debounce.300ms="search"
        />
    </div>

    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="min-w-full text-sm text-left">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3">ID</th>
                    <th class="px-6 py-3">Nombre</th>
                    <th class="px-6 py-3">Teléfono</th>
                    @if (Auth::user()->role=='admin')
                    <th class="px-6 py-3">Acciones</th>
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($academies as $academy)
                    <tr>
                        <td class="px-6 py-4">{{ $academy->id }}</td>
                        <td class="px-6 py-4">{{ $academy->name }}</td>
                        <td class="px-6 py-4">{{ $academy->phone_number }}</td>
                        @if (Auth::user()->role=='admin')
                        <td class="px-6 py-4">
                            <a href="{{ route('academy.create', $academy->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                                Editar
                            </a>
                            <button wire:click="delete({{ $academy->id }})" class="bg-red-500 ms-3 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                                Eliminar
                            </button>
                        </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-center text-gray-500">No se encontraron academias.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $academies->links() }}
    </div>  
</div>