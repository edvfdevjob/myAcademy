<x-layout-app>
    <x-slot name="contentView">
        @livewire('student.create', ['id' => $id ?? null])
    </x-slot>
</x-layout-app>