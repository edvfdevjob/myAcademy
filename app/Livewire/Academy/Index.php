<?php

namespace App\Livewire\Academy;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Academy;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    protected $listeners = ['delete'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $academies = Academy::where('name', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.academy.index', compact('academies'));
    }

    public function delete($id)
    {
        if($id){
            $academy = Academy::findOrFail($id);
            $academy->delete();
            toastr()->success('Has eliminado una academia con exito', ' ');
        }
    }
}
