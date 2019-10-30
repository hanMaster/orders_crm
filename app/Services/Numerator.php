<?php


namespace App\Services;
use App\OrderDetail;
use App\Order;

class Numerator
{
    public static function numerate(Order $order){
        $items = $order->items;
        $i = 1;
        foreach ($order->items as $item){
            $item->idx = $i++;
            $item->save();
        }
    }

}
