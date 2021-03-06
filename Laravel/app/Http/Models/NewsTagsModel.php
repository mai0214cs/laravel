<?php
namespace App\Http\Models;
use DB;
class NewsTagsModel extends Model{
    private $titleadmin=array();
    public function __construct($setup) {
        parent::__construct();
        $this->titleadmin = $setup;
    }

    /*public function __construct($setup) {
        
    }*/
    public function data(){
        //print_r($this->titleadmin); exit();
        return array($this->titleadmin, $this->getDB->table('tags')->select('id', lang.'name')->where('typepage0',0)->orderBy('id','desc')->get());
    }
    public function insert($val){
        return $this->getDB->table('tags')->insert([lang.'name'=>$val, 'typepage0'=>0])>0?TRUE:FALSE;
    }
    public function edit($id, $val){
        return $this->getDB->table('tags')->where('id',$id)->where('typepage0',0)->update([lang.'name'=>$val])>0?TRUE:FALSE;
    }
    public function delete($ids){
        $count = 0;
        foreach ($ids as $id) {
            $count = $this->getDB->table('tags')->where('id',$id)->where('typepage0',0)->delete()>0?$count+1:$count;
        }
        return $count;
    }
}
