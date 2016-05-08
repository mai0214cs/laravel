<?php
namespace App\Http\Controllers;
use App\Common\LanguagePage;
use App\RoleAdmin;
class BaseController extends Controller {
    function __construct($id='') {
        $model = new \App\Http\Models\Model();
        $a = new LanguagePage(); 
        $a->defaultLanguage();
        RoleAdmin::TestRole($id); $setup=array();
        $result = $model->getDB->table('configadmin')->select('name', lang.'content')->whereIn('typeadmin',['',$id])->get();
        foreach ($result as $v) {
            $setup[$v->name] = $v->{lang.'content'};
        }
        if(\Session::get(lang.'guide'.$id)){
            $guide = $model->getDB->table('guideadmin')->select(lang.'title AS title', lang.'content AS content')->where('id',$id)->first();
            if(isset($guide->title)){
                \Session::set(lang.'guide'.$id,'<div class="box box-primary"><div class="box-header with-border"><h3 class="box-title">'.$guide->title.'</h3></div><div class="box-body">'.$guide->content.'</div></div>');
            }else{
                \Session::set(lang.'guide'.$id, '');
            }
        }
        
        return $setup;
    }
}
