<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'user';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'status',
        'role',
        'id_lecturer',
        'email',
        'full_name',
        'avatar',
        'phone',
        'short_introduction',
        'detail_introduction',
        'birthday',
        'money',
        'login_facebook',
        'facebook',
        'youtube',
        'created_at',
        'updated_at',
        'video'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'auth_key',
        'password',
        'password_reset_token',
        'remember_token'
    ];

    protected $timestamp = false;
}
