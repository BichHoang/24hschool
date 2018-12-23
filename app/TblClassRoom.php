<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TblClassRoom extends Model
{
    protected $table = 'class_room';
    public $incrementing = false;
    protected $fillable = [
        'id',
        'name',
        'slug'
    ];

    protected $hidden = [];

    protected $timestamp = false;
}
