<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrationStep extends Model
{
    use HasFactory;

    protected $table = 'registration_steps';

    protected $fillable = [
        'data',
        'current_step',
    ];

    protected $casts = [
        'data' => 'array',
    ];
}
