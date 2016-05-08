<?php
namespace App\Website;
class ItemProduct extends Model{
    private $info;    private $prefix;
    private $fields = array(
        0=>'{Tiêu đề}',1=>'{Mô tả}',2=>'{Chi tiết}',3=>'{URL Hình ảnh}',4=>'{URL Page}',5=>'{Danh mục sản phẩm}',6=>'{Lượt xem}',
        7=>'{Mã sản phẩm}',8=>'{Giá gốc}',9=>'{Giá bán}',10=>'{Độ giảm giá}',11=>'{Thời gian khuyến mại}', 12=>'{Thời gian giá vàng}', 13=>'{Nhà sản xuất}', 14=>'{Thuộc tính}',
        15=>'{Địa chỉ bán}', 16=>'{Số lượng bán}',17=>'{Số lượng mua}', 18=>'{Đơn vị số lượng}', 19=>'{Bảo hành}', 20=>'{Icon mới}', 21=>'{Icon khuyến mại}', 22=>'{Icon giá vàng}',
        23=>'{Nút Đặt hàng}',24=>'{Nút Yêu thích}',25=>'{Nút đã xem}',26=>'{Nút xem nhanh}'
    );
    public function index($type, $category, $where, $order, $limit){
        $product = $this->getDB->table('page AS a')->leftJoin('product AS b','a.id','=','b.id_page')
        ->select('a.id', 'a.'.lang.'name AS name', 'a.'.lang.'description AS description', 'a.'.lang.'detail AS detail', 'a.id_category', 'a.url', 
        'a.views', 'a.'.lang.'avatar AS avatar', 'b.code', 'b.cost', 'b.price', 'b.promotion_price', 'b.promotion_start', 'b.promotion_end',
        'b.goldtime', 'b.goldtime_start', 'b.goldtime_end', 'b.options_price', 'b.id_procedure', 'b.ids_attribute',
        'b.ids_location', 'b.count_check', 'b.count', 'b.count_unit', 'b.'.lang.'warranty AS warranty', 'b.count_sale')->where('a.'.lang.'status',1)->where('a.typepage',6)->where('a.'.lang.'name','<>','');
        foreach ($where as $v) { $product->where($v['field'], $v['compare'], $v['value']); }
        if(count($category)>0){ $product->whereIn('id_category', $category); }
        foreach ($order as $v) { 
            if(isset($v['field'])){
            $product->orderBy($v['field'], $v['order']); 
            }
        }
        if(count($limit)==2){ $product->take($limit['count'])->skip($limit['page']*$limit['count']); }
        
        $data = $product->get(); //print_r($order);
        if(!isset($this->info[0])){return;}
        $item = $this->getDB->table('v_item')->select('ids_fields','content')->where('id',$type)->where('typepage0',1)->first(); if(!$item->content){return;}
        
        $listfields = explode(',', $item->ids_fields);
        $list_method = array(); $list_fields = array();
        foreach ($listfields as $v){ 
            if(isset($this->fields[$v])){ 
                $list_method[] = 'Item'.$v; 
                $list_fields[] = $this->fields[$v];   
            }
        }
        $content = ''; $this->prefix = lang==''?'/':'/'.lang.'/';
        foreach ($data as $v0) {
            $data_list = array(); $this->info = $v0;
            foreach ($list_method as $v) { $data_list[] = $this->$v(); }
            $content .= str_replace($list_fields, $data_list, $item->content);
        }
        return $content;
        
    }
    private function Info1(){return $this->info->name;} // Tiêu đề
    private function Info2(){return $this->info->description;} // Mô tả
    private function Info3(){return $this->info->detail;} // Chi tiết
    private function Info4(){return \App\Common\ReturnImage::Image($this->info->avatar);} // URL Hình ảnh
    private function Info5(){return ($this->prefix).$this->info->url;} // URL Page
    private function Info6(){
        $category = $this->getDB->table('page')->select('url',lang.'name AS name')->where('id', $this->info->id_category)->where(lang.'name','<>','')->where(lang.'status',1)->where('typepage',5)->first();
        if(!isset($category->id)){return '';} return '<a href="'.((lang==''?'/':'/'.lang.'/').$category->url).'">'.$category->name.'</a>';
    } // Danh mục sản phẩm
    private function Info7(){
        return '<div class="view"><span class="title">'.Model::Language('Tiêu đề Lượt xem').'</span><span class="content">'.$this->info->views.'</span></div>';
    } // Lượt xem
    private function Info8(){
        return '<div class="code"><span class="title">'.Model::Language('Mã sản phẩm').'</span><span class="content">'.$this->info->code.'</span></div>';
    } // Mã sản phẩm ***
    private function Info9(){
        
        return $this->info->cost;
        
    } // Giá gốc ***
    private function Info10(){return $this->info->price;} // Giá bán ***
    private function Info11(){} // Độ giảm giá ***
    private function Info12(){return '<div class="datepromotion"><span class="begin">'.$this->info->promotion_start.'</span><span class="begin">'.$this->info->promotion_end.'</span></div>';} // Thời gian khuyến mại ***
    private function Info13(){return '<div class="timegold"><span class="begin">'.$this->info->goldtime_start.'</span><span class="begin">'.$this->info->goldtime_end.'</span></div>';} // Thời gian giá vàng ***
    private function Info14(){
        $procedure = $this->getDB->table('page')->select('url',lang.'name AS name')->where('id', $this->info->id_procedure)->where(lang.'name','<>','')->where(lang.'status',1)->where('typepage',8)->first();
        if(!isset($procedure->id)){return '';} return '<a href="'.((lang==''?'/':'/'.lang.'/').$category->url).'">'.$category->name.'</a>';
    } // Nhà sản xuất
    private function Info15(){} // Thuộc tính
    private function Info16(){
        //$location = $this->getDB->table('location')->select()
    } // Địa chỉ bán
    private function Info17(){
        if($this->info->count_check){
            return $this->info->count;
        }
    } // Số lượng bán
    private function Info18(){
        return $this->info->count_sale;
    } // Số lượng mua
    private function Info19(){
        return $this->info->count_unit;
    } // Đơn vị số lượng
    private function Info20(){
        return $this->info->warranty;
    } // Bảo hành
    private function Info21(){
        
    } // Icon mới
    private function Info22(){
        
    } // Icon Khuyến mại
    private function Info23(){
        
    } // Icon giá vàng
    private function Info24(){
        
    } // Nút đặt hàng
    private function Info25(){
        
    } // Nút yêu thích
    private function Info26(){
        
    } // Nút đã xem
    private function Info27(){
        
    } // Nút xem nhanh
}
