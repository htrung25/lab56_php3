<?php

namespace App\Models;

// use Laravel\Sanctum\HasApiTokens;  ← XÓA DÒNG NÀY
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable; // ← Chỉ giữ lại Notifiable là đủ

    protected $fillable = [
        'fullname',
        'username',
        'email',
        'password',
        'avatar',
        'role',
        'active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'active' => 'boolean',
        'role'   => 'string',
    ];
}