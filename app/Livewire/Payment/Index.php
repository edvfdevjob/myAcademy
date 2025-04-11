<?php

namespace App\Livewire\Payment;

use App\Models\Payment;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public $showModal = false;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $user = auth()->user();

        $payments = Payment::with(['registration.student', 'registration.course'])
            ->whereHas('registration.student', function ($query) use ($user) {
                if($user->role!=='admin'){
                    $query->where('responsible_id', $user->responsible->id ?? null);
                }
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orderByDesc('id')
            ->paginate(10);

        return view('livewire.payment.index', compact('payments'));
    }

    public function delete($id)
    {
        if($id){
            $payment = Payment::find($id);
            $payment->delete();
            toastr()->success('Has eliminado un pago con exito', ' ');
        }   
    }
}
