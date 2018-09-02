<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class transaction extends Model
{
    //
    protected $fillable = [
        'fromname', 'toname', 'amount', 'status',
    ];
}
