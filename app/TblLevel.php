<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TblLevel extends Model
{
    protected $table = 'level';
    public $incrementing = false;
    protected $fillable = [
        'id',
        'slug',
        'name',
    ];

    protected $hidden = [];

    protected $timestamp = false;
}
