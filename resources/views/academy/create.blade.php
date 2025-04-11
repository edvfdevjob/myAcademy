<x-layout-app>
    <x-slot name="contentView">
        @livewire('academy.create', ['id' => $id ?? null])
    </x-slot>
</x-layout-app>