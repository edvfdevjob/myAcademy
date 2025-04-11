<div class="container mx-auto p-4">
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-semibold">Listado de Comunicados</h2>

        <input
            type="text"
            placeholder="Buscar por titulo..."
            class="border rounded px-3 py-1 focus:outline-none focus:ring"
            wire:model.live.debounce.300ms="search"
        />
    </div>

    @forelse($comunications as $comunication)
        <div class="bg-white shadow-md rounded-lg p-4 mb-4 w-full">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-xl font-semibold">{{ $comunication->title }}</h3>
                    <p class="text-gray-700">{{ $comunication->message }}</p>
                    <p class="text-gray-700"><strong>Curso:</strong> {{ $comunication->course->name }}</p>
                    <p class="text-gray-500 mt-2">Fecha de envío: {{ \Carbon\Carbon::parse($comunication->date_email)->format('d/m/Y') }}</p>
                </div>
                <div class="flex flex-col gap-2 text-center">
                    <a href="{{ route('comunication.create', $comunication->id) }}"
                       class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">Editar</a>

                    <button
                        wire:click="delete({{ $comunication->id }})"
                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                        Eliminar
                    </button>

                    <button
                        wire:click="resend({{ $comunication->id }})"
                        class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm">
                        Reenviar
                    </button>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full text-center text-gray-500">
            No se encontraron comunicados.
        </div>
    @endforelse

    <div class="mt-4">
        {{ $comunications->links() }}
    </div>

    <div class="block">
        <a href="{{ route('comunication.create') }}" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md transition duration-200">
            Crear Comunicado
        </a>
    </div>
</div>
