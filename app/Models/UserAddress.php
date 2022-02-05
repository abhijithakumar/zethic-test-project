<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class UserAddress extends User
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'building_no',
        'street_name',
        'user_id',
        'city',
        'country',
        'state',
        'pincode',
    ];
}
