<?php
namespace App\Common;
use DB;
class LanguagePage {
    public function __construct() {
        
    }
    public function defaultLanguage(){
        $a = \Session::get('Language'); 
        if(!isset($a->code)){
            $data = DB::select('SELECT code, code_money, natio_money FROM lang WHERE lang.default=1');
            \Session::set('Language',$data[0]);
            $this->viewLanguage(); 
        }
        $this->setLanguageMoney();
    }
    private function setLanguageMoney(){
        $a = \Session::get('Language');
        define('lang', $a->code);
        define('code_money', $a->code_money);
        define('natio_money', $a->natio_money);
    }
    public function setLanguage($code){
        $data = DB::select("SELECT code, code_money, natio_money FROM lang WHERE code=?",array($code));
        if(!$data){return;}
        \Session::set('Language',$data[0]);
        $this->viewLanguage(); 
    }
    private function viewLanguage(){
        $data = DB::select('SELECT code, '.\Session::get('Language')->code.'name AS titlelanguage FROM lang');
        if(count($data)==1){$rs = '';}
        else{
            $rs='<select onchange="ChangeLanguage(this.value)">';
            foreach ($data as $v) {
                $rs.='<option '.(\Session::get('Language')->code==$v->code?'selected="selected"':'').' value="'.$v->code.'">'.$v->titlelanguage.'</option>';
            }
            $rs.='</select>';
        }
        \Session::set('ViewLanguage',$rs);
    }
}