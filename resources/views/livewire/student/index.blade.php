<div class="container mx-auto p-4">
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-semibold">Listado de Estudiantes</h2>

        <input
            type="text"
            placeholder="Buscar por nombre"
            class="border w-auto rounded px-3 py-1 focus:outline-none focus:ring"
            wire:model.live.debounce.300ms="search"
        />
    </div>

    <br>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
        @forelse($students as $student)
            <div class="bg-white p-4 rounded-lg shadow-lg">
                <h2 class="text-xl font-semibold mb-2">
                    {{ $student->name }} {{ $student->last_name }}
                </h2>
                <p class="text-gray-600">
                    Fecha de Nacimiento: {{ \Carbon\Carbon::parse($student->birth_date)->format('d/m/Y') }}
                </p>
                <p class="text-gray-600">
                    Edad: ({{ \Carbon\Carbon::parse($student->birth_date)->age }} años)
                </p>
                @if($student->registrations->isNotEmpty())
                    <p class="text-gray-600 mt-2">
                        <strong>Cursos:</strong>
                        {{ $student->registrations->pluck('course.name')->join(', ') }}
                    </p>
                @endif
                <div class="flex justify-center mt-3">
                    <a href="{{ route('student.create', $student->id) }}" class=" bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md transition duration-200">
                        Editar
                    </a>
                    <button
                        class="ms-3 bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-md transition duration-200"
                        wire:click="delete({{ $student->id }})"
                    >
                        Eliminar
                    </button>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center text-gray-500">
                No se encontraron estudiantes.
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $students->links() }}
    </div>

    <br>

    <div class="block">
        <a href="{{ route('student.create') }}" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md transition duration-200">
            Crear Estudiante
        </a>
    </div>
</div>
