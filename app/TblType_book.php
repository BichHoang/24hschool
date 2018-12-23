<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TblType_book extends Model
{
    protected $table = 'type_book';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'name',
        'slug'
    ];

    protected $hidden = [];

    protected $timestamp = false;
}
