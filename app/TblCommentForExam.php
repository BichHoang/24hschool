<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TblCommentForExam extends Model
{
    protected $table = 'comment_for_exam';
    public $incrementing = false;
    protected $fillable = [
        'id',
        'status',
        'id_lecturer',
        'id_exam',
        'comment',
        'created_at',
        'updated_at'
    ];

    protected $hidden = [];

    protected $timestamp = false;
}
