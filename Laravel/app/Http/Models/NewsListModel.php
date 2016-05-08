<?php
namespace App\Http\Models;
use App\Common\UpdateMenu;
use App\Common\SelectList;
use App\Common\ReturnImage;
use App\Common\WriteLink;
class NewsListModel extends Model {
    private $titleadmin=array();
    public function __construct($setup) {
        parent::__construct();
        $this->titleadmin = $setup;
    }
    // Lấy dữ liệu truyền vào View Danh sách tin tức
    public function getData(){
        $data = $this->getDB->table('page')->select('id AS idpage','id_category AS idcategory',lang.'name AS namepage')->where('typepage',2)->orderBy('order','ASC')->orderBy('id','DESC')->get();
        $menu = new UpdateMenu(); 
        $result = $this->getDB->table('page AS a')->leftJoin('v_page AS b','a.id_vpage','=','b.id')
                ->select('a.id AS idpage','a.id_category AS idcategory','a.'.lang.'name AS namepage','b.id', 'b.name','a.url','a.'.lang.'status AS status','a.order','a.views','a.'.lang.'avatar AS avatar')
                ->where('a.typepage',3)->orderBy('a.order', 'ASC')->orderBy('a.id', 'DESC')->paginate(20);
        return array($this->titleadmin, $result,$menu->ListMenu($data, 0, '')); 
    }

    // Lấy dữ liệu truyền vào View Thêm Danh sách tin tức
    public function getDataAdd(){
        $result = $this->getDB->table('page')->select('id AS idpage','id_category AS idcategory',lang.'name AS namepage')
                ->where('typepage',2)->orderBy('order', 'ASC')->orderBy('id', 'DESC')->get();
        $menu = new UpdateMenu();  
        $pages = $this->getDB->table('v_page')->select('id', 'name')->where('typepage',2)->get();
        return array($this->titleadmin, $menu->ListMenu($result, 0, ''), $pages, SelectList::Tags(0));
    }
    
    // Lấy dữ liệu truyền vào View Sửa Danh sách tin tức
    public function getDataEdit($id){
        $result = $this->getDB->table('page')->select('id AS idpage','id_category AS idcategory',lang.'name AS namepage')
                ->where('typepage','=',2)->orderBy('order', 'ASC')->orderBy('id', 'DESC')->get();
        $menu = new UpdateMenu();   
        $pages = $this->getDB->table('v_page')->select('id', 'name')->where('typepage','=',2)->get();
        $data = $this->getDB->table('page')
                ->select('id', lang.'name AS name', 'id_category', lang.'avatar AS avatar', lang.'description AS description', lang.'detail AS detail', 'order','ids_tags', 'url', lang.'seo_title AS seo_title', lang.'seo_description AS seo_description', lang.'seo_keyword AS seo_keyword', 'id_vpage')
                ->where('id','=',$id)->where('typepage','=',3)->first();
        if($data){$data->avatar = \App\Common\ReturnImage::Image($data->avatar);}
        return array($this->titleadmin, $menu->ListMenu($result, 0, ''), $pages, $data, SelectList::Tags(0), SelectList::GetTagsPage($data->ids_tags, TRUE));
    }
    
    // Thêm danh mục tin tức mới
    public function Insert($post){
        $a = new \App\Common\WriteLink();
        $post['url'] = $a->Link($post['title'], $post['url'], 0);
        if($post['parentid']!=0){
            if($this->getDB->table('page')->where('id','=',$post['parentid'])->where('typepage','=',2)->count()!=1){return FALSE;}
        }
        $mang = [
            lang.'name'=>$post['title'], 'id_category'=>$post['parentid'], lang.'avatar'=>$post['avatar'],
            lang.'description'=>$post['description'], 
            'order'=>$post['order'], lang.'detail'=>$post['detail'],
            'url'=>$post['url'], lang.'seo_title'=>$post['tagstitle'],lang.'seo_description'=>$post['metadescription'], 
            lang.'seo_keyword'=>$post['metakeyword'], 'id_vpage'=>$post['idvpage'],
            'ids_tags'=> SelectList::TestTags(isset($post['tags'])?$post['tags']:array(), 0),lang.'status'=>1,
            'add_date'=> date('Y/m/d h:i:s'), 'add_name'=>\Session::get('UserAdmin')->id, 'typepage'=>3
        ];
        
        // id,name,description,id_category,url,seo_title,seo_keyword,seo_description,order,add_date,add_name,
        $count = $this->getDB->table('page')->insert($mang);
        return $count>0?TRUE:FALSE;
    }
    
    // Sửa Danh mục tin tức
    public function Edit($post){
        $a = new \App\Common\WriteLink();
        $post['url'] = $a->Link($post['title'], $post['url'], $post['id']);
        if($post['parentid']!=0){
            if($this->getDB->table('page')->where('id','=',$post['parentid'])->where('typepage',2)->count()!=1){return FALSE;}
        }
        $mang = [
            lang.'name'=>$post['title'], 
            'id_category'=>$post['parentid'], 
            lang.'avatar'=>$post['avatar'],
            lang.'description'=>$post['description'], 
            lang.'detail'=>$post['detail'], 
            'order'=>$post['order'], lang.'detail'=>$post['detail'],
            'url'=>$post['url'], 
            lang.'seo_title'=>$post['tagstitle'],
            lang.'seo_description'=>$post['metadescription'], 
            lang.'seo_keyword'=>$post['metakeyword'], 
            'id_vpage'=>$post['idvpage'],
            'ids_tags'=> SelectList::TestTags(isset($post['tags'])?$post['tags']:array(), 0),
            'edit_date'=>  date('Y/m/d h:i:s'), 
            'edit_name'=>\Session::get('UserAdmin')->id
        ];
        return $this->getDB->table('page')->where('id',$post['id'])->where('typepage',3)->update($mang)>0?TRUE:FALSE;
    }
    
    // Xóa Danh mục tin tức
    public function Delete($id){
        $this->getDB->table('page')->where('id_category',$id)->where('typepage',3)->update(['id_category'=>0]);
        $this->getDB->table('page')->where('id',$id)->where('typepage',3)->delete();
    }
    public function deleteAll($ids){
        $count = 0;
        foreach ($ids as $v){
            $count = $this->getDB->table('page')->where('id',$v)->where('typepage',3)->delete()>0?$count+1:$count;
        }
        return $count;
    }

    public function Check($id, $val){
        return $this->getDB->table('page')->where('id',$id)->where('typepage',3)->update([lang.'status'=>$val])>0?TRUE:FALSE;
    }
    public function Order($id, $val){
        return $this->getDB->table('page')->where('id',$id)->where('typepage',3)->update(['order'=>$val])>0?TRUE:FALSE;
    }
    public function updatelist($get){
        
        $result = $this->getDB->table('page AS a')->leftJoin('v_page AS b','a.id_vpage','=','b.id')
                ->select('a.id AS idpage','a.id_category AS idcategory','a.'.lang.'name AS namepage','b.id', 'b.name','a.url','a.'.lang.'status AS status','a.order','a.views','a.'.lang.'avatar AS avatar')
                ->where('a.typepage','=',3);
        
        // Chọn từ khóa
        if($get['key']!=''){
            $result = $result->where('a.'.lang.'name','LIKE', '%'.$get['key'].'%');
        }
        // Chọn danh mục
        if($get['category']!=0){
            $result = $result->where('a.id_category', $get['category']);
        }
        $count = is_numeric($get['count'])?((int) $get['count']>1&&$get['count']<500)?(int) $get['count']:20:20;
        $item =  is_numeric($get['item'])?((int) $get['item']-1)<0?0:(int) $get['item']-1:0;
        
        // Sắp xếp danh sách
        switch ($get['order']){
            case 0: $result = $result->orderBy('a.id', 'DESC'); break;
            case 1: $result = $result->orderBy('a.id', 'ASC'); break;
            case 2: $result = $result->orderBy('a.'.lang.'name', 'ASC'); break;
            case 3: $result = $result->orderBy('a.'.lang.'name', 'DESC'); break;
            case 4: $result = $result->orderBy('a.views', 'DESC'); break;
        }
        $coutpage = ceil($result->count()/$count);$pagecount = '';
        for($i=1; $i<=$coutpage; $i++){
            $pagecount.='<option value="'.$i.'">Trang '.$i.'</option>';
        }
        $rs = $result->take($count)->skip($item*$count)->get(); $content = '';
        foreach ($rs as $v) {
            $content.='<tr>
                <td><input type="checkbox" class="CheckAll" rel="'.$v->idpage.'" /></td>
                <td><a href="/admin/news/list/edit/'.$v->idpage.'">'.$v->namepage.'</a></td>
                <td><img src="'.ReturnImage::Image($v->avatar).'" alt="'.$v->namepage.'" style="width:50px;" /></td>
                <td><a target="_blink" href="/'.lang.'/'.$v->url.'">'.lang.'/'.$v->url.'</a></td>
                <td><a target="_blink" href="/admin/design/page/'.$v->id.'">'.$v->name.'</a></td>
                <td><input type="checkbox" '.($v->status==1?'checked="checked"':'').' onclick="CheckStatus(\'/admin/news/list/checkstatus\',this.checked?1:0,'.$v->idpage.')" /></td>
                <td><input class="form-control" type="number" value="'.$v->order.'" onblur="CheckStatus(\'/admin/news/list/changeorder\',this.value,'.$v->idpage.')" /></td>
                <td>'.$v->views.'</td>
                <td>
                    <a href="/admin/news/list/edit/'.$v->idpage.'">'.$this->titleadmin['Nút Sửa Danh sách'].'</a>
                    <a onclick="return window.confirm(\''.$this->titleadmin['Xác nhận Xóa Danh sách tin tức'].'\')" href="/admin/news/list/delete/'.$v->idpage.'">'.$this->titleadmin['Nút Xóa danh dách'].'</a>
                </td>
            </tr>';
        }
        echo json_encode(array('pagecount'=>$pagecount, 'content'=>$content));
    }
    
    
    // Export Danh sách Tin tức
    public function ExportExcel(){
        $data = $this->getDB->table('page')->select('id', lang.'name AS name', lang.'description AS description', lang.'detail AS detail', lang.'avatar AS avatar', 'id_category',
            'url', lang.'seo_title AS seo_title', lang.'seo_keyword AS seo_keyword', lang.'seo_description AS seo_description', 'ids_tags', 'status', 'order', 'views', 
            'id_vpage', 'add_date', 'add_name', 'edit_date', 'edit_name')
            ->where('typepage',3)->orderBy('order', 'ASC')->orderBy('id','DESC')->get();
        $value = array(); $this->getDataExport();
        foreach ($data as $v) {
            // Get Tags
            $tags = explode(',', $v->ids_tags); $tag = array();
            foreach ($tags as $v1) {
                if(isset($this->tags[$v1])){$tag[]=$this->tags[$v1];}
            }
            $value[] = [
                'id'=>$v->id,
                'title'=>$v->name,
                'description'=>$v->description,
                'detail'=>$v->detail,
                'avatar'=>$v->avatar,
                'category'=>isset($this->category[$v->id_category])?$this->category[$v->id_category]:'',
                'url'=>$v->url,
                'tag_title'=>$v->seo_title,
                'meta_description'=>$v->seo_description,
                'meta_keyword'=>$v->seo_keyword,
                'tags'=>  implode(',', $tag),
                'status'=>$v->status,
                'order'=>$v->order,
                'views'=>$v->views,
                'page_view'=>isset($this->vpage[$v->id_vpage])?$this->vpage[$v->id_vpage]:'',
                'date_add'=>$v->add_date,
                'name_add'=>  isset($this->member[$v->add_name])?$this->member[$v->add_name]:'',
                'date_edit'=>$v->edit_date,
                'name_edit'=>  isset($this->member[$v->edit_name])?$this->member[$v->edit_name]:''
            ];
        }
        if(isset($value[0])){
            \Maatwebsite\Excel\Facades\Excel::create('ListNews', function($excel) use($value){
                $excel->sheet('Sheet1', function($sheet) use($value){
                    $sheet->fromArray($value);
                });
            })->export('xls');
        }else{echo 'No data';}
    }
    // Importa Danh sách Tin tức
    public function ImportExcel($file){
        $this->getDataImport(); $wlink = new WriteLink();
        if($this->vpage_category==0){
            echo $this->titleadmin['Không thể import Tin tức do thiếu thiết lập']; return;
        }
        $data = \Maatwebsite\Excel\Facades\Excel::load(trim($file,'/'))->get();
        $count_error[] = 0; $count = 1; $count_edit = 0; $count_category = 0; $count_add = 0; $count_tags=0;
        foreach ($data as $v) {
            $count++;
            // Test Sự tổn tại của các field ID, Name, Category, Page_View
            if(!(isset($v->id)&&isset($v->title)&&isset($v->category)&&isset($v->page_view))){
                echo $this->titleadmin['Không thể import Tin tức do thiếu data']; return;
                //echo $this->titleadmin['Không thể import Sản phẩm do thiếu data']; return FALSE; 
            }
            // test name
            $id = $v->id; $table_page = array(); 
            // Set Name
            if(trim($v->title)==''){
                $count_error[] = array($count,'Name'); continue; // ERROR: Tiêu đề sản phẩm không được để trống
            }
            $table_page[lang.'name'] = trim($v->title); 
            // Test Danh mục 
            if(isset($this->category[$v->category])){
                $id_category = $this->category[$v->category];
            }else{
                $data = [
                    lang.'name'=>$v->category, 'url'=>$wlink->Link($v->category, '', 0),
                    'add_date'=>  date('Y/m/d h:i:s'), 'add_name'=>\Session::get('UserAdmin')->id,
                    'typepage'=>2, lang.'id_vpage'=>$this->vpage_category, lang.'status'=>1
                ];
                $id_category = $this->getDB->table('page')->insertGetId($data);
                $this->category[$v->category] = $id_category; $count_category++;
            }
            // Test Tags 
            $tags = array();
            if(isset($v->tags)){
                if(trim($v->tags)!=''){
                    $listtags = explode(',', $v->tags); 
                    foreach ($listtags as $tag) {
                        if(isset($this->tags[trim($tag)])){
                            $tags[] = $this->tags[trim($tag)];
                        }else{
                            if(trim($tag)!=''){
                                $tagid = $this->getDB->table('tags')->insertGetId([lang.'name'=>trim($tag),'typepage0'=>0]);$count_tags++;
                                $this->tags[trim($tag)] = $tagid; $tags[] = $tagid;
                            }
                        }
                    }
                    $table_page['ids_tags'] = implode(',', $tags);
                }
            }
            // Test Page hiển thị trang
            if(!isset($this->vpage[$v->page_view])){
                $count_error[] = array($count,'Page_View'); continue; // ERROR: Page hiển thị trang không tồn tại
            }
            // Test fields
            if(isset($v->description)){ $table_page[lang.'description'] = trim($v->description); }
            if(isset($v->detail)){ $table_page[lang.'detail'] = trim($v->detail); }
            if(isset($v->avatar)){ $table_page[lang.'avatar'] = ReturnImage::Image($v->avatar); }
            if(isset($v->url)){ $table_page['url'] = $wlink->Link($v->name, $v->url, $id); }else{
                if($id==0){$table_page['url'] = $wlink->Link($v->name, '', 0);}
            }
            if(isset($v->tag_title)){ $table_page[lang.'seo_title'] = $v->tag_title; }
            if(isset($v->meta_keyword)){ $table_page[lang.'seo_keyword'] = $v->meta_keyword; }
            if(isset($v->meta_description)){ $table_page[lang.'seo_description'] = $v->meta_description; }
            if(isset($v->status)){ $table_page[lang.'status'] = in_array($v->status, array(1,0))?$v->status:0; }
            if(isset($v->order)){ $table_page['order'] = is_numeric($v->order)?(int) $v->order:999; }
            $table_page['id_vpage'] = $this->vpage[$v->page_view]; 
            
            // Get Info người đăng
            $table_page['typepage'] = 3;
            if($id==0||$id==''){
                $table_page['add_date'] = date('Y/m/d h:i:s');
                $table_page['add_name'] = \Session::get('UserAdmin')->id;
            }else{
                $table_page['edit_date'] = date('Y/m/d h:i:s');
                $table_page['edit_name'] = \Session::get('UserAdmin')->id;
            }
            
            // Update database
            if($id==0){
                if($id = $this->getDB->table('page')->insertGetId($table_page)>0){
                    $count_add++;
                }else{
                    $count_error[] = array($count,'Error');
                }
            }else{
                if($this->getDB->table('page')->where('id',$id)->where('typepage',3)->update($table_page)>0){
                    $count_edit++; 
                }else{
                    $count_error[] = array($count,'Error');
                }
            }
            
        }
        // Xuất thông tin
            $string = '<strong>'.$this->titleadmin['Số mục đã nhập Excel thành công'].$count_add.' add + '.$count_edit.' edit</strong><br/>
                <strong>'.$this->titleadmin['Số mục đã nhập Excel thất bại'].(count($count_error)-1).'</strong><br/>';
            foreach ($count_error as $v) {
                if($v[0]==''){continue;}
                $string .= 'Line: '.$v[0].': '.$v[1].'<br/>';
            }
            $string .= '<strong>'.$this->titleadmin['Số danh mục được tạo thêm'].$count_category.'</strong><br/>';
            $string .= '<strong>'.$this->titleadmin['Số tags được tạo thêm'].$count_tags.'</strong><br/>';
            echo $string;
    }
/*
$value[] = [
           
     

                
                'date_add'=>$v->add_date,
                'name_add'=>  isset($this->member[$v->add_name])?$this->member[$v->add_name]:'',
                'date_edit'=>$v->edit_date,
                'name_edit'=>  isset($this->member[$v->edit_name])?$this->member[$v->edit_name]:''
            ];
 *  */
    private $category; private $tags; private $vpage; private $member; private $vpage_category=0;
    private function getDataImport(){
        $category = $this->getDB->table('page')->select('id',lang.'name AS name')->where('typepage',2)->get();
        foreach ($category as $v) { $this->category[$v->name] = $v->id; }
        $tags = $this->getDB->table('tags')->select('id',lang.'name AS name')->where('typepage0',0)->get();
        foreach ($tags as $v) { $this->tags[$v->name] = $v->id; }
        $vpages = $this->getDB->table('v_page')->select('id','name')->where('typepage',2)->get();
        foreach ($vpages as $v) { $this->vpage[$v->name] = $v->id; }
        $vpage_category = $this->getDB->table('v_page')->select('id')->where('typepage',2)->orderBy('order','ASC')->orderBy('id','ASC')->first();
        if(isset($vpage_category->id)){$this->vpage_category = $vpage_category->id;}
    }

    private function getDataExport(){
        $category = $this->getDB->table('page')->select('id',lang.'name AS name')->where('typepage',2)->get();
        foreach ($category as $v) { $this->category[$v->id] = $v->name; }
        $tags = $this->getDB->table('tags')->select('id',lang.'name AS name')->where('typepage0',0)->get();
        foreach ($tags as $v) { $this->tags[$v->id] = $v->name; }
        $vpages = $this->getDB->table('v_page')->select('id','name')->where('typepage',2)->get();
        foreach ($vpages as $v) { $this->vpage[$v->id] = $v->name; }
        $members = $this->getDB->table('useradmin')->select('id','fullname')->get();
        foreach ($members as $v) { $this->member[$v->id] = $v->fullname; }
    }
}
