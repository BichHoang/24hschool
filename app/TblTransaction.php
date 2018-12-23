<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TblTransaction extends Model
{
    protected $table = 'transaction';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'status',
        'type_payment',
        'id_user',
        'item',
        'phone',
        'email',
        'address',
        'customer_name',
        'note',
        'price',
        'created_at',
        'updated_at',
        'code',
        'type_item',
        'type_transaction',
        'other'
    ];

    protected $hidden = [];
}
