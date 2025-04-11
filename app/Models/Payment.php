<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['method', 'payment_date', 'amount', 'registration_id', 'description'];

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }
}
