<?php
namespace App\Common;
use DB;
class SelectList {
    public static function Tags($type){
        return DB::table('tags')->select('id', lang.'name')->where('typepage0',$type)->get();
    }
    public static function TestTags($idtags_a, $type){
        $mang = array();
        foreach ($idtags_a as $v) {
            if(DB::table('tags')->where('id',$v)->where('typepage0',$type)->count()>0){$mang[]=$v;}
        }
        return implode(',', $mang);
    }

    public static function GetTagsPage($idtags_s, $onlyid=FALSE){
        if($idtags_s==''){return array();}
        $data = DB::select('SELECT id, '.lang.'name FROM tags WHERE id IN('.$idtags_s.')');
        if(!$onlyid){return $data;} $mang = array();
        foreach ($data as $v) {$mang[] = $v->id;} return $mang;
    }
    
    public static function MenuCategory($type=5, $parent=0){
        $data = DB::table('page')->select('id AS idpage','id_category AS idcategory',lang.'name AS namepage')->where('typepage',$type)->orderBy('order','ASC')->orderBy('id','DESC')->get();
        $menu = new UpdateMenu();
        return $menu->ListMenu($data, $parent, '');
    }
    
    public static function VPage($type){
        return DB::table('v_page')->select('id','name')->where('typepage',$type)->orderBy('order','ASC')->orderBy('id','ASC')->get();
    }

    

    // Xuất danh sách nhà sản xuất
    public static function Procedure(){
        return DB::table('page')->select('id AS id',lang.'name AS name')->where('typepage',8)->orderBy('order','ASC')->orderBy('id','DESC')->get();
    }
}
