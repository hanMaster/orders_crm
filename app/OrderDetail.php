<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = [
        'order_item', 'order_id', 'ed_id', 'quantity', 'delivery_date', 'attached_file'
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
}
