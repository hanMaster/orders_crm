<?php


namespace App\Services;

use http\Exception;

class DayOffChecker
{
    public static function isDayOff($date)
    {
        $year = \Carbon\Carbon::parse($date)->format('Y');
        $month = \Carbon\Carbon::parse($date)->format('m');
        $day = \Carbon\Carbon::parse($date)->format('d');

        $url = "https://isdayoff.ru/api/getdata?year={$year}&month={$month}&day={$day}";

        try {
            return file_get_contents($url);
        } catch (Exception $e) {
        }
        return null;
    }

    public static function getNextWorkDay($date)
    {
        if (self::isDayOff($date) == "0") {
            return $date;
        } else {
            do {
                $date->addDay();
            } while (self::isDayOff($date) == "1");
            return $date;
        }
    }


}
