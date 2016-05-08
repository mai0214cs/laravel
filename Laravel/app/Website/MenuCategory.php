<?php
namespace App\Website;
class MenuCategory extends Model {
    public function index($type, $parent){
        $data = $this->getDB->table('page')->select('id', 'id_category', lang.'name AS name', 'url')->where(lang.'name','<>','')->where(lang.'status',1)->where('typepage',$type)->get();
        
    }
}
