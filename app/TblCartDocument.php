<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TblCartDocument extends Model
{
    protected $table = "cart_document";

    public $incrementing = false;

    protected $fillable = [
        'id',
        'status',
        'id_user',
        'id_document',
        'number',
        'created_at',
        'updated_at',
        'other'
    ];

    protected $hidden = [];
}
