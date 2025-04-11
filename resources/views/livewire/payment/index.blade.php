<div class="p-6">
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-semibold">Listado de Pagos</h2>

        <input
            type="text"
            placeholder="Buscar por Estudiante..."
            class="border rounded px-3 py-1 focus:outline-none focus:ring"
            wire:model.live.debounce.300ms="search"
        />
    </div>

    <br>

    <div class="overflow-x-auto">
        <table class="min-w-full text-sm bg-white border rounded-lg shadow">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-2 text-left">ID</th>
                    <th class="px-4 py-2 text-left">Estudiante</th>
                    <th class="px-4 py-2 text-left">Curso</th>
                    <th class="px-4 py-2 text-left">Monto</th>
                    <th class="px-4 py-2 text-left">Descripción</th>
                    <th class="px-4 py-2 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($payments as $payment)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $payment->id }}</td>
                        <td class="px-4 py-2">
                            {{ $payment->registration->student->name ?? 'N/A' }}
                            {{ $payment->registration->student->last_name ?? '' }}
                        </td>
                        <td class="px-4 py-2">{{ $payment->registration->course->name ?? 'N/A' }}</td>
                        <td class="px-4 py-2">${{ number_format($payment->amount, 2) }}</td>
                        <td class="px-4 py-2">{{ $payment->description ?? '-' }}</td>
                        <td class="px-4 py-2 text-center">
                            <button class="bg-red-500 ms-3 hover:bg-red-600 text-white px-3 py-1 rounded text-sm" wire:click="delete({{ $payment->id }})">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-4 text-center text-gray-500">
                            No se encontraron pagos.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $payments->links() }}
    </div>

    <br>

    <div class="block">
        <button wire:click="$set('showModal', true)" class=" bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md transition duration-200">
            Registrar Pago
        </button>
    </div>

    <x-dialog-modal wire:model="showModal">
        <x-slot name="title">
        </x-slot>

        <x-slot name="content">
            @livewire('registration.create', ['methodForm' => 'payment'])
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('showModal', false)">
                Cerrar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
