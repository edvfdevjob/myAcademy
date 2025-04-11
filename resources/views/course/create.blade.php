<x-layout-app>
    <x-slot name="contentView">
        @livewire('course.create', ['id' => $id ?? null])
    </x-slot>
</x-layout-app>