<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-6">{{ $comunication ? 'Actualizar' : 'Crear' }} un Comunicado</h2>

    <form wire:submit.prevent="save" class="space-y-4">
        <div>
            <label>Título</label>
            <input type="text" wire:model="title" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            @error('title') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Mensaje</label>
            <textarea wire:model="message" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
            @error('message') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label>Fecha de Envío</label>
                <input type="date" wire:model="date_email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @error('date_email') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <div>
                <label>Curso</label>
                <select wire:model="course_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Seleccione un curso</option>
                    @foreach ($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                    @endforeach
                </select>
                @error('course_id') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
        </div>
        

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label>Edad mínima (opcional)</label>
                <input type="number" wire:model="min_age" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @error('min_age') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <div>
                <label>Edad máxima (opcional)</label>
                <input type="number" wire:model="max_age" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @error('max_age') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="flex justify-center">
            <a href="{{ route('comunication.index') }}"
                    class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 transition">
                Ir a Lista de Comunicados
            </a>
            <button type="submit" class="px-4 py-2 ms-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                {{ $comunication ? 'Actualizar' : 'Crear y Enviar Comunicado' }} 
            </button>
        </div>
        
    </form>
</div>
