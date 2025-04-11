<?php

namespace App\Livewire\Comunication;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Comunication;

class Index extends Component
{
    use WithPagination;
    public $search = '';

    public function render()
    {
        $comunications = Comunication::query()
        ->when($this->search, function($query) {
            $query->where('title', 'like', '%' . $this->search . '%');
        })
        ->latest()
        ->paginate(5);

        return view('livewire.comunication.index', compact('comunications'));
    }

    public function resend($comunicationId)
    {
        $comunication = Comunication::findOrFail($comunicationId);

        if($comunication){
            Comunication::sendEmails($comunication);
    
            toastr()->success('Comunicado reenviado con exito.', ' ');
        }
        
    }

    public function delete($comunicationId)
    {
        $comunication = Comunication::find($comunicationId);
        if($comunication){
            $comunication->delete();
            toastr()->success('Comunicado eliminado con exito.', ' ');
        }
    }
}
