<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'status_id', 'starter_id', 'name'
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

    public function execItems(){
        return $this->hasMany(OrderDetail::class)->where('executor_id', auth()->id());
    }

    public function comments(){
        return $this->hasMany(OrderComment::class)->orderBy('created_at', 'desc');
    }

    public function starter(){
        return $this->belongsTo(User::class, 'starter_id');
    }
}
