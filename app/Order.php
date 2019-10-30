<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'status_id', 'starter_id'
    ];

    public function bo(){
        return $this->belongsTo(BuildObject::class, 'object_id');
    }

    public function status(){
        return $this->belongsTo(Status::class);
    }

    public function items(){
        return $this->hasMany(OrderDetail::class);
    }

    public function comments(){
        return $this->hasMany(OrderComment::class)->orderBy('created_at', 'desc');
    }

}
