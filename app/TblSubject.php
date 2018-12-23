<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TblSubject extends Model
{

    protected $table = 'subject';
    public $incrementing = false;
    protected $fillable = [
        'id',
        'name',
        'slug'
    ];

    protected $hidden = [];

    protected $timestamp = false;
}
