<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name', 'last_name', 'birth_date', 'responsible_id'];

    public function responsible()
    {
        return $this->belongsTo(Responsible::class);
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public static function studentsAvailable($courseId)
    {
        $user = auth()->user();

        return self::query()
            ->whereDoesntHave('registrations', function ($query) use ($courseId) {
                $query->where('course_id', $courseId);
            })
            ->when($user->role !== 'admin', function ($query) use ($user) {
                $query->where('responsible_id', $user->responsible->id);
            })
            ->orderBy('name')
            ->get();
    }
}
