<?php
namespace App\Http\Models;
use DB;
class Model {
    public $getDB=null;
    function __construct() {
        $this->getDB = DB::connection('mysql');
    }
    function getPriceProduct($cost, $price, $promotion, $goldtime){
        $price_Sale = 0; $price_Cost = 0; $time0 = time();
        if($goldtime[0]>0){
            $time1 = strtotime($goldtime[1]);
            $time2 = strtotime($goldtime[2]);
            if($time0-$time2<0&&$time0-$time1>0){ $price_Sale = $goldtime; } 
        }elseif($promotion[0]>0){
            $date1 = strtotime($promotion[1]);
            $date2 = strtotime($promotion[2]);
            if($time0-$date2<0&&$time0-$date1>0){ $price_Sale = $promotion[0]; }
        }elseif($price>0){ $price_Sale = $price;}else{ $price_Sale = $cost;} 
        if($price>0){ $price_Cost = $price; }else{$price_Cost = $cost;}
        return array('sale'=>$price_Sale, 'cost'=>$price_Cost);
    }
}
