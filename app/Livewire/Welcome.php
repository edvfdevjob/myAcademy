<?php

namespace App\Livewire;

use Livewire\Component;

class Welcome extends Component
{
    public $showModal = false;
    public $componentToLoad = null;

    protected $listeners = ['openModalWithComponent'];

    public function openModalWithComponent($componentName)
    {
        $this->componentToLoad = $componentName;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->componentToLoad = null;
    }

    public function render()
    {
        return view('livewire.welcome');
    }
}
