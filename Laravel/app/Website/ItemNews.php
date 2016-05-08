<?php
namespace App\Website;
class ItemNews extends Model {
    public function __construct() {
        parent::__construct();
    }
    private $fields = array(0=>'{Tiêu đề}', 1=>'{URL Hình ảnh}', 2=>'{Mô tả}', 3=>'{Danh mục}', 4=>'{URL Bài viết}', 5=>'{Danh sách Tags}', 6=>'{Ngày đăng}', 7=>'{Người đăng}', 8=>'{Ngày sửa}', 9=>'{Người sửa}');
    private $listdata = NULL;
    private $prefix = NULL;
    public function index($id_type, $wheres, $orders, $limit=array(), $categories=array()){
        //$this->getDB
        $news = $this->getDB->table('page')->select('id', 'id_category',lang.'name AS name',lang.'avatar AS avatar',lang.'description AS description','id_category','url','ids_tags','views','add_date','add_name','edit_date','edit_name')
                ->where('typepage',3)->where(lang.'name','<>','');
        foreach ($wheres as $v) { $news->where($v['field'], $v['compare'], $v['value']); }
        foreach ($orders as $v) { $news->orderBy($v['field'], $v['order']); }
        if(count($limit)==2){ $news->take($limit['count'])->skip($limit['page']*$limit['count']); }
        if(count($categories)>0){ $news->whereIn('id_category', $categories); }
        $item = $this->getDB->table('v_item')->select('ids_fields','content')->where('id',$id_type)->where('typepage0',0)->first(); if(!$item->content){return;}
        
        $data = $news->get(); if(!isset($data[0])){return;}
        $index_items = explode(',', $item->ids_fields);
        $list_method = array(); $list_fields = array();
        foreach ($index_items as $v){ if(isset($this->fields[$v])){ $list_method[] = 'Item'.$v; $list_fields[] = $this->fields[$v]; }}
        $content = ''; $this->prefix = lang==''?'/':'/'.lang.'/';
        foreach ($data as $v0) {
            $data_list = array(); $this->listdata = $v0;
            foreach ($list_method as $v) { $data_list[] = $this->$v(); }
            $content .= str_replace($list_fields, $data_list, $item->content);
        }
        return $content;
    }
    private function Item0(){ 
        return $this->listdata->name; 
    } // Tiêu đề Bài viết
    private function Item1(){ 
        return Model::Image($this->listdata->avatar);
    } // Hình ảnh bài viết
    private function Item2(){ 
        return $this->listdata->description;
    } // Mô tả bài viết
    private function Item3(){
        $image = $this->getDB->table('page')->select(lang.'name AS name', 'url')->where('id',$this->listdata->id_category)->where('typepage',2)->where(lang.'name','<>','')->first();
        if(isset($image->url)){
            return '<a href="'.($this->prefix).$image->url.'">'.$image->name.'</a>';
        }
    } // Danh mục tin tức
    private function Item4(){
        return $this->prefix.$this->listdata->url;
    } // URL tin tức
    private function Item5(){
        $tags = $this->getDB->table('tags')->select('id',lang.'name AS name')->whereIn('id',  explode(',', $this->listdata->ids_tags))->where('typepage0',0)->get();
        if(!isset($tags[0])){return;} $content = '';
        foreach ($tags as $tag){ $content .= '<li><a href="/tags-tin-tuc.html?tags='.$tag->id.'">'.$tag->name.'</a></li>'; }
        return '<ul class="tag">'.$content.'</ul>';
    } // Danh sách Tags
    private function Item6(){
        return date_format(date_create_from_format("Y-m-d H:i:s", $this->listdata->add_date), 'H:i, d-m-Y');
    } // Ngày đăng
    private function Item7(){
        $name = $this->getDB->table('useradmin')->select('fullname')->where('id', $this->listdata->add_name)->first();
        return isset($name->fullname);
    } // Người đăng
    private function Item8(){
        return date_format(date_create_from_format("Y-m-d H:i:s", $this->listdata->edit_date), 'H:i, d-m-Y');
    } // Ngày sửa
    private function Item9(){
        $name = $this->getDB->table('useradmin')->select('fullname')->where('id', $this->listdata->edit_name)->first();
        return isset($name->fullname);
    } // Người sửa
}
