<?php

namespace App\Livewire\Academy;

use Livewire\Component;
use App\Models\Academy;
use Illuminate\Validation\Rule;

class Create extends Component
{
    public $academy = null;

    public $name = '';
    public $phone = '';

    public function mount($id = null)
    {
        if ($id) {
            $this->academy = Academy::findOrFail($id);
            $this->name = $this->academy->name;
            $this->phone = $this->academy->phone_number;
        }
    }

    public function rules()
    {
        return [
            'name' => [
                'required',
                'min:3',
                Rule::unique('academies', 'name')->ignore($this->academy?->id),
            ],
            'phone' => ['required'],
        ];
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'phone_number' => $this->phone,
        ];

        if ($this->academy) {
            $this->academy->update($data);
            toastr()->success('Has actualizado una academia con exito', ' ');

        } else {
            Academy::create($data);
            toastr()->success('Has creado una academia con exito', ' ');
            $this->reset(['name', 'phone']);
        }
    }

    public function render()
    {
        return view('livewire.academy.create');
    }
}
