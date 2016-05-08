<?php
namespace App\Common;
class CheckDateTime {
    public static function CheckDate($data){
        $ex = explode('/', $data); if(count($ex)!=3){return FALSE;}
        return checkdate($ex[0],$ex[1],$ex[2]);
    }
    public static function CompareDate($begin, $end){
        
    }
}
