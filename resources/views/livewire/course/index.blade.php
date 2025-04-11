<div class="p-6">
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-semibold">Listado de Cursos</h2>

        <input
            type="text"
            placeholder="Buscar por nombre..."
            class="border rounded px-3 py-1 focus:outline-none focus:ring"
            wire:model.live.debounce.300ms="search"
        />
    </div>

    <br>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($courses as $course)
            <div class="bg-white shadow-md rounded-lg p-6 flex flex-col justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">{{ $course->name }}</h2>
                    <p class="text-gray-600 mb-3">{{ $course->description }}</p>
                    <p class="text-sm text-gray-700"><strong>Costo:</strong> ${{ number_format($course->price, 2) }}</p>
                    <p class="text-sm text-gray-700"><strong>Duración:</strong> {{ $course->duration }} horas</p>
                </div>
                @if (Auth::user()->role=='admin')
                <div class="flex justify-center mt-3">
                    <a href="{{ route('course.create', $course->id) }}" class=" bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md transition duration-200">
                        Editar
                    </a>
                    <button
                        class="ms-3 bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-md transition duration-200"
                        wire:click="delete({{ $course->id }})"
                    >
                        Eliminar
                    </button>
                </div>
                @endif
                
                <div class="mt-4">
                    
                    <button
                        wire:click="openModal({{ $course->id }})"
                        class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-md transition duration-200"
                    >
                        Inscribir
                    </button>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center text-gray-500">
                No se encontraron cursos.
            </div>
        @endforelse
    </div>
    <div class="mt-6">
        {{ $courses->links() }}
    </div>

    <x-dialog-modal wire:model="showModal">
        <x-slot name="title">
            
        </x-slot>

        <x-slot name="content">
            @livewire('registration.create', ['methodForm' => 'registration', 'course_id' => $courseId], key($courseId))
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('showModal', false)">
                Cerrar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
