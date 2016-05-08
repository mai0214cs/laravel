<?php
namespace App\Http\Models;
class ProductProcedureModel extends Model {
    private $titleadmin=array();
    public function __construct($setup) {
        parent::__construct();
        $this->titleadmin = $setup;
    }
    // Lấy dữ liệu truyền vào View Danh sách Nhà sản xuất
    public function getData(){
        $result = $this->getDB->table('page AS a')->leftJoin('v_page AS b','a.id_vpage','=','b.id')
                ->select('a.id AS idpage','a.id_category AS idcategory','a.'.lang.'name AS namepage','b.id', 'b.name','a.url','a.'.lang.'status AS status','a.order','a.views','a.'.lang.'avatar AS avatar')
                ->where('a.typepage','=',8)->orderBy('a.order', 'ASC')->orderBy('a.id', 'DESC')->get();
        return array($this->titleadmin, $result); 
    }
    
    // Lấy dữ liệu truyền vào View Thêm Nhà sản xuất
    public function getDataAdd(){
        $pages = $this->getDB->table('v_page')->select('id', 'name')->where('typepage','=',8)->get();
        return array($this->titleadmin, '', $pages);
    }
    
    // Lấy dữ liệu truyền vào View Sửa Nhà sản xuất
    public function getDataEdit($id){
        $pages = $this->getDB->table('v_page')->select('id', 'name')->where('typepage','=',8)->get();
        $data = $this->getDB->table('page')
                ->select('id', lang.'name AS name', 'id_category', lang.'avatar AS avatar', lang.'description AS description', 'order', 'url', lang.'seo_title AS seo_title', lang.'seo_description AS seo_description', lang.'seo_keyword AS seo_keyword', 'id_vpage')
                ->where('id','=',$id)->where('typepage','=',8)->first();
        $data1 = $this->getDB->table('procedure')->select('email','address','phone')->where('id_page',$id)->first();
        if($data){$data->avatar = \App\Common\ReturnImage::Image($data->avatar);}
        return array($this->titleadmin, '', $pages,$data,$data1);
    }
    
    // Thêm Nhà sản xuất mới
    public function Insert($post){
        $a = new \App\Common\WriteLink();
        $post['url'] = $a->Link($post['title'], $post['url'], 0);
        $mang = [
            lang.'name'=>$post['title'], 
            lang.'avatar'=>$post['avatar'],
            lang.'description'=>$post['description'], 
            'order'=>$post['order'], 
            'url'=>$post['url'], 
            lang.'seo_title'=>$post['tagstitle'],
            lang.'seo_description'=>$post['metadescription'], 
            lang.'seo_keyword'=>$post['metakeyword'], 
            'id_vpage'=>$post['idvpage'],
            'add_date'=>  date('Y/m/d h:i:s'), 
            'add_name'=>\Session::get('UserAdmin')->id, 'typepage'=>8
        ];
        // id,name,description,id_category,url,seo_title,seo_keyword,seo_description,order,add_date,add_name,
        
        $count = $this->getDB->table('page')->insertGetId($mang);
        $mang2 = [
            'address'=>$post['address'],
            'email'=>$post['email'],
            'phone'=>$post['phone'],
            'id_page'=>$count
        ];
        $this->getDB->table('procedure')->insert($mang2);
        return $count>0?TRUE:FALSE;
    }
    
    // Sửa Nhà sản xuất
    public function Edit($post){
        $a = new \App\Common\WriteLink();
        $post['url'] = $a->Link($post['title'], $post['url'], $post['id']);
        $mang = [
            lang.'name'=>$post['title'], 
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
        $mang2 = [
            'address'=>$post['address'],
            'email'=>$post['email'],
            'phone'=>$post['phone'],
        ];
        $this->getDB->table('procedure')->where('id_page',$post['id'])->update($mang2);
        return $this->getDB->table('page')->where('id',$post['id'])->where('typepage',8)->update($mang)>0?TRUE:FALSE;
    }
    
    // Xóa Nhà sản xuất
    public function Delete($id){
        $this->getDB->table('procedure')->where('id_page',$id)->delete();
        $this->getDB->table('page')->where('id_category',$id)->where('typepage',8)->update(['id_category'=>0]);
        $this->getDB->table('page')->where('id',$id)->where('typepage',8)->delete();
    }
    
    public function Check($id, $val){
        return $this->getDB->table('page')->where('id',$id)->where('typepage',8)->update([lang.'status'=>$val])>0?TRUE:FALSE;
    }
    public function Order($id, $val){
        return $this->getDB->table('page')->where('id',$id)->where('typepage',8)->update(['order'=>$val])>0?TRUE:FALSE;
    }
}
