<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TblBook extends Model
{
    protected $table = 'book';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'status',
        'id_lecturer',
        'id_user_post',
        'name',
        'publication_date',
        'slug',
        'author',
        'previous_image',
        'rear_image',
        'ebook',
        'introduce',
        'price',
        'sale',
        'bought',
        'seen',
        'pages',
        'allow',
        'created_at',
        'updated_at'
    ];

    protected $hidden = [];

}
