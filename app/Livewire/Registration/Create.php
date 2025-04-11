<?php

namespace App\Livewire\Registration;

use App\Models\Payment;
use App\Models\Registration;
use Livewire\Component;
use App\Models\Student;
use App\Models\Course;
use Illuminate\Validation\Rule;

class Create extends Component
{
    public $methodForm = 'registration';
    public $course_id;
    public $course;
    public $student_id;
    public $method = "cash";
    public $payment_date;
    public $amount;
    public $description;

    public $courses = [];
    public $students = [];

    public function mount($methodForm = 'registration', $course_id = null)
{
    $this->methodForm = $methodForm;
    $this->course_id = $course_id;
    $this->course = Course::find($this->course_id);

    $this->loadStudents();
}

public function updated($property)
{
    if ($this->methodForm === 'payment' && $property === 'student_id') {
        $this->loadCoursesForStudent();
    }
}

public function loadStudents()
{
    $user = auth()->user();

    $this->students = Student::query()
        ->when($this->methodForm === 'registration', function ($query) {
            $query->whereDoesntHave('registrations', function ($q) {
                $q->where('course_id', $this->course_id);
            });
        })
        ->when($this->methodForm === 'payment', function ($query) {
            $query->whereHas('registrations');
        })
        ->when($user->role !== 'admin', function ($query) use ($user) {
            $query->where('responsible_id', $user->responsible->id);
        })
        ->orderBy('name')
        ->get();
}

public function loadCoursesForStudent()
{
    if ($this->student_id) {
        $this->courses = Course::whereHas('registrations', function ($q) {
            $q->where('student_id', $this->student_id);
        })->get();
    } else {
        $this->courses = [];
    }
}

    public function save()
    {
        $this->validate([
            'student_id' => 'required|exists:students,id',
            'method' => 'required|in:cash,transfer',
            'payment_date' => 'required|date',
            'amount' => $this->methodForm === 'payment' ? 'required|numeric|min:0.01' : 'nullable',
            'course_id' => $this->methodForm === 'payment' ? 'required|exists:courses,id' : 'nullable',
        ]);

        if ($this->methodForm === 'registration') {
            $registration = Registration::create([
                'student_id' => $this->student_id,
                'course_id' => $this->course_id,
            ]);
        } else {
            $registration = Registration::where('student_id', $this->student_id)
                ->where('course_id', $this->course_id)
                ->firstOrFail();
        }

        $course = $registration->course;

        Payment::create([
            'method' => $this->method,
            'payment_date' => $this->payment_date,
            'amount' => $this->methodForm == 'registration' ? $course->price : $this->amount,
            'registration_id' => $registration->id,
            'description' => $this->description,
            'user_id' => \Auth::user()->id,
        ]);

        if ($this->methodForm === 'registration') {
            toastr()->success('Has inscrito a un estudiante con exito', ' ');

        } else {
            toastr()->success('Has registrado un pago con exito', ' ');
        }
        $this->reset(['student_id', 'course_id', 'method', 'payment_date', 'amount', 'description']);
        $this->loadStudents();
        $this->dispatch('saved');
    }

    public function render()
    {
        return view('livewire.registration.create');
    }
}
