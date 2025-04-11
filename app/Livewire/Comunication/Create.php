<?php

namespace App\Livewire\Comunication;

use Livewire\Component;
use App\Mail\ComunicationMail;
use Carbon\Carbon;
use App\Models\Comunication;
use App\Models\Course;

class Create extends Component
{
    public $comunication;
    public $title;
    public $message;
    public $date_email;
    public $course_id;
    public $min_age;
    public $max_age;

    public function mount($id = null)
    {
        if ($id) {
            $this->comunication = Comunication::find($id);
            $this->title = $this->comunication->title;
            $this->message = $this->comunication->message;
            $this->date_email = $this->comunication->date_email;
            $this->course_id = $this->comunication->course_id;
        }
    }

    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'date_email' => 'required|date',
            'course_id' => 'required|exists:courses,id',
            'min_age' => 'nullable|integer|min:0',
            'max_age' => 'nullable|integer|min:0',
        ];
    }

    public function save()
    {
        $this->validate();

        $data = [
                'title' => $this->title,
                'message' => $this->message,
                'date_email' => $this->date_email,
                'course_id' => $this->course_id,
                'min_age' => $this->min_age,
                'max_age' => $this->max_age,
        ];
        if ($this->comunication) {
            $this->comunication->update($data);

            toastr()->success('Comunicado actualizado con exito.', ' ');
        } else {
            $comunication = Comunication::create($data);

            Comunication::sendEmails($comunication);

            toastr()->success('Comunicado creado y enviado con éxito.', ' ');
            $this->reset();
        }
    }

    public function render()
    {
        $courses = Course::all();
        return view('livewire.comunication.create', compact('courses'));
    }
}
