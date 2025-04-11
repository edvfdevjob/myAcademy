<x-layout-app>
    <x-slot name="contentView">
        @livewire('comunication.create', ['id' => $id ?? null])
    </x-slot>
</x-layout-app>