<?php

namespace App\Livewire\Course;

use Livewire\Component;
use App\Models\Course;
use App\Models\Academy;
use Illuminate\Validation\Rule;

class Create extends Component
{
    public $course = null;
    public $name = '';
    public $description = '';
    public $price = '';
    public $duration = '';
    public $academy_id = '';

    public function mount($id = null)
    {
        if ($id) {
            $this->course = Course::findOrFail($id);
            $this->name = $this->course->name;
            $this->description = $this->course->description;
            $this->price = $this->course->price;
            $this->duration = $this->course->duration;
            $this->academy_id = $this->course->academy_id;
        }
    }

    public function rules()
    {
        return [
            'name' => [
                'required',
                'min:3',
                Rule::unique('courses', 'name')->ignore($this->course?->id),
            ],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric'],
            'duration' => ['required', 'integer', 'min:60', 'max:4000'],
            'academy_id' => ['required', 'exists:academies,id'],
        ];
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'duration' => $this->duration,
            'academy_id' => $this->academy_id
        ];

        if ($this->course) {
            $this->course->update($data);
            toastr()->success('Has actualizado un curso con exito', ' ');
        } else {
            Course::create($data);
            toastr()->success('Has creado un curso con exito', ' ');
            $this->reset();
        }
    }

    public function render()
    {
        return view('livewire.course.create', [
            'academies' => Academy::all(),
        ]);
    }
}
