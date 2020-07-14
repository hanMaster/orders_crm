<?php


namespace App\Services;


use App\OrderDetail;
use Carbon\Carbon;

class PatchDates
{
    public static function patch(){
        $ods = OrderDetail::all();
        foreach ($ods as $od){
            $od->dt_plan = Carbon::parse($od->date_plan)->format('Y.m.d');
            $od->save();
        }
    }
}
