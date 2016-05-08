<?php
namespace App\Common;
use DB;
class WriteLink {
    public static function TestImage($url){
        
    }

    public function Link($tieude, $duongdan, $id){
        if(strlen(trim($duongdan))==0){return $this->MahoaChuoiKhongdau($id, $tieude);}
        return $this->MahoaChuoiKhongdau($id, $duongdan);
    }
    private function MahoaChuoiKhongdau($id, $duongdan){
        $duongdanx = mb_strtolower($duongdan, 'UTF-8');
        $coDau=array(
            'à','á','ạ','ả','ã','â','ầ','ấ','ậ','ẩ','ẫ','ă','ằ','ắ','ặ','ẳ','ẵ',
            'è','é','ẹ','ẻ','ẽ','ê','ề','ế','ệ','ể','ễ','ì','í','ị','ỉ','ĩ',
            'ò','ó','ọ','ỏ','õ','ô','ồ','ố','ộ','ổ','ỗ','ơ','ờ','ớ','ợ','ở','ỡ',
            'ù','ú','ụ','ủ','ũ','ư','ừ','ứ','ự','ử','ữ','ỳ','ý','ỵ','ỷ','ỹ',
            'đ',' ', 'q','w','e','r','t','y','u','i','o','p','a','s','d','f','g','h','j','k','l','z','x','c','v','b','n','m','1','2','3','4','5','6','7','8','9','0'
        );
        $khongdau = array(
            'a','a','a','a','a','a','a','a','a','a','a','a','a','a','a','a','a',
            'e','e','e','e','e','e','e','e','e','e','e','i','i','i','i','i',
            'o','o','o','o','o','o','o','o','o','o','o','o','o','o','o','o','o',
            'u','u','u','u','u','u','u','u','u','u','u','y','y','y','y','y',
            'đ','-', 'q','w','e','r','t','y','u','i','o','p','a','s','d','f','g','h','j','k','l','z','x','c','v','b','n','m','1','2','3','4','5','6','7','8','9','0'
        );
        $duongdan1 = explode('.html', $duongdanx); $kytu = str_replace($coDau,$khongdau,$duongdan1[0]);
        $x = '';for ($i = 0; $i < strlen($kytu); $i++) {if(in_array($kytu[$i], $khongdau)){$x.=$kytu[$i];}}
        return $this->XemxetURL($x, $id);
    }
    private function XemxetURL($url, $id){
        
        $urlcodinh  = array('updateweb.html','update.html','login.html','admin.html');
        $urlcodinhx = '?,?,?,?';
        for($i=0;;$i++){ 
            if($id==0){ $dk = 'url=? AND NOT(url IN ('.$urlcodinhx.'))'; $vals = array_merge(array($url.'.html'),$urlcodinh);}
            else{ $dk = 'url=? AND NOT(id=?) AND NOT(url IN ('.$urlcodinhx.'))'; $vals = array_merge(array($url.'.html',$id),$urlcodinh);}
            if(!DB::Select('SELECT id FROM page WHERE '.$dk,$vals)){return $url.'.html'; } 
            $url .= $this->Chuoingaunhien(); 
            if(strlen($url.'.html')>=250){$url = $this->Chuoingaunhien();}
        }
    }
    function Chuoingaunhien(){
        $kytu = "abcdefghijklmnopqrstuvwxyz0123456789";
        $kichthuoc = strlen($kytu); $chuoi = '';
        for($i=0; $i<6; $i++){ 
            $chuoi .= $kytu[rand(0, $kichthuoc - 1 )]; 
        }
        return $chuoi;
    }
}
