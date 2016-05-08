<?php
namespace App\Website;
class PageProductCategory extends Model {
    private $fields = array(
        0=>'{Tiêu đề}', 1=>'{Mô tả}', 2=>'{URL Hình ảnh}', 3=>'{URL Danh mục}',
        4=>'{Danh sách Sản phẩm}', 5=>'{Phân trang Sản phẩm}', 6=>'{Sắp xếp Sản phẩm}',7=>'{Menu Danh mục sản phẩm}'
    );
    private $data; private $viewcategory; 
    public function index($content, $item, $item_productnews){
        $this->data = \Session::get('PAGE'); $this->viewcategory = $item_productnews;
        $this->getPage(); $fields = array(); $datas = array();
        foreach ($item as $v) {
            if(!isset($this->fields[$v])){continue;}
            $fields[] = $this->fields[$v];
            $datas[] = $this->{'Info'.$v}();
        }
        return str_replace($fields, $datas, $content);
    } 
    private function Info0(){
        return $this->data->name;
    } // Tiêu đề
    private function Info1(){
        return $this->data->description;
    } // Mô tả
    private function Info2(){
        return Model::Image($this->data->avatar);
    } // URL Hình ảnh
    private function Info3(){
        return $this->data->url;
    } // URL Danh mục
    private function Info4(){
        $list = new ItemProduct();
        return $list->index($this->viewcategory[0], $this->listid, $this->where, array($this->order), array('count'=>$this->count, 'page'=>$this->page-1));
    } // Danh sách Sản phẩm
    private function Info5(){
        $totalpage = ceil($this->total/$this->count); if($totalpage<=1){return '';} 
        $current = $this->page; $url = '/'.(lang==''?'':lang.'/').$this->data->url.'?page='; $begin=1; $end=$totalpage;
        $content = '<nav><ul class="pagination">';
        $add = ($this->key==''?'&key='.$this->key:'').(isset($_GET['filter'])?'&filter='.$_GET['filter']:'');
        if($current>1){
            $content .= '<li><a href="'.$url.'1'.$add.'" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
        }
        if($current>3){$begin = $current - 3;}
        if($current<$totalpage-3){$end = $current+3;}
        if($totalpage<=5){$end = $totalpage;}
        for ($i = $begin; $i <= $end; $i++) {
            $content .= '<li><a '.($i==$current?'class="action"':'href="'.$url.$i.$add.'"').'>'.$i.'</a></li>';
        }
        if($current<$totalpage){
            $content .= '<li><a href="'.$url.$totalpage.$add.'" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
        }
        $content .= '</ul></nav>';
        return $content;
    } // Phân trang Sản phẩm
    private function Info6(){
        $title = array('Mặc định','Tiêu đề A-Z','Tiêu đề Z-A','Giá bán tăng','Giá bán giảm','Sản phẩm mới','Sản phẩm cũ','Sản phẩm bán chạy');
        $content = '<div class="OrderProduct">
            <span class="title">Sắp xếp</span>
            <span class="content">
                <select onchange="ProductDirectPage()" name="orderProduct">';
                for ($i = 0; $i < 8; $i++) { $content .= '<option '.($this->orderid==$i?'selected="selected"':'').' value="'.$i.'">'.$title[$i].'</option>'; }
                $content .= '</select>
            </span>
        </div>';
        return $content;
    } // Sắp xếp Sản phẩm
    private function Info7(){
        $data = $this->getDB->table('page')->select('id', 'id_category AS idcategory', lang.'name AS name', 'url')->where('typepage',5)->where(lang.'status',1)->where(lang.'name','<>','')->orderBy('id_category','ASC')->orderBy('order','DESC')->orderBy('id','DESC')->get();
        $menu = new ModulMenuNewsCategory();
        return $menu->ListMenu($data, $this->data->id, 0);
    } // Menu Danh mục Sản phẩm
    /* CÀI ĐẶT TÌM KIẾM PAGE */
    private $key; private $id; private $page; private $count; private $total; private $listid;
    private function getPage(){
        $this->key  = isset($_GET['key'])?(trim($_GET['key']=='')?'':trim($_GET['key'])):'';
        if($this->key!=''){
            $this->where[] = array('field'=>'a.'.lang.'name', 'compare'=>'LIKE', 'value'=>'%,'.$this->key.',%');
        }
        $this->id   = $this->data->id;
        $data = $this->getDB->table('page')->select('id AS idpage','id_category AS idcategory')->where('typepage',5)->where(lang.'name','<>','')->where(lang.'status',1)->get();
        if(!isset($this->data->add_date)){
            $menu = new \App\Common\UpdateMenu();
            $this->listid = $menu->ListId($data, $this->data->id, ''); $this->listid[] = $this->data->id;
        }else{ $this->listid = array(); }
        $this->page = isset($_GET['page'])?(int) $_GET['page']:1;
        $this->count = Model::SysPage('Số lượng Sản phẩm trang Danh mục');
        $this->total = $this->getDB->table('page')->whereIn('id_category', $this->listid)->where('typepage',6)->where(lang.'name','<>','')->where(lang.'status',1)->count();
        $this->getOrder(); $this->getFilter();
    }
    
    /* CÀI ĐẶT SẮP XẾP SẢN PHẨM */
    private $orderid = 0; private $order = array(); private $where=array();
    private function getOrder(){
        if(isset($_GET['order'])){
            $fieldorder = array(
                0=>array(),
                1=>array('field'=>'b.'.lang.'name', 'order'=>'ASC'),
                2=>array('field'=>'b.'.lang.'name', 'order'=>'DESC'),
                3=>array('field'=>'b.price', 'order'=>'ASC'),
                4=>array('field'=>'b.price', 'order'=>'DESC'),
                5=>array('field'=>'a.id', 'order'=>'ASC'),
                6=>array('field'=>'a.id', 'order'=>'DESC'),
                7=>array('field'=>'b.count_sale', 'order'=>'DESC'),
            );
            $this->orderid = in_array($_GET['order'], array(0,1,2,3,4,5,6,7))?$_GET['order']:0;
            $this->order = $fieldorder[$this->orderid]; 
        }
    }
    /* CÀI ĐẶT THUỘC TÍNH SẢN PHẨM */
    public function getFilter() {
        if(!isset($_GET['filter'])){return;}
        $filter = explode(',', $_GET['filter']);
        foreach ($filter as $v) { $this->where[] = array('field'=>'b.ids_attribute', 'compare'=>'LIKE', 'value'=>'%,'.$v.',%'); }
    }
}
