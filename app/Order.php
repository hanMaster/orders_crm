<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

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
        return $this->hasMany(OrderDetail::class)->orderBy('dt_plan', 'asc');
    }

    public function execItems(){
        return $this->hasMany(OrderDetail::class)->where('executor_id', auth()->id())->orderBy('dt_plan', 'asc');
    }

    public function comments(){
        return $this->hasMany(OrderComment::class)->orderBy('created_at', 'desc');
    }

    public function starter(){
        return $this->belongsTo(User::class, 'starter_id');
    }

    public function logs(){
        return $this->hasMany(Log::class, 'subject_id')->where('isLine', false)->orderBy('created_at', 'desc');
    }

}
