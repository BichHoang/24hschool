<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TblTopic extends Model
{
    protected $table = 'topic';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'status',
        'name',
        'slug',
        'created_at',
        'updated_at'
    ];

    protected $hidden =[];
}
