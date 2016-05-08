<?php
namespace App\Http\Models;
class DesignPageModel extends Model {
    private $titleadmin=array();
    private $typepage = array(
        0=>'Trang chủ', 1=>'Danh mục tin tức', 2=>'Danh sách tin tức', 3=>'Tags sản phẩm - tin tức',
        4=>'Danh mục sản phẩm', 5=>'Danh sách sản phẩm', 6=>'Nhà sản xuất' , 7=>'Thanh toán', 8=>'Hóa đơn thanh toán'
    );
    //private $typepage=NULL;
    private $selecttypepage = array(
        0=>array(), // Trang chủ
        1=>array(
            0=>'{Tiêu đề}', 1=>'{Mô tả}', 2=>'{URL Hình ảnh}', 3=>'{URL Page}', 
            4=>'{Danh sách tin tức}', 5=>'{Danh mục tin tức}', 6=>'{Phân trang}'
        ), // Danh mục tin tức
        2=>array(
            0=>'{Tiêu đề}',     1=>'{Mô tả}',       2=>'{Chi tiết}',    3=>'{URL Hình ảnh}',
            4=>'{Ngày đăng}',   5=>'{Người đăng}',  6=>'{Ngày sửa}',    7=>'{Người sửa}',
            8=>'{Bình luận}',   9=>'{Tags Tin tức}',10=>'{Tin tức liên quan}'
        ), // Chi tiết tin tức
        3=>array(
            
        ), // Tabs tin tức
        4=>array(
            0=>'{Tiêu đề}', 1=>'{Mô tả}', 2=>'{URL Hình ảnh}', 3=>'{URL Danh mục}',
            4=>'{Danh sách Sản phẩm}', 5=>'{Phân trang Sản phẩm}', 6=>'{Sắp xếp Sản phẩm}',7=>'{Menu Danh mục sản phẩm}'
        ), // Danh mục sản phẩm
        5=>array(
            0=>'{Tiêu đề}', 1=>'{Mô tả}', 2=>'{Chi tiết}', 3=>'{URL Hình ảnh}', 4=>'{URL Sản phẩm}', 5=>'{Danh mục Sản phẩm}',
            6=>'{Sản phẩm liên quan}', 7=>'{Tin tức liên quan}', 8=>'{Sản phẩm cùng danh mục}', 9=>'{Tags Sản phẩm}',
            10=>'{Lượt xem}', 11=>'{Ngày đăng}', 12=>'{Người đăng}', 13=>'{Ngày sửa}', 14=>'{Người sửa}',
            15=>'{Mã sản phẩm}', 16=>'{Giá gốc}', 17=>'{Giá bán}', 18=>'{Ngày khuyến mại}', 19=>'{Thời điểm giờ vàng}', 20=>'{Giá tùy chọn}', 21=>'{Hình ảnh}', 22=>'{Video}', 
            23=>'{Tiêu đề tabs 1}', 24=>'{Tiêu đề tabs 2}', 25=>'{Tiêu đề tabs 3}', 26=>'{Tiêu đề tabs 4}', 27=>'{Tiêu đề tabs 5}',    
            28=>'{Nội dung tabs 1}', 29=>'{Nội dung tabs 2}', 30=>'{Nội dung tabs 3}', 31=>'{Nội dung tabs 4}', 32=>'{Nội dung tabs 5}', 
            33=>'{Thông số sản phẩm}', 34=>'{Nhà sản xuất}', 35=>'{Thuộc tính}', 36=>'{Địa điểm mua}', 37=>'{Số lượng bán}',   
            38=>'{Thông tin bảo hành}', 39=>'{Số lượng đã bán}', 40=>'{Giá cũ}', 41=>'{Độ giảm giá}'
        ), // Chi tiết sản phẩm
        6=>array(
            
        ),
        7=>array(),
        8=>array()
    );
    
    public function __construct($setup) {
        parent::__construct();
        $this->titleadmin = $setup;
        //$modul=new \App\Http\TestModul\ModulListType();
        //$this->typepage = $modul->listmodul;
    }
    public function getData($id, $type){
        $valiable = [
            'data'=>array($this->titleadmin),
            'id'=>$id,
            'type'=>$type,
            'listpage'=>$this->getDB->table('v_page')->select('id','name','typepage')->get(),
            'item_product'=>$this->getDB->table('v_item')->select('id','name')->where('typepage0',1)->get(),
            'item_news'=>$this->getDB->table('v_item')->select('id','name')->where('typepage0',0)->get(),
            'template'=>$this->getDB->table('v_temp')->select('id','name')->get(),
            'typepage'=>$this->typepage,
            'info'=>$this->getDB->table('v_page')->select('name', $type.'id_temp AS id_temp', $type.'content AS content', 'order', 'typepage', $type.'ids_item AS ids_item', $type.'ids_fields AS ids_fields', 'typepage')->where('id',$id)->first(),
        ];
        $valiable['selecttypepage'] = isset($valiable['info']->name)?$this->selecttypepage[$valiable['info']->typepage]:$this->selecttypepage[0];
        $valiable['selectcurrent'] = isset($valiable['info']->ids_fields)?explode(',', $valiable['info']->ids_fields):array();
        return $valiable;
    }
    public function update($post){
        //echo $post[]
        $id = $post['idpage']; $version = $post['idtypepage'];
        if(!isset($this->typepage[$post['typepage']])){
            \Session::flash('message_error',$this->titleadmin['Kiểu trang không tồn tại']); return array(FALSE,$id,$version);
        }
        if(!in_array($post['idtypepage'], array('','mobile'))){
            \Session::flash('message_error',$this->titleadmin['Phiên bản bạn chọn chưa đúng']); return array(FALSE,$id,$version);
        }
        $fields = array();
        if(isset($post['list_field'])){
            foreach ($post['list_field'] as $v) {
                if(isset($this->selecttypepage[$v])){$fields[] = $v;}
            }
        }
        $item = array($post['product_list'],$post['product_category'],$post['product_related'],$post['news_list'],$post['news_category'],$post['news_related']);
        foreach ($item as $v) {
            if($this->getDB->table('v_item')->where('id',$v)->count()!=1){
                \Session::flash('message_error',$this->titleadmin['Mục sản phẩm hoặc mục tin tức bạn chọn không đúng']); return array(FALSE,$id,$version);
            }
        }
        if($this->getDB->table('v_temp')->where('id',$post['template'])->count()!=1){
            \Session::flash('message_error',$this->titleadmin['Template bạn chọn không đúng']); return array(FALSE,$id,$version);
        }
        
        $data = [
            'name'=>$post['title'],
            'typepage'=>$post['typepage'],
            $version.'id_temp'=>$post['template'],  
            $version.'content'=>$post['contenthtml'],
            'order'=>$post['order'],
            $version.'ids_item'=>  implode(',', $item),
            $version.'ids_fields'=>  implode(',', $fields)
        ];
        if($id==0){
            $idm = $this->getDB->table('v_page')->insertGetId($data);
            if($idm>0){
                \Session::flash('message_success',$this->titleadmin['Thêm Page thành công']); return array(TRUE,$idm,$version);
            }else{
                \Session::flash('message_error',$this->titleadmin['Thêm Page thất bại']); return array(FALSE,0,$version);
            }
        }else{
            if($this->getDB->table('v_page')->where('id',$id)->where('typepage',$post['typepage'])->update($data)>0){
                \Session::flash('message_success',$this->titleadmin['Sửa Page thành công']); return array(TRUE,$id,$version);
            }else{
                \Session::flash('message_error',$this->titleadmin['Sửa Page thất bại']); return array(FALSE,$id,$version);
            }
        }
    }
    function delete($get){
        $id = $get['id']; $idm = $get['idm'];
        $typepage = $this->getDB->table('v_page')->select('typepage')->where('id',$id)->first();
        if(!isset($typepage->typepage)){
            \Session::flash('message_error',$this->titleadmin['Xóa Page thất bại']); return;
        }
        if($this->getDB->table('v_page')->where('id',$id)->orwhere('id',$idm)->where('typepage',$typepage->typepage)->count()!=2){
            \Session::flash('message_error',$this->titleadmin['Xóa Page thất bại']); return;
        }
        $lang = $this->getDB->table('lang')->select('code')->get();
        foreach ($lang as $v) {
            $this->getDB->table('page')->where($v->code.'id_vpage',$id)->update(array($v->code.'id_vpage'=>$idm));
            $this->getDB->table('pagesys')->where($v->code.'id_vpage',$id)->update(array($v->code.'id_vpage'=>$idm));
        }
        if($this->getDB->table('v_page')->where('id',$id)->delete()==1){
            \Session::flash('message_success',$this->titleadmin['Xóa Page thành công']); return;
        }else{
            \Session::flash('message_error',$this->titleadmin['Xóa Page thất bại']); return;
        }
    }
    function fields($get){
        for ($i = 0; $i < count($this->selecttypepage[$get['val']]); $i++) {
            echo '<option  value="'.$i.'">'.$this->selecttypepage[$get['val']][$i].'</option>';
        }
    }
}
