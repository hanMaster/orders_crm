<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = [
        'subject_id', 'user_id', 'message', 'isLine'
    ];
    public function item(){
        return $this->belongsTo(OrderDetail::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
