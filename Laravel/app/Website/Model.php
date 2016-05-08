<?php
namespace App\Website;
use DB;

class Model{
    public $getDB=null;
    function __construct() {
        $this->getDB = DB::connection('mysql');
            
    }
    public function Show($getDB){
        return $getDB->where(lang.'name','<>','');
    }
    public function PageError(){
        echo 'Loi trang khong ton tai.'; exit();
    }
    public static function Image($url){
        return is_file(trim($url,'/'))?$url:'/Lib/images/image.gif'; 
    }
    public static function Language($string){
        $lang = \Session::get('LANGUAGE');
        return $lang[$string];
    }
    public static function SysPage($string){
        $config = \Session::get('CONFIG');
        return $config[$string];
    }
    public static function ViewPrice($price, $title='', $class=''){
        $counttp = is_numeric(Model::Language('Số lượng số thập phân'))?(int) Model::Language('Số lượng số thập phân'):0;
        if(round($price*natio_money, $counttp)==0){
            return '<div '.($class!=''?'class="'.$class.'"':'').'>'.($title!=''?'<span class="title">'.Model::Language($title).'</span>':'').'<em >'.Model::Language('Giá liên hệ').'</em></div>';
        }
        $money = number_format($price, $counttp, Model::Language('Dấu phân cách phần thập phân'), Model::Language('Dấu phân cách phần nghìn'));
        $show = Model::Language('Ký hiệu tiền tệ trước - sau')==1?natio_money.' '.$money:$money.' '.natio_money;
        return '<div '.($class!=''?'class="'.$class.'"':'').'>'.($title!=''?'<span class="title">'.Model::Language($title).'</span>':'').'<em >'.$show.'</em></div>';
    }
    public function priceVal($price){
        $counttp = is_numeric(Model::Language('Số lượng số thập phân'))?(int) Model::Language('Số lượng số thập phân'):0;
        return round($price*natio_money, $counttp);
    }

    public function getPrice($price, $promotion, $goldtime){
        $pricesale = $price;
        if($goldtime[0]>0){
            $time1 = strtotime($goldtime[1]); $time2 = strtotime($goldtime[2]); $time = time();
            if($time2>$time&&$time>$time1){$pricesale = $goldtime[0];} // Xem xét giá vàng
        }elseif($promotion[0]>0){
            $date1 = strtotime($goldtime[1]); $date2 = strtotime($goldtime[2]); $date = time(new Date());
            if($date2>$date&&$date>$date1){$pricesale = $promotion[0];} // Xem xét giá khuyến mại
        }
        return array('PriceNew'=>$pricesale, 'PriceOld'=>$price);
    }
}
