<div>
    <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
        <x-application-logo class="block h-12 w-auto" />

        <h1 class="mt-8 text-2xl font-medium text-gray-900">
            Bienvenido a My Academy!
        </h1>

        <p class="mt-6 text-gray-500 leading-relaxed">
        Inscribe a tus hijos de forma rápida y segura
        Esta aplicación te permite inscribir fácilmente a tus hijos en los cursos disponibles del colegio, gestionar sus matrículas y registrar sus pagos, todo desde un solo lugar y sin complicaciones.
        </p>
    </div>

    <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 p-6 lg:p-8">
        <div>
            <div class="flex items-center">
                <h2 class="ms-3 text-xl font-semibold text-gray-900 cursor-pointer" wire:click="$dispatch('openModalWithComponent', { componentName: 'academy.index'})">
                    Ver Academias
                </h2>
            </div>

            <p class="mt-4 text-sm">
                <button wire:click="$dispatch('openModalWithComponent', { componentName: 'academy.index'})" class="inline-flex items-center font-semibold text-indigo-700">
                    Haz click aqui para ver las Academias

                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="ms-1 w-5 h-5 fill-indigo-500">
                        <path fill-rule="evenodd" d="M5 10a.75.75 0 01.75-.75h6.638L10.23 7.29a.75.75 0 111.04-1.08l3.5 3.25a.75.75 0 010 1.08l-3.5 3.25a.75.75 0 11-1.04-1.08l2.158-1.96H5.75A.75.75 0 015 10z" clip-rule="evenodd" />
                    </svg>
                </button>
            </p>
        </div>

        <div>
            <div class="flex items-center">
                
                <h2 class="ms-3 text-xl font-semibold text-gray-900 cursor-pointer" wire:click="$dispatch('openModalWithComponent', { componentName: 'course.index'})">
                    Ver Cursos
                </h2>
            </div>

            <p class="mt-4 text-sm">
                <a wire:click="$dispatch('openModalWithComponent', { componentName: 'course.index'})" class="cursor-pointer inline-flex items-center font-semibold text-indigo-700">
                    Haz click aqui para ver los Cursos

                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="ms-1 w-5 h-5 fill-indigo-500">
                        <path fill-rule="evenodd" d="M5 10a.75.75 0 01.75-.75h6.638L10.23 7.29a.75.75 0 111.04-1.08l3.5 3.25a.75.75 0 010 1.08l-3.5 3.25a.75.75 0 11-1.04-1.08l2.158-1.96H5.75A.75.75 0 015 10z" clip-rule="evenodd" />
                    </svg>
                </a>
            </p>
        </div>

        <div>
            <div class="flex items-center">
                <h2 class="ms-3 text-xl font-semibold text-gray-900">
                    <a href="{{ route('student.create') }}">Agregar Estudiante</a>
                </h2>
            </div>

            <p class="mt-4 text-sm">
                <a href="{{ route('student.create') }}" class="inline-flex items-center font-semibold text-indigo-700">
                    Haz click aqui para agregar un Estudiante

                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="ms-1 w-5 h-5 fill-indigo-500">
                        <path fill-rule="evenodd" d="M5 10a.75.75 0 01.75-.75h6.638L10.23 7.29a.75.75 0 111.04-1.08l3.5 3.25a.75.75 0 010 1.08l-3.5 3.25a.75.75 0 11-1.04-1.08l2.158-1.96H5.75A.75.75 0 015 10z" clip-rule="evenodd" />
                    </svg>
                </a>
            </p>
        </div>

        <div>
            <div class="flex items-center">
                
                <h2 class="ms-3 text-xl font-semibold text-gray-900">
                    <a href="{{ route('payment.index') }}">Ver Pagos</a>
                </h2>
            </div>

            <p class="mt-4 text-sm">
                <a href="{{ route('payment.index') }}" class="inline-flex items-center font-semibold text-indigo-700">
                    Haz click aqui para registrar ver tus pagos registrados

                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="ms-1 w-5 h-5 fill-indigo-500">
                        <path fill-rule="evenodd" d="M5 10a.75.75 0 01.75-.75h6.638L10.23 7.29a.75.75 0 111.04-1.08l3.5 3.25a.75.75 0 010 1.08l-3.5 3.25a.75.75 0 11-1.04-1.08l2.158-1.96H5.75A.75.75 0 015 10z" clip-rule="evenodd" />
                    </svg>
                </a>
            </p>
        </div>
    </div>
    <x-dialog-modal wire:model="showModal">
        <x-slot name="title">
            
        </x-slot>

        <x-slot name="content">
            @if ($componentToLoad)
                @livewire($componentToLoad, [], key($componentToLoad . now()))

            @else
                <p>No hay componente seleccionado.</p>
            @endif
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('showModal', false)">
                Cerrar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
