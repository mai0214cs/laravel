<?php
namespace App\Http\Models;
class DesignItemModel extends Model {
    private $item0 = array(0=>'{Tiêu đề}', 1=>'{URL Hình ảnh}', 2=>'{Mô tả}', 3=>'{Danh mục}', 4=>'{URL Bài viết}', 5=>'{Danh sách Tags}', 6=>'{Ngày đăng}', 7=>'{Người đăng}', 8=>'{Ngày sửa}', 9=>'{Người sửa}'); // Danh sách trình bày mục tin tức
    private $item1 = array(0=>'{Tiêu đề}',1=>'{Mô tả}',2=>'{Chi tiết}',3=>'{URL Hình ảnh}',4=>'{URL Page}',5=>'{Danh mục sản phẩm}',6=>'{Lượt xem}',
        7=>'{Mã sản phẩm}',8=>'{Giá gốc}',9=>'{Giá bán}',10=>'{Độ giảm giá}',11=>'{Thời gian khuyến mại}', 12=>'{Thời gian giá vàng}', 13=>'{Nhà sản xuất}', 14=>'{Thuộc tính}',
        15=>'{Địa chỉ bán}', 16=>'{Số lượng bán}',17=>'{Số lượng mua}', 18=>'{Đơn vị số lượng}', 19=>'{Bảo hành}', 20=>'{Icon mới}', 21=>'{Icon khuyến mại}', 22=>'{Icon giá vàng}',
        23=>'{Nút Đặt hàng}',24=>'{Nút Yêu thích}',25=>'{Nút đã xem}',26=>'{Nút xem nhanh}'); // Danh sách trình bày mục sản phẩm
    private $titleadmin=array();
    public function __construct($setup) {
        parent::__construct();
        $this->titleadmin = $setup;
    }
    public function getData($id, $item=0){
        if(in_array($id, array(0,1))){}
        $titlepage = $id==0?$this->titleadmin['Trang Cài đặt mục Tin tức']:$this->titleadmin['Trang Cài đặt mục Sản phẩm'];
        $pageitem = $this->getDB->table('v_item')->select('id','name')->where('typepage0',$id)->orderBy('order','ASC')->orderBy('id','ASC')->get();
        $value = $this->getDB->table('v_item')->select('id','name','typepage0','order','ids_fields','content')->where('id',$item)->where('typepage0',$id)->first();
        //$value->ids_fields = explode(',', $value->ids_fields);
        //print_r($value); exit();
        return [
            'data'=>array($this->titleadmin),
            'pageitem'=>$pageitem,
            'titlepage'=>$titlepage,
            'value'=>$value,
            'fields'=>$this->{'item'.$id},
            'item'=>$id,
            'itemid'=>$item
        ];
    }
    public function updateData($post){
        $select = array(); $typepage0 = $post['typepage']; $id = $post['iditem']; 
        if(!in_array($typepage0, array(0,1))){return FALSE;}
        if(isset($post['item'])){foreach ($post['item'] as $v) {if(in_array($v, $this->{'item'.$typepage0})){$select[] = $v;}}}
        $value = [
            'name'=>$post['title'], 
            'typepage0'=>$typepage0, 
            'order'=>$post['order'],
            'ids_fields'=>  implode(',', $post['item']), 
            'content'=>$post['content']
        ];
        if($id==0){
            $idm = $this->getDB->table('v_item')->insertGetId($value);
           if($idm>0){
                \Session::flash('message_success',$this->titleadmin['Thêm Mục trình bày thành công']); return array(TRUE, $typepage0, $idm);
            }else{
                \Session::flash('message_error',$this->titleadmin['Thêm Mục trình bày thất bại']); return array(FALSE, $typepage0, $id);
            }
        }
        if($this->getDB->table('v_item')->where('id',$id)->where('typepage0',$typepage0)->update($value)>0){
            \Session::flash('message_success',$this->titleadmin['Sửa Mục trình bày thành công']); return array(TRUE, $typepage0, $id);
        }else{
            \Session::flash('message_error',$this->titleadmin['Sửa Mục trình bày thất bại']); return array(FALSE, $typepage0, $id);
        }
    }
    public function delete($id, $item){
        if($this->getDB->table('v_item')->where('id',$item)->where('typepage0',$id)->delete()>0){
            \Session::flash('message_success',$this->titleadmin['Xóa Mục trình bày thành công']);
        }else{
            \Session::flash('message_error',$this->titleadmin['Xóa Mục trình bày thất bại']);
        }
    }
}
