<?php
namespace App\Website;
class PageNewsCategory extends Model{
    private $data;    private $viewcategory;
    private $fields = array(
        0=>'{Tiêu đề}', 1=>'{Mô tả}', 2=>'{URL Hình ảnh}', 3=>'{URL Page}', 
        4=>'{Danh sách tin tức}', 5=>'{Danh mục tin tức}', 6=>'{Phân trang}'
    );
    public function index($content, $item, $item_productnews){
        $this->data = \Session::get('PAGE'); $this->viewcategory = $item_productnews; 
        $this->getPage(); $fields = array(); $vals = array(); 
        foreach ($item as $v) {
            if(!isset($this->fields[$v])){continue;} 
            $fields[] = $this->fields[$v]; 
            $vals[] = $this->{'Info'.$v}();
        }
        return str_replace($fields, $vals, $content);
    }
    private function Info0(){
        return $this->data->name;
    } // Tiêu đề danh mục
    private function Info1(){
        return $this->data->description;
    }// Mô tả danh mục
    private function Info2(){
        return \App\Common\ReturnImage::Image($this->data->avatar);
    }// URL Hình ảnh
    private function Info3(){
        return (lang=='')?'/'.$this->data->url:'/'.lang.'/'.$this->data->url;
    }// URL Page
    private function Info4(){
        $list = new ItemNews();
        return $list->index(
            $this->viewcategory[3],
            array(), 
            array(),
            array('count'=>$this->count, 'page'=>$this->page-1),
            $this->listid
        );
    } // Danh sách tin tức thuộc danh mục
    private function Info5(){
        $data = $this->getDB->table('page')->select('id', 'id_category AS idcategory', lang.'name AS name', 'url')->where('typepage',2)->where(lang.'status',1)->where(lang.'name','<>','')->orderBy('id_category','ASC')->orderBy('order','DESC')->orderBy('id','DESC')->get();
        $menu = new ModulMenuNewsCategory();
        return $menu->ListMenu($data, $this->data->id, 0);
    } // Danh mục tin tức con của danh mục
    private function Info6(){
        $totalpage = ceil($this->total/$this->count); if($totalpage<=1){return '';} 
        $current = $this->page; $url = '/'.(lang==''?'':lang.'/').$this->data->url.'?page='; $begin=1; $end=$totalpage;
        $content = '<nav><ul class="pagination">';
        if($current>1){
            $content .= '<li><a href="'.$url.'1" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
        }
        if($current>3){$begin = $current - 3;}
        if($current<$totalpage-3){$end = $current+3;}
        if($totalpage<=5){$end = $totalpage;}
        for ($i = $begin; $i <= $end; $i++) {
            $content .= '<li><a '.($i==$current?'class="action"':'href="'.$url.$i.'"').'>'.$i.'</a></li>';
        }
        if($current<$totalpage){
            $content .= '<li><a href="'.$url.$totalpage.'" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
        }
        $content .= '</ul></nav>';
        return $content;
    } // Phân trang danh mục tin tức
    /* CÀI ĐẶT THÔNG SỐ TÌM KIẾM, PHÂN TRANG */
    private $key; private $id; private $page; private $count; private $total; private $listid;
    private function getPage(){
        $this->key  = isset($_GET['key'])?(trim($_GET['key']=='')?'':trim($_GET['key'])):'';
        $this->id   = $this->data->id;
        $data = $this->getDB->table('page')->select('id AS idpage','id_category AS idcategory')->where('typepage',2)->where(lang.'name','<>','')->where(lang.'status',1)->get();
        if(!isset($this->data->add_date)){
            $menu = new \App\Common\UpdateMenu();
            $this->listid = $menu->ListId($data, $this->data->id, ''); $this->listid[] = $this->data->id;
        }else{
            $this->listid = array();
        }
        $this->page = isset($_GET['page'])?(int) $_GET['page']:1;
        $this->count = Model::SysPage('Số lượng Tin tức trang Danh mục');
        $this->total = $this->getDB->table('page')->whereIn('id_category', $this->listid)->where('typepage',3)->where(lang.'name','<>','')->where(lang.'status',1)->count();
    } 
}