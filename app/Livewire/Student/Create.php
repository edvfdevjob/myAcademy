<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\Student;
use App\Models\Responsible;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class Create extends Component
{
    public $student = null;

    public $name = '';
    public $last_name = '';
    public $birth_date = '';
    public $responsible_id = '';
    public $user;

    public function mount($id = null)
    {
        $this->user = auth()->user();

        if ($id) {
            $this->student = Student::findOrFail($id);
            $this->name = $this->student->name;
            $this->last_name = $this->student->last_name;
            $this->birth_date = $this->student->birth_date;
            $this->responsible_id = $this->student->responsible_id;
        }
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'birth_date' => ['required', 'date'],
            'responsible_id' => $this->user->role === 'admin' ? ['required', 'exists:responsibles,id'] : ['nullable'],
        ];
    }

    public function save()
    {
        $this->validate();

        $responsibleId = $this->user->role === 'admin' ? $this->responsible_id : $this->user->responsible->id;
        $data = [
            'name' => $this->name,
            'last_name' => $this->last_name,
            'birth_date' => $this->birth_date,
            'responsible_id' => $responsibleId,
        ];

        if ($this->student) {
            $this->student->update($data);
            toastr()->success('Has actualizado a un estudiante con exito', ' ');
        } else {
            Student::create($data);
            toastr()->success('Has creado a un estudiante con exito', ' ');
            $this->reset();
        }
    }

    public function render()
    {
        $responsibles = Responsible::all();
        return view('livewire.student.create', compact('responsibles'));
    }
}
