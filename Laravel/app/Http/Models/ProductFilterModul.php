<?php
namespace App\Http\Models;
class ProductFilterModul extends Model {
    private $titleadmin=array();
    public function __construct($setup) {
        parent::__construct();
        $this->titleadmin = $setup;
    }
    public function getData(){
        $group = $this->getDB->table('group_attribute')->select('id', lang.'name AS name', 'order', 'type')->where('id','>',12)->orderBy('order', 'ASC')->orderBy('id', 'DESC')->get();
        $count = count($group); $item = null;
        for ($i = 0; $i < $count; $i++) {
            $item[$i] = $this->getDB->table('attribute')->select('id',lang.'value AS value','order')->where('id_group',$group[$i]->id)->orderBy('order', 'ASC')->orderBy('id', 'DESC')->get();
        }
        return array($this->titleadmin, $group, $item);
    }
    
    public function addgroup($data){
        $mang = [
            lang.'name'=>$data['g_name'], 
            'order'=>$data['g_order'], 
            'type'=>$data['g_type']
        ];
        $count = $this->getDB->table('group_attribute')->insert($mang);
        return $count>0?TRUE:FALSE;
    }
    public function editgroup($data){
        $mang = [
            lang.'name'=>$data['g_name'], 
            'order'=>$data['g_order'], 
            'type'=>$data['g_type']
        ];
        $count = $this->getDB->table('group_attribute')->where('id',$data['g_id'])->update($mang);
        return $count>0?TRUE:FALSE;
    }
    public function deletegroup($id){
        $this->getDB->table('attribute')->where('id_group',$id)->delete();
        $count = $this->getDB->table('group_attribute')->where('id',$id)->where('id','>',12)->delete();
        return $count>0?TRUE:FALSE;
    }
    public function additem($data){
        $mang = [
            lang.'value'=>$data['i_value'], 
            'id_group'=>$data['i_group'], 
            'order'=>$data['i_order']
        ];
        $count = $this->getDB->table('attribute')->insert($mang);
        return $count>0?TRUE:FALSE;
    }
    public function edititem($data){
        $mang = [
            lang.'value'=>$data['i_value'], 
            'order'=>$data['i_order']
        ];
        $count = $this->getDB->table('attribute')->where('id',$data['i_id'])->edit($mang);
        return $count>0?TRUE:FALSE;
    }
    public function deleteitem($id){
        $count = $this->getDB->table('attribute')->where('id',$id)->delete();
        return $count>0?TRUE:FALSE;
    }
}
