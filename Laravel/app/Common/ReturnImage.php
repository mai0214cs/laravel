<?php
namespace App\Common;
class ReturnImage {
    public static function Image($url){
        return is_file(trim($url,'/'))?$url:'/Lib/images/image.gif'; 
    }
}
