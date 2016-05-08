<?php
namespace App\Website;
class ModulMenuNewsCategory extends Model {
    public function index(){
        
    }
    public function ListMenu($data, $parent=0, $level=0){
        $menu_tmp = array(); $content='';
        foreach ($data as $key => $item){
            if ($item->idcategory == $parent){
                $menu_tmp[] = $item; unset($data[$key]);
            }
        }
        if(count($menu_tmp)>0){
            $content .= '<ul class="level'.$level.'">';
        }
        if($menu_tmp){
            foreach ($menu_tmp as $item){
                $content .= '<li class="level'.$level.'">';
                    $content .= '<a href="/'.(lang==''?'':lang.'/').$item->url.'">'.$item->name.'</a>';
                    $content .= $this->ListMenu($data, $item->id,$level+1);
                $content .= '</li>';
            }
        }
        if(count($menu_tmp)>0){$content .= '</ul>';}
        return $content;
    }
}
