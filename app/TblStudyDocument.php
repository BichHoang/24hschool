<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TblStudyDocument extends Model
{
    protected $table = 'study_document';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'status',
        'id_lecturer',
        'id_user_post',
        'id_class',
        'id_subject',
        'name',
        'image',
        'introduce',
        'price',
        'sale',
        'bought',
        'document',
        'slug',
        'created_at',
        'updated_at',
        'seen'
    ];

    protected $hidden = [];
}
