<?php


namespace App\Services;

use App\BuildObject;
use App\Order;

class ActiveBuildObjects
{
    public static function getActiveObjects()
    {
        return BuildObject::select('id', 'name')
            ->whereIn('id', Order::select('object_id')->groupBy('object_id'))
            ->OrderBy('name')
            ->get();
    }
}


