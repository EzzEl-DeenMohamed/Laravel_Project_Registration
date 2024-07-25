<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class DraftUser extends Authenticatable
{
    use HasFactory, Notifiable;
    // Specify the table associated with the model
    protected $table = 'draftuser';

    // Specify which attributes are mass assignable
    protected $fillable = [
        'full_name',
        'user_name',
        'user_type',
        'birthdate',
        'phone',
        'address',
        'email',
        'password',
        'current_status',
        'image_url'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [

        ];
    }
}
