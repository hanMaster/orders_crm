<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = [
        'order_item', 'order_id', 'ed_id', 'quantity', 'date_plan', 'attached_file', 'comment'
    ];

    public function order(){
        return $this->belongsTo(Order::class);
    }

    public function ed(){
        return $this->belongsTo(Ed::class, 'ed_id');
    }

    public function executor(){
        return $this->belongsTo(User::class, 'executor_id');
    }

    public function logs(){
        return $this->hasMany(Log::class, 'order_details_id');
    }

    public function status(){
        return $this->belongsTo(LineStatus::class, 'line_status_id');
    }
}
