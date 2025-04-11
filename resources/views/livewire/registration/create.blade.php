<div class="max-w-xl mx-auto p-6 bg-white shadow rounded-lg">
    @if($methodForm === 'registration')
        <h2 class="text-xl font-semibold mb-4">Inscripción para el Curso: {{ $course?->name }}</h2>
    @else
        <h2 class="text-xl font-semibold mb-4">Registro de un Pago</h2>
    @endif

    @if (session()->has('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="save" class="space-y-4">
        <div>
            <label class="block text-sm font-medium">Estudiante</label>
            <select wire:model.live="student_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Selecciona un estudiante</option>
                @foreach ($students as $student)
                    <option value="{{ $student->id }}">{{ $student->name }} {{ $student->last_name }}</option>
                @endforeach
            </select>
            @error('student_id') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
        </div>

        @if($methodForm === 'payment')
            <div>
                <label class="block mb-1 font-semibold">Curso</label>
                <select wire:model.live="course_id" class="w-full border rounded px-3 py-2">
                    <option value="">Seleccione</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                    @endforeach
                </select>
                @error('course_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        @endif

        <div>
            <label class="block text-sm font-medium">Método de pago</label>
            <select wire:model="method" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option value="cash">Efectivo</option>
                <option value="transfer">Transferencia</option>
            </select>
            @error('method') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium">Fecha de pago</label>
            <input type="date" wire:model="payment_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
            @error('payment_date') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
        </div>

        @if ($methodForm=='payment')
        <div>
            <label class="block text-sm font-medium">Monto</label>
            <input type="number" wire:model="amount" min="0.01" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
            @error('amount') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
        </div>
        @endif
        
        <div>
            <label class="block font-medium text-sm text-gray-700">Descripción</label>
            <textarea wire:model="description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
            @error('description') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="pt-4 m-auto">
            <button type="submit" class="px-4 py-2 ms-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
               Guardar {{ $methodForm=='payment' ? 'Pago' : 'Inscripción' }}
            </button>
        </div>
    </form>
</div>
