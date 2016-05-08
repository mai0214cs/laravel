<?php
namespace App\Http\Models;
use App\Common\UpdateMenu;
class ProductCategoryModel extends Model {
    private $titleadmin=array();
    public function __construct($setup) {
        parent::__construct();
        $this->titleadmin = $setup;
    }
    // Lấy dữ liệu truyền vào View Danh sách sản phẩm
    public function getData(){
        $result = $this->getDB->table('page AS a')->leftJoin('v_page AS b','a.id_vpage','=','b.id')
                ->select('a.id AS idpage','a.id_category AS idcategory','a.'.lang.'name AS namepage','b.id', 'b.name','a.url','a.'.lang.'status AS status','a.order','a.views','a.'.lang.'avatar AS avatar')
                ->where('a.typepage','=',5)->orderBy('a.order', 'ASC')->orderBy('a.id', 'DESC')->get();
        $menu = new UpdateMenu();              
        return array($this->titleadmin, $menu->ListMenu($result, 0, '')); 
    }
    
    // Lấy dữ liệu truyền vào View Thêm Danh sách sản phẩm
    public function getDataAdd(){
        $result = $this->getDB->table('page')->select('id AS idpage','id_category AS idcategory',lang.'name AS namepage')
                ->where('typepage','=',5)->orderBy('order', 'ASC')->orderBy('id', 'DESC')->get();
        $menu = new UpdateMenu();  
        $pages = $this->getDB->table('v_page')->select('id', 'name')->where('typepage',4)->get();
        return array($this->titleadmin, $menu->ListMenu($result, 0, ''), $pages);
    }
    
    // Lấy dữ liệu truyền vào View Sửa Danh sách sản phẩm
    public function getDataEdit($id){
        $result = $this->getDB->table('page')->select('id AS idpage','id_category AS idcategory',lang.'name AS namepage')
                ->where('typepage','=',5)->orderBy('order', 'ASC')->orderBy('id', 'DESC')->get();
        $menu = new UpdateMenu();   
        $pages = $this->getDB->table('v_page')->select('id', 'name')->where('typepage',4)->get();
        $data = $this->getDB->table('page')
                ->select('id', lang.'name AS name', 'id_category', lang.'avatar AS avatar', lang.'description AS description', 'order', 'url', lang.'seo_title AS seo_title', lang.'seo_description AS seo_description', lang.'seo_keyword AS seo_keyword', 'id_vpage')
                ->where('id','=',$id)->where('typepage','=',5)->first();
        if($data){$data->avatar = \App\Common\ReturnImage::Image($data->avatar);}
        return array($this->titleadmin, $menu->ListMenuEdit($result, 0, $id), $pages,$data);
    }
    
    // Thêm danh mục sản phẩm mới
    public function Insert($post){
        $a = new \App\Common\WriteLink();
        $post['url'] = $a->Link($post['title'], $post['url'], 0);
        if($post['parentid']!=0){
            if($this->getDB->table('page')->where('id','=',$post['parentid'])->where('typepage','=',5)->count()!=1){return FALSE;}
        }
        $mang = [
            lang.'name'=>$post['title'], 'id_category'=>$post['parentid'], lang.'avatar'=>$post['avatar'],
            lang.'description'=>$post['description'], 'order'=>$post['order'], 
            'url'=>$post['url'], lang.'seo_title'=>$post['tagstitle'],lang.'seo_description'=>$post['metadescription'], 
            lang.'seo_keyword'=>$post['metakeyword'], 'id_vpage'=>$post['idvpage'],
            'add_date'=>  date('Y/m/d h:i:s'), 'add_name'=>\Session::get('UserAdmin')->id, 'typepage'=>5
        ];
        
        // id,name,description,id_category,url,seo_title,seo_keyword,seo_description,order,add_date,add_name,
        $count = $this->getDB->table('page')->insert($mang);
        return $count>0?TRUE:FALSE;
    }
    
    // Sửa Danh mục sản phẩm
    public function Edit($post){
        $a = new \App\Common\WriteLink();
        $post['url'] = $a->Link($post['title'], $post['url'], $post['id']);
        if($post['parentid']!=0){
            if($this->getDB->table('page')->where('id','=',$post['parentid'])->where('typepage','=',5)->count()!=1){return FALSE;}
        }
        $menu = new UpdateMenu();
        $listcategory = $this->getDB->table('page')->select('id AS idpage', 'id_category AS idcategory','name AS namepage')->where('typepage',5)->get();
        if(in_array($post['parentid'], $menu->SelectListMenuEdit($listcategory, 0, $post['parentid']))){return FALSE;}
        $mang = [
            lang.'name'=>$post['title'], 
            'id_category'=>$post['parentid'], 
            lang.'avatar'=>$post['avatar'],
            lang.'description'=>$post['description'], 
            'order'=>$post['order'], 
            'url'=>$post['url'], 
            lang.'seo_title'=>$post['tagstitle'],
            lang.'seo_description'=>$post['metadescription'], 
            lang.'seo_keyword'=>$post['metakeyword'], 
            'id_vpage'=>$post['idvpage'],
            'edit_date'=>  date('Y/m/d h:i:s'), 
            'edit_name'=>\Session::get('UserAdmin')->id
        ];
        return $this->getDB->table('page')->where('id',$post['id'])->where('typepage',5)->update($mang)>0?TRUE:FALSE;
    }
    
    // Xóa Danh mục sản phẩm
    public function Delete($get){
        if($get['iddirect']==0){
            $this->getDB->table('page')->where('id_category', $get['id'])->where('typepage',6)->delete();
        }else{
            if($this->getDB->table('page')->where('id',$get['iddirect'])->where('typepage',5)->where('id','<>',$get['id'])->count()==0){
                \Session::flash('message_error',$this->titleadmin['Lỗi lựa chọn danh mục sản phẩm']); // Loi cap nhat;
                return;
            }
            $update = ['id_category'=>$get['iddirect']];
            $this->getDB->table('page')->where('id_category',$get['id'])->where('typepage',6)->update($update);
        }
        $this->getDB->table('page')->where('id_category',$get['id'])->where('typepage',5)->update(['id_category'=>0]);
        if($this->getDB->table('page')->where('id',$get['id'])->where('typepage',5)->delete()>0){
            \Session::flash('message_success',$this->titleadmin['Xóa danh mục sản phẩm thành công']);
        }else{
            \Session::flash('message_error',$this->titleadmin['Xóa danh mục sản phẩm thất bại']);
        }
    }
    
    public function Check($id, $val){
        return $this->getDB->table('page')->where('id',$id)->where('typepage',5)->update([lang.'status'=>$val])>0?TRUE:FALSE;
    }
    public function Order($id, $val){//echo 'id la: '.$id.' val la: '.$val;
        return $this->getDB->table('page')->where('id',$id)->where('typepage',5)->update(['order'=>$val])>0?TRUE:FALSE;
    }
}
