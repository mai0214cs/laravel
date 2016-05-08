<?php
namespace App;
class RoleAdmin {
    public static function TestRole($idrole){
        $a = \Session::get('Role');
        if(!$a){header('Location: /admin/login');exit();}
        if($idrole==0){return TRUE;}
        if($a[0]==0){return TRUE;}
        if(in_array($idrole, $a)){return TRUE;}
        header('Location: /admin/login');exit();
    }
}
