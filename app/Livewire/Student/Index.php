<?php

namespace App\Livewire\Student;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Student;
use Carbon\Carbon;

class Index extends Component
{
     use WithPagination;
     public $user;
     public $search = '';

     protected $paginationTheme = 'tailwind';

     public function mount()
     {
        $this->user = \Auth::user();
     }

     public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $students = Student::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('last_name', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('name');
        if($this->user->role!='admin'){
            $students = $students->where('responsible_id', \Auth::user()->responsible?->id);
        }
        $students = $students->paginate(9);

        return view('livewire.student.index', compact('students'));
    }
 
     public function getAge($birthDate)
     {
         return Carbon::parse($birthDate)->age;
     }

     public function delete($id)
    {
        if($id){
            $payment = Student::find($id);
            $payment->delete();
            toastr()->success('Has eliminado un estudiante con exito', ' ');
        }   
    }
}
