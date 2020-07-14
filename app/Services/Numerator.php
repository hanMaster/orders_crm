<?php


namespace App\Services;
use App\Order;

class Numerator
{
    public static function numerate(Order $order){
        $i = 1;
        foreach ($order->items as $item){
            $item->idx = $i++;
            $item->save();
        }
    }

}
