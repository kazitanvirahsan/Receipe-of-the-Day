<?php
namespace Receipe\Common;
class DateFunc
{
    public static function StringToDateObj($dt) {
        $expiry_date_arr = explode('/', $dt);
        $expiry_date = new \DateTime();
        $expiry_date->setDate((int)$expiry_date_arr[2], (int)$expiry_date_arr[1], (int)$expiry_date_arr[0]);
        return $expiry_date;
    }
}
