<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\ComunicationMail;

class Comunication extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'message', 'date_email', 'course_id', 'min_age', 'max_age'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public static function sendEmails($comunication)
    {
        Mail::to('edvfjob@gmail.com')->send(new ComunicationMail($comunication->title, $comunication->message, route('login')));

        if (!$comunication) {
            return;
        }

        $minAge = $comunication->min_age;
        $maxAge = $comunication->max_age;

        $registrations = $comunication->course->registrations()->with('student.responsible')->get();

        foreach ($registrations as $registration) {
            $student = $registration->student;
            $responsible = $student->responsible;

            if (!$responsible || !$responsible->email) {
                continue;
            }

            $studentAge = Carbon::parse($student->birth_date)->age;

            if (!is_null($minAge) && is_null($maxAge) && $studentAge < $minAge) {
                continue;
            }
            if (is_null($minAge) && !is_null($maxAge) && $studentAge > $maxAge) {
                continue;
            }
            if (!is_null($minAge) && !is_null($maxAge)) {
                if ($studentAge < $minAge || $studentAge > $maxAge) {
                    continue;
                }
            }

            Mail::to('edvfjob@gmail.com')->send(new ComunicationMail($comunication->title, $comunication->message, route('login')));
        }
    }
}
