<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TblExam extends Model
{
    protected $table = 'exam';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'status',
        'name',
        'name_briefly',
        'explain_name',
        'id_class',
        'id_subject',
        'id_topic',
        'id_level',
        'id_user_post',
        'number_of_questions',
        'list_answer',
        'time',
        'rating',
        'joined',
        'created_at',
        'updated_at'
    ];

    protected $hidden = [];

    protected $timestamp = false;
}
