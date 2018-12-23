<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TblCartBook extends Model
{
    protected $table = "cart_book";

    public $incrementing = false;

    protected $fillable = [
        'id',
        'status',
        'id_user',
        'id_book',
        'number',
        'created_at',
        'updated_at',
        'other'
    ];

    protected $hidden = [];
}
