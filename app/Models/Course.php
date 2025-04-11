<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name', 'description', 'price', 'duration', 'academy_id'];

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function communications()
    {
        return $this->hasMany(Comunication::class);
    }

    public function academy()
    {
        return $this->belongsTo(Academy::class);
    }
}
