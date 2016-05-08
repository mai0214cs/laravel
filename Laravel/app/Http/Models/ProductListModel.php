<?php
namespace App\Http\Models;
use App\Common\SelectList;
use App\Common\WriteLink;
use App\Common\UpdateMenu;
use App\Common\CheckDateTime;
use App\Common\ReturnImage;
use App\Common\InfoMessage;
class ProductListModel extends Model {
    private $titleadmin=array();    private $info;
    public function __construct($setup) {
        parent::__construct();
        $this->titleadmin = $setup;
        $this->info = new InfoMessage();
    }

    // Lấy danh sách dữ liệu
    public function data(){
        $data = $this->getDB->table('page')->select('id AS idpage','id_category AS idcategory',lang.'name AS namepage')->where('typepage',5)->orderBy('order','ASC')->orderBy('id','DESC')->get();
        $menu = new UpdateMenu(); 
        $result = $this->getDB->select('SELECT
a.id AS idpage,a.'.lang.'name AS namepage,a.'.lang.'avatar AS avatar,b.code,b.price,c.name AS idcategory,a.url,d.id,d.name, a.'.lang.'status AS status,a.order,a.views
FROM page AS a LEFT JOIN product AS b ON a.id = b.id_page LEFT JOIN page AS c ON a.id_category=c.id LEFT JOIN v_page AS d ON a.id_vpage=d.id
WHERE a.typepage=6 ORDER BY a.order ASC, a.id DESC LIMIT 0,20');
        /*$result = $this->getDB->table('page AS a')->leftJoin('v_page AS b','a.id_vpage','=','b.id')
                ->select('a.id AS idpage','a.id_category AS idcategory','a.'.lang.'name AS namepage','b.id', 'b.name','a.url','a.'.lang.'status AS status','a.order','a.views','a.'.lang.'avatar AS avatar')
                ->where('a.typepage','=',6)->orderBy('a.order', 'ASC')->orderBy('a.id', 'DESC')->get();*/
        return array($this->titleadmin, $result, $menu->ListMenu($data, 0, '')); 
    }
    // Dữ liệu hiển thị Form
    public function datainsert(){
        $group = $this->getDB->table('group_attribute')->select('id',lang.'name AS name')->orderBy('order','ASC')->orderBy('id','DESC')->get();
        $coung = count($group); $itemgroup=array(); 
        for ($i = 0; $i < $coung; $i++) {
            $itemgroup[$group[$i]->id] = $this->getDB->table('attribute')->select('id',lang.'value AS value')->where('id_group',$group[$i]->id)->orderBy('order','ASC')->orderBy('id','DESC')->get();
        }
        
        return [
            'data'=>array($this->titleadmin),
            'categoryproduct'=>SelectList::MenuCategory(),
            'procedureproduct'=>SelectList::Procedure(),
            'group_attribute'=>$group,
            'item_attribute'=>$itemgroup,
            'categorynews'=>  SelectList::MenuCategory(2),
            'tags'=>  SelectList::Tags(1),
            'page'=>  SelectList::VPage(5),
            'location'=>$this->getDB->table('location')->select('id',lang.'name AS name')->orderBy('id','ASC')->get()
        ];
    }
    
    public function getCategoryNews(){
        $data = $this->getDB->table('page')->select('id',lang.'name AS name')->where('typepage',3)->orderBy('order','ASC')->orderBy('id','DESC')->get();
        foreach ($data as $v) {
            echo '<option ondblclick="SelectListNews($(this))" value="'.$v->id.'">'.$v->name.'</option>';
        }
    }
    public function getCategoryProduct(){
        $data = $this->getDB->table('page')->select('id',lang.'name AS name')->where('typepage',6)->orderBy('order','ASC')->orderBy('id','DESC')->get();
        foreach ($data as $v) {
            echo '<option ondblclick="SelectListProduct($(this))" value="'.$v->id.'">'.$v->name.'</option>';
        }
    }
    
    
    public function dataupdate($id){
        $group = $this->getDB->table('group_attribute')->select('id',lang.'name AS name')->orderBy('order','ASC')->orderBy('id','DESC')->get();
        $coung = count($group); $itemgroup=array(); 
        for ($i = 0; $i < $coung; $i++) {
            $itemgroup[$group[$i]->id] = $this->getDB->table('attribute')->select('id',lang.'value AS value')->where('id_group',$group[$i]->id)->orderBy('order','ASC')->orderBy('id','DESC')->get();
        }
        $pageproduct = $this->getDB->table('page')->select('id',lang.'name AS name', lang.'description AS description', lang.'detail AS detail', 'id_category', 'url', lang.'seo_title AS seo_title', lang.'seo_keyword AS seo_keyword', lang.'seo_description AS seo_description', 'ids_tags', 'status', 'order', 'views', 'ids_news_related', 'ids_product_related', 'typepage', 'id_vpage', lang.'avatar AS avatar')->where('id',$id)->where('typepage',6)->first();
        $product = $this->getDB->table('product')->select('code', 'cost', 'price', 'promotion_price', 'promotion_start', 'promotion_end', 'goldtime', 'goldtime_start', 'goldtime_end', 'options_price', lang.'images AS images', lang.'videos AS videos', lang.'tabs AS tabs', lang.'infos AS infos', 'id_procedure', 'ids_attribute', 'ids_location', 'count_check', 'count', 'count_unit', lang.'warranty AS warranty')->where('id_page',$id)->first();
        $product_related = $this->getDB->table('page')->select('id',lang.'name AS name')->whereIn('id',  explode(',', trim($pageproduct->ids_product_related, ',')))->where('typepage',6)->get();
        $news_related = $this->getDB->table('page')->select('id',lang.'name AS name')->whereIn('id',  explode(',', trim($pageproduct->ids_news_related, ',')))->where('typepage',3)->get();
        $pageproduct->avatar = ReturnImage::Image($pageproduct->avatar); 
                //print_r($this->getDB->table('location')->select('id',lang.'name AS name')->orderBy('id','ASC')->get()); exit();
        return [
            'data'=>array($this->titleadmin),
            'categoryproduct'=>SelectList::MenuCategory(),
            'procedureproduct'=>SelectList::Procedure(),
            'group_attribute'=>$group,
            'item_attribute'=>$itemgroup,
            'categorynews'=>  SelectList::MenuCategory(2),
            'product_related'=>$product_related,
            'news_related'=>$news_related,
            'tags'=>  SelectList::Tags(1),
            'page'=>  SelectList::VPage(5),
            'location'=>$this->getDB->table('location')->select('id',lang.'name AS name')->orderBy('id','ASC')->get(),
            'pageproduct'=>$pageproduct,
            'product'=>$product
        ];
    }
    
    

    // Thêm dữ liệu vào danh sách
    // - 1. Lấy POST thông tin giá tùy chọn
    private function priceoption($code_a, $name_a, $image_a, $price_a){ $data = '';
        if(!(is_array($code_a)&&is_array($name_a)&&is_array($image_a)&&is_array($price_a))){return $data;}
        for ($i = 0; $i < count($code_a); $i++) {
            if(isset($name_a[$i])&&isset($image_a[$i])&&isset($price_a[$i])){
                $data.='<item><code>'.$this->xml_entities($code_a[$i]).'</code><name>'.$this->xml_entities($name_a[$i]).'</name><price>'.(is_numeric($price_a[$i]?($price_a[$i]>=0?(int) $price_a[$i]:0):0)).'</price><avatar>'.ReturnImage::Image($image_a[$i]).'</avatar></item>'; // Cần kiểm tra kỹ ở đây
            }
        }
        return $data;
    }
    // - 2. Lấy thông tin thuộc tính   
    private function filter_product($vals){
        if(!is_array($vals)){return '';} $arr = array();
        foreach ($vals as $v) {
            if($this->getDB->table('attribute')->where('id',$v)->count()==1){$arr[] = $v;}
        }
        return implode(',', $arr);
    }
    // - 3. Lấy danh sách ảnh sản phẩm
    private function imageproduct($images){
        if(!is_array($images)){return '';} $arr = array();
        foreach ($images as $v) {
            if(is_file(trim($v, '/'))){$arr[] = $v;}
        }
        return implode(',', $arr);
    }
    // - 4. Lấy danh sách video
    private function videoproduct($url){
        if(!is_array($url)){return '';} 
        return implode(',', $url);
    }
    // - 5. Lấy danh sách thông số sản phẩm
    private function info_product($title_a, $content_a){ $data = '';
        if(!(is_array($title_a)&&is_array($content_a))){return $data;}
        for ($i = 0; $i < count($title_a); $i++) {
            if(isset($content_a[$i])){
                // cant edit review
                $data.='<item><title>'.$this->xml_entities($title_a[$i]).'</title><content>'.$this->xml_entities($content_a[$i]).'</content></item>'; 
            }
        }
        return $data;
    }
    // - 8. Check Danh mục sản phẩm, Nhà sản xuất, Trang hiển thị
    private function check_info_post_category_product($category, $procedure, $pageview){
        if($this->getDB->table('page')->where('id',$category)->where('typepage',5)->count()!=1){
            \Session::flash('message_error',$this->titleadmin['Danh mục sản phẩm không tồn tại']);
            return FALSE;
        }
        if($procedure!=0){
            if($this->getDB->table('page')->where('id',$procedure)->where('typepage',8)->count()!=1){
                \Session::flash('message_error',$this->titleadmin['Nhà sản xuất không tồn tại']);
                return FALSE;
            }
        }
        if($this->getDB->table('v_page')->where('id',$pageview)->where('typepage',5)->count()!=1){
            \Session::flash('message_error',$this->titleadmin['Trang hiển thị không tồn tại']);
            return FALSE;
        }
        return TRUE;
    }
    // - 9. Lấy thông tin liên quan
    private function save_list_related($ids,$type){
        $arr = array(); $arr_old = explode(',', $ids);
        foreach ($arr_old as $v) {
            if($this->getDB->table('page')->where('id',$v)->where('typepage',$type)->count()==1){$arr[]=$v;}
        }
        return implode(',', $arr);
    }
    // - 10. Lấy thông tin tags sản phẩm
    private function info_tags_product($tags){
        if(!is_array($tags)){return '';}$arr = array();
        foreach ($tags as $v) {
            if($this->getDB->table('tags')->where('id',$v)->where('typepage0',1)->count()==1){ $arr[] = $v; }
        }
        return implode(',', $arr);
    }
    // - 11. Lấy thông tin địa điểm mua hàng
    private function info_location($location){
        if(!is_array($location)){return '';}$arr = array();
        foreach ($location as $v) {
            if($this->getDB->table('location')->where('id',$v)->count()==1){ $arr[] = $v; }
        }
        return implode(',', $arr);
    }
    private function Checkdate_Promotion($date){
        $ex = explode('-', $date);
        if(!CheckDateTime::CheckDate($ex[0])||!CheckDateTime::CheckDate($ex[1])){
            return array(date('Y-m-d'),date('Y-m-d'));
        }
        return array(date_format($ex[0], 'm/d/Y'),date_format($ex[1], 'm/d/Y'));
    }
    private function xml_entities($string) {
        return str_replace(array("&", "<", ">", '"', "'"), array("&amp;", "&lt;", "&gt;", "&quot;", "&apos;"), $string);
    }
    public function insert($post){
        $wlink = new WriteLink();
        $priceoption = (isset($post['PriceOptionsCode'])&&isset($post['PriceOptionsName'])&&isset($post['AvatarOption'])&&isset($post['PriceOptionsPriceAdd']))?$this->priceoption($post['PriceOptionsCode'],$post['PriceOptionsName'],$post['AvatarOption'],$post['PriceOptionsPriceAdd']):'';
        $filter_product = isset($post['filter_product'])?$this->filter_product($post['filter_product']):'';
        $image_product = isset($post['ImageProduct'])?$this->imageproduct($post['ImageProduct']):'';
        $video_product = isset($post['VideoProduct'])?$this->videoproduct($post['VideoProduct']):'';
        $info_product = (isset($post['InfoProductTitle'])&&isset($post['InfoProductContent']))?$this->info_product($post['InfoProductTitle'],$post['InfoProductContent']):'';
        $tabproduct = '';
        for ($i = 1; $i < 6; $i++) {
            // cant edit review
            $tabproduct .= '<item><title>'.$this->xml_entities($post['tab_title_'.$i]).'</title><content>'.$this->xml_entities($post['tab_content_'.$i]).'</content></item>'; 
        }
        $tags = isset($post['tags'])?$this->info_tags_product($post['tags']):'';
        $location = isset($post['location'])?$this->info_location($post['location']):'';
        $date = $this->Checkdate_Promotion($post['promotion_date']);
        if(!$this->check_info_post_category_product($post['category'], $post['procedure'], $post['vpage'])){
            return FALSE;
        }
        $datainfo = [
            lang.'name'=>$post['name'], 
            lang.'description'=>$post['description'],
            lang.'detail'=>$post['detail'],
            'id_category'=>$post['category'], 
            lang.'avatar'=>is_file(trim($post['avatar'], '/'))?$post['avatar']:'',
            'order'=>$post['order'], 
            lang.'status'=>1,
            'views'=>0,
            'url'=> $wlink->Link($post['name'], $post['url'], 0),
            lang.'seo_title'=>$post['seo_title'],
            lang.'seo_keyword'=>$post['seo_title'],
            lang.'seo_description'=>$post['seo_description'],
            'ids_news_related'=>$this->save_list_related($post['DataNewsRelated'],3), 
            'ids_product_related'=>$this->save_list_related($post['DataProductRelated'],6),
            'typepage'=>6,
            lang.'id_vpage'=>$post['vpage'], 
            'add_date'=>  date('Y/m/d h:i:s'), 
            'add_name'=>\Session::get('UserAdmin')->id,
            lang.'ids_tags'=>$tags
        ];
        
        $insertGetId = $this->getDB->table('page')->insertGetId($datainfo);
        if(!$insertGetId){
            \Session::flash('message_error',$this->titleadmin['Thêm sản phẩm thất bại']);
            return FALSE;
        }
        $dataproduct = [
            'id_page'=>$insertGetId,
            'code'=>$post['code'],
            'cost'=>$post['cost'], 
            'price'=>$post['price'], 
            'promotion_price'=>$post['promotion_price'], 
            'promotion_start'=>$date[0],
            'promotion_end'=>$date[1],
            'goldtime'=>$post['goldtime_price'], 
            'goldtime_start'=>$post['goldtime_start'], 
            'goldtime_end'=>$post['goldtime_end'], 
            'id_procedure'=>$post['procedure'], 
            'count_check'=>$post['check_count'], 
            'count'=>$post['sale_count'], 
            'ids_location'=>$location,
            lang.'count_unit'=>$post['unit_count'],
            lang.'warranty'=>$post['warranty'],
            lang.'tabs'=>$tabproduct,
            lang.'options_price'=>$priceoption,
            'ids_attribute'=>$filter_product,
            lang.'images'=>$image_product,
            lang.'videos'=>$video_product,
            lang.'infos'=>$info_product
        ];
        if(!$this->getDB->table('product')->insert($dataproduct)){
            \Session::flash('message_error',$this->titleadmin['Đã xảy ra lỗi khi Thêm sản phẩm']); return FALSE;
        }else{
            \Session::flash('message_success',$this->titleadmin['Thêm sản phẩm thành công']); return TRUE;
        }
    }
    
    
    // Cập nhật dữ liệu vào danh sách
    public function update($post){
        $wlink = new WriteLink();
        $priceoption = (isset($post['PriceOptionsCode'])&&isset($post['PriceOptionsName'])&&isset($post['AvatarOption'])&&isset($post['PriceOptionsPriceAdd']))?$this->priceoption($post['PriceOptionsCode'],$post['PriceOptionsName'],$post['AvatarOption'],$post['PriceOptionsPriceAdd']):'';
        $filter_product = isset($post['filter_product'])?$this->filter_product($post['filter_product']):'';
        $image_product = isset($post['ImageProduct'])?$this->imageproduct($post['ImageProduct']):'';
        $video_product = isset($post['VideoProduct'])?$this->videoproduct($post['VideoProduct']):'';
        $info_product = (isset($post['InfoProductTitle'])&&isset($post['InfoProductContent']))?$this->info_product($post['InfoProductTitle'],$post['InfoProductContent']):'';
        $tabproduct = '';
        for ($i = 1; $i < 6; $i++) {
            $tabproduct .= '<item><title>'.$this->xml_entities($post['tab_title_'.$i]).'</title><content>'.$this->xml_entities($post['tab_content_'.$i]).'</content></item>'; 
        }
        $tags = isset($post['tags'])?$this->info_tags_product($post['tags']):'';
        $location = isset($post['location'])?$this->info_location($post['location']):'';
        $date = $this->Checkdate_Promotion($post['promotion_date']);
        if(!$this->check_info_post_category_product($post['category'], $post['procedure'], $post['vpage'])){
            return FALSE;
        }
        $idpage = $post['idpage'];
        $datainfo = [
            lang.'name'=>$post['name'], 
            lang.'description'=>$post['description'],
            lang.'detail'=>$post['detail'],
            'id_category'=>$post['category'], 
            lang.'avatar'=>is_file(trim($post['avatar'], '/'))?$post['avatar']:'',
            'order'=>$post['order'], 
            lang.'status'=>1,
            'views'=>0,
            'url'=> $wlink->Link($post['name'], $post['url'], $idpage),
            lang.'seo_title'=>$post['seo_title'],
            lang.'seo_keyword'=>$post['seo_title'],
            lang.'seo_description'=>$post['seo_description'],
            'ids_news_related'=>$this->save_list_related($post['DataNewsRelated'],3), 
            'ids_product_related'=>$this->save_list_related($post['DataProductRelated'],6),
            'typepage'=>6,
            lang.'id_vpage'=>$post['vpage'], 
            'add_date'=>  date('Y/m/d h:i:s'), 
            'add_name'=>\Session::get('UserAdmin')->id,
            lang.'ids_tags'=>$tags
        ];
        
        $this->getDB->table('page')->where('id',$idpage)->where('typepage',6)->update($datainfo);
        $dataproduct = [
            'code'=>$post['code'],
            'cost'=>$post['cost'], 
            'price'=>$post['price'], 
            'promotion_price'=>$post['promotion_price'], 
            'promotion_start'=>$date[0],
            'promotion_end'=>$date[1],
            'goldtime'=>$post['goldtime_price'], 
            'goldtime_start'=>$post['goldtime_start'], 
            'goldtime_end'=>$post['goldtime_end'], 
            'id_procedure'=>$post['procedure'], 
            'count_check'=>$post['check_count'], 
            'count'=>$post['sale_count'], 
            'ids_location'=>$location,
            lang.'count_unit'=>$post['unit_count'],
            lang.'warranty'=>$post['warranty'],
            lang.'tabs'=>$tabproduct,
            lang.'options_price'=>$priceoption,
            'ids_attribute'=>$filter_product,
            lang.'images'=>$image_product,
            lang.'videos'=>$video_product,
            lang.'infos'=>$info_product
        ];
        if(!$this->getDB->table('product')->where('id_page',$idpage)->update($dataproduct)){
            \Session::flash('message_error',$this->titleadmin['Sửa sản phẩm thất bại']); return FALSE;
        }else{
            \Session::flash('message_success',$this->titleadmin['Sửa sản phẩm thành công']); return TRUE;
        }
    }
    
    // Xóa sản phẩm
    public function delete($get){
        $count = 0;
        foreach ($get as $v){
            $this->getDB->table('product')->where('id_page',$v)->delete();
            $count = $this->getDB->table('page')->where('id',$v)->where('typepage',6)->delete()>0?$count+1:$count;
        }
        return $count;
    }
    
    // Update data
    public function updatedataproduct($get){
        switch ($get['code']){
            case 1: 
                if($this->getDB->table('product')->where('id_page',$get['id'])->update(array('code'=>$get['val']))>0){
                    echo $this->info->Success($this->titleadmin['Cập nhật mã sản phẩm thành công']);
                }else{
                    echo $this->info->Error($this->titleadmin['Cập nhật mã sản phẩm thất bại']);
                }
                return;
            case 2: 
                if(!is_numeric($get['val'])){echo $this->info->Error($this->titleadmin['Giá bán bắt buộc phải nhập số nguyên lớn hơn hoặc bằng 0']); return;}
                if($get['val']<0){echo $this->info->Error($this->titleadmin['Giá bán bắt buộc phải nhập số nguyên lớn hơn hoặc bằng 0']); return;}
                if($this->getDB->table('product')->where('id_page',$get['id'])->update(array('price'=>$get['val']))>0){
                    echo $this->info->Success($this->titleadmin['Cập nhật giá bán sản phẩm thành công']);
                }else{
                    echo $this->info->Error($this->titleadmin['Cập nhật giá bán sản phẩm thất bại']);
                }
                return;
            case 3: 
                if($this->getDB->table('page')->where('id',$get['id'])->where('typepage',6)->update(array(lang.'status'=>$get['val']))>0){
                    echo $this->info->Success($this->titleadmin['Cập nhật trạng thái hiển thị sản phẩm thành công']);
                }else{
                    echo $this->info->Error($this->titleadmin['Cập nhật trạng thái hiển thị sản phẩm thất bại']);
                }
                return;
            case 4: 
                if($this->getDB->table('page')->where('id',$get['id'])->where('typepage',6)->update(array('order'=>$get['val']))>0){
                    echo $this->info->Success($this->titleadmin['Cập nhật thứ tự hiển thị sản phẩm thành công']);
                }else{
                    echo $this->info->Error($this->titleadmin['Cập nhật thứ tự hiển thị sản phẩm thất bại']);
                }
                return;
            default:
                echo $this->info->Error($this->titleadmin['Lựa chọn không được chấp nhận']);
                return;
        }
    }
    // Tim kiem san pham
    public function updatelist($get){
        $rs = $this->getDB->table('page AS a')->leftJoin('product AS b', 'a.id', '=', 'b.id_page')
            ->select('a.id AS idpage', 'a.'.lang.'name AS namepage', 'a.id_category', 'a.url', 
                    'a.'.lang.'status AS status', 'a.order', 'a.views', 'a.id_vpage', 
                    'a.'.lang.'avatar AS avatar', 'b.id_page', 
                    'b.code', 'b.price')->where('a.typepage',6);
        // Chọn từ khóa
        if($get['key']!=''){
            $rs = $rs->where('a.'.lang.'name','LIKE', '%'.$get['key'].'%')->orwhere('b.code','LIKE','%'.$get['key'].'%');
        }
        // Chọn danh mục
        if($get['category']!=0){
            $rs = $rs->where('a.id_category', $get['category']);
        }
        $count = is_numeric($get['count'])?((int) $get['count']>1&&$get['count']<500)?(int) $get['count']:20:20;
        $item =  is_numeric($get['item'])?((int) $get['item']-1)<0?0:(int) $get['item']-1:0;
        
        // Sắp xếp danh sách
        switch ($get['order']){
            case 0: $rs = $rs->orderBy('a.id', 'DESC'); break;
            case 1: $rs = $rs->orderBy('a.id', 'ASC'); break;
            case 2: $rs = $rs->orderBy('a.'.lang.'name', 'ASC'); break;
            case 3: $rs = $rs->orderBy('a.'.lang.'name', 'DESC'); break;
            case 4: $rs = $rs->orderBy('b.price', 'ASC'); break;
            case 5: $rs = $rs->orderBy('b.price', 'DESC'); break;
            case 6: $rs = $rs->orderBy('a.views', 'DESC'); break;
        }
        $coutpage = ceil($rs->count()/$count);$pagecount = '';
        for($i=1; $i<=$coutpage; $i++){
            $pagecount.='<option value="'.$i.'">Trang '.$i.'</option>';
        }
        $result = $rs->take($count)->skip($item*$count)->get(); $content = '';
        $this->getCategory(0, 5); $this->getCategory(0, 6);
        
        foreach ($result as $v) {
            $content.='<tr>
                <td><input type="checkbox" class="CheckAll" rel="'.$v->idpage.'" /></td>
                <td><a href="/admin/product/list/edit/'.$v->idpage.'">'.$v->namepage.'</a></td>
                <td><input class="form-control" type="text" value="'.$v->code.'" onblur="UpdateDataProduct($(this).val(),'.$v->idpage.',1)" /></td>
                <td><input class="form-control" type="number" value="'.$v->price.'" onblur="UpdateDataProduct($(this).val(),'.$v->idpage.',2)" /></td>
                <td><img src="'.ReturnImage::Image($v->avatar).'" alt="'.$v->namepage.'" style="width:50px;" /></td>
                <td><a target="_blink" href="/'.lang.'/'.$v->url.'">'.lang.'/'.$v->url.'</a></td>
                <td><a target="_blink" href="/admin/design/page/'.$v->id_vpage.'">'.$this->getProduct($v->id_vpage, 6).'</a></td>
                <td><input type="checkbox" '.($v->status==1?'checked="checked"':'').' onclick="UpdateDataProduct(this.checked?1:0,'.$v->idpage.',3)" /></td>
                <td><input class="form-control" type="number" value="'.$v->order.'" onblur="UpdateDataProduct($(this).val(),'.$v->idpage.',4)" /></td>
                <td>'.$v->views.'</td>
                <td>
                    <a href="/admin/product/list/edit/'.$v->idpage.'">'.$this->titleadmin['Nút Sửa Danh sách'].'</a>
                    <a onclick="return window.confirm(\''.$this->titleadmin['Xác nhận Xóa Danh sách sản phẩm'].'\')" href="/admin/product/list/delete/'.$v->idpage.'">'.$this->titleadmin['Nút Xóa danh dách'].'</a>
                </td>
            </tr>';
        }
        echo json_encode(array('pagecount'=>$pagecount, 'content'=>$content));
    }
    private $Product5 = NULL; // Danh muc san pham
    private $Product7 = NULL; // Tags san pham
    private $Product8 = NULL; // Nha san xuat
    private $Product6 = NULL; // Page hien thi
    private $Product9 = NULL; // Danh sach san pham
    private $Product10 = NULL; // Danh sach tin tuc
    private $Product11 = NULL; // Thuoc tinh san pham
    private $Product12 = NULL; // Tag san pham
    private $Product13 = NULL; // Địa điểm bán
    private $Product0 = NULL; // Tác giả
    private function getCategory($type=0, $typepage=4){
        if($typepage!=5){
            $get = $this->getDB->table('page')->select('id',lang.'name AS name')->where('typepage',$typepage)->get();
        }else{
            $get = $this->getDB->table('v_page')->select('id', 'name')->where('typepage',5)->get();
        }
        foreach ($get as $v) {
            if($type==0){
                $this->{'Product'.$typepage}[$v->id] = $v->name;
            }else{
                $this->{'Product'.$typepage}[$v->name] = $v->id;
            }
        }
    }
    private function getProduct($id_or_name, $type=5){
            return isset($this->{'Product'.$type}[$id_or_name])?$this->{'Product'.$type}[$id_or_name]:'';
    }
    private function GetProductR($type=0, $typepage=6, $code=9){
        $data = $this->getDB->table('page')->select('id',lang.'name AS name')->where('typepage',$typepage)->get();
        foreach ($data as $v) {
            if($type!=0){
                $this->{'Product'.$code}[$v->id] = $v->name;
            }else{
                $this->{'Product'.$code}[$v->name] = $v->id;
            }
        }
    }
    private function getAuthor(){
        $data = $this->getDB->table('useradmin')->select('id','fullname AS name')->get();
        foreach ($data as $v) {
            $this->Product0[$v->id] = $v->name;
        }
    }
    public function getAttribute($type=0){
        $data = $this->getDB->table('attribute')->select('id',lang.'value AS name')->get();
        foreach ($data as $v) {
            if($type!=0){
                $this->Product11[$v->id] = $v->name;
            }else{
                $this->Product11[$v->name] = $v->id;
            }
        }
    }
    public function getTags($type=0){
        $data = $this->getDB->table('tags')->select('id',lang.'name AS name')->where('typepage0',1)->get();
        foreach ($data as $v) {
            if($type!=0){
                $this->Product12[$v->id] = $v->name;
            }else{
                $this->Product12[$v->name] = $v->id;
            }
        }
    }
    private function getLocation($type=0){
        $data = $this->getDB->table('location')->select('id',lang.'name AS name')->get();
        foreach ($data as $v) {
            if($type!=0){
                $this->Product13[$v->id] = $v->name;
            }else{
                $this->Product13[$v->name] = $v->id;
            }
        }
    }

    public function exportExcel(){
        $rs = $this->getDB->table('page AS a')->leftJoin('product AS b', 'a.id', '=', 'b.id_page')
            ->select('a.id', 'a.'.lang.'name AS name', 'a.'.lang.'description AS description', 'a.'.lang.'detail AS detail', 'a.id_category', 'a.url', 
            'a.'.lang.'seo_title AS seo_title', 'a.'.lang.'seo_keyword AS seo_keyword', 'a.'.lang.'seo_description AS seo_description', 
            'a.ids_tags', 'a.'.lang.'status AS status', 'a.order', 'a.views', 'a.ids_news_related', 'a.ids_product_related',
            'a.'.lang.'id_vpage AS id_vpage', 'a.add_date', 'a.add_name', 'a.edit_date', 'a.edit_name', 'a.'.lang.'avatar AS avatar', 'b.code', 'b.cost',
            'b.price', 'b.promotion_price', 'b.promotion_start', 'b.promotion_end', 'b.goldtime', 'b.goldtime_start',
            'b.goldtime_end', 'b.'.lang.'options_price AS options_price', 'b.'.lang.'images AS images', 'b.'.lang.'videos AS videos', 'b.'.lang.'tabs AS tabs', 'b.'.lang.'infos AS infos', 'b.id_procedure',
            'b.ids_attribute', 'b.ids_location', 'b.count_check', 'b.count', 'b.count_unit', 'b.'.lang.'warranty AS warranty')->where('a.typepage',6)->get();
            $this->getCategory(0,5); 
            $this->getCategory(0,6);
            $this->getCategory(0,7);
            $this->getCategory(0,8);
            $this->GetProductR(0, 6, 9);
            $this->GetProductR(0, 3, 10);
            $this->getAuthor();
            $this->getAttribute(0);
            $this->getTags(0); $this->getLocation(0);
            foreach ($rs as $v) {
                // Lấy danh sách tags
                $tags = array(); $listidtags = explode(',', $v->ids_tags);
                foreach ($listidtags as $vi) {
                    $ve = $this->getProduct($vi,12);
                    if($ve!=''){$tags[] =$ve;}
                }
                // Lấy danh sách Tin tức liên quan
                $newsrelated = array(); $listnewsrelated = explode(',', $v->ids_news_related);
                foreach ($listnewsrelated as $vi) {
                    $ve = $this->getProduct($vi,10);
                    if($ve!=''){$newsrelated[] = $ve;}
                }
                // Lấy danh sách Sản phẩm liên quan
                $productrelated = array(); $listproductrelated = explode(',', $v->ids_news_related);
                foreach ($listproductrelated as $vi) {
                    $ve = $this->getProduct($vi,9);
                    if($ve!=''){$productrelated[] = $ve;}
                }
                // Lấy danh sách thuộc tính sản phẩm
                $productattribute = array(); $listproductattribute = explode(',', $v->ids_attribute);
                foreach ($listproductattribute as $vi) {
                    $ve = $this->getProduct($vi,11);
                    if($ve!=''){$productattribute[] = $ve;}
                }
                // Lấy danh sách địa điểm bán
                $productlocation = array(); $listproductlocation = explode(',', $v->ids_location);
                foreach ($listproductlocation as $vi) {
                    $ve = $this->getProduct($vi,13);
                    if($ve!=''){$productlocation[] =$ve;}
                }
                
                $value[] = array(
                    'id'=>$v->id, 
                    'name'=>$v->name, 
                    'name'=>$v->description, 
                    'name'=>$v->detail, 
                    'category'=>$this->getProduct($v->id_category,5), 
                    'url'=>$v->url,
                    'tag_title'=>$v->seo_title, 
                    'meta_keyword'=>$v->seo_keyword, 
                    'meta_description'=>$v->seo_description, 
                    'tags'=>implode(',', $tags),
                    'status'=>$v->status, 
                    'order'=>$v->order, 
                    'views'=>$v->views, 
                    'news_related'=>  implode(',', $newsrelated), 
                    'product_related'=>  implode(',', $productrelated),
                    'page_view'=>$this->getProduct($v->id_vpage, 6), 
                    'Add_date'=>$v->add_date, 
                    'Add_name'=>$this->getProduct($v->add_name, 0), 
                    'Edit_date'=>$v->edit_date, 
                    'Edit_name'=>$this->getProduct($v->edit_name, 0), 
                    'avatar'=>$v->avatar, 
                    
                    'code'=>$v->code, 
                    'cost'=>$v->cost,
                    'price'=>$v->price, 
                    'promotionprice'=>$v->promotion_price, 
                    'beginpromotion'=>$v->promotion_start, 
                    'endpromotion'=>$v->promotion_end, 
                    'goldprice'=>$v->goldtime, 
                    'begingold'=>$v->goldtime_start, 
                    'endgold'=>$v->goldtime_end,
                    'priceoptions'=>$v->options_price, 
                    'images'=>$v->images, 
                    'videos'=>$v->videos, 
                    'tabs'=>$v->tabs, 
                    'infos'=>$v->infos, 
                    'procedure'=>$this->getProduct($v->id_procedure, 8),
                    'attributes'=>implode(',', $productattribute),
                    'locations'=>implode(',', $productlocation), 
                    'checkcount'=>$v->count_check, 
                    'count'=>$v->count, 
                    'unitcount'=>$v->count_unit, 
                    'warranty'=>$v->warranty
                );
            }
        \Maatwebsite\Excel\Facades\Excel::create('Mai0214cs', function($excel) use($value){
            $excel->sheet('Sheet1', function($sheet) use($value){
                $sheet->fromArray($value);
            });
        })->export('xls');
    }
   
    // Import Database
    public function importExcel($get){
        if(count($this->vpage_category)==0){
            echo $this->titleadmin['Không thể import Sản phẩm do thiếu thiết lập']; return; // ERROR: Không thể import do không tồn tại view danh mục sản phẩm và nhà sản xuất
        } 
        $this->GetDataImport(); $wlink = new WriteLink();
        $data = \Maatwebsite\Excel\Facades\Excel::load(trim($get['url'], '/'))->get();
        //var_dump($data);
        $count_error[] = 0; $count = 1; $count_success = 0; $count_category = 0; $count_location = 0; $count_tags=0;
        foreach ($data as $v) {
            $count++;
            
            // Test Sự tổn tại của các field ID, Name, Category, Page_View
            if(!(isset($v->id)&&isset($v->name)&&isset($v->category)&&isset($v->page_view))){
                echo $this->titleadmin['Không thể import Sản phẩm do thiếu data']; return FALSE; 
            }
            // Get Id, Set Field default
            $id = $v->id; $table_page = array(); $table_product = array();
            // Set Name
            if(trim($v->name)==''){
                $count_error[] = array($count,'Name'); continue; // ERROR: Tiêu đề sản phẩm không được để trống
            }
            $table_page[lang.'name'] = trim($v->name); 
            // Test Danh mục sản phẩm
            if(isset($this->category[$v->category])){
                $id_category = $this->category[$v->category];
            }else{
                $data = [
                    lang.'name'=>$v->category, 'url'=>$wlink->Link($v->category, '', 0),
                    'add_date'=>  date('Y/m/d h:i:s'), 'add_name'=>\Session::get('UserAdmin')->id,
                    'typepage'=>5, lang.'id_vpage'=>$this->vpage_category, lang.'status'=>1
                ];
                $id_category = $this->getDB->table('page')->insertGetId($data);
                $this->category[$v->category] = $id_category; $count_category++;
            }
            $table_page['id_category'] = $id_category;
            // Test Tags sản phẩm
            $tags = array();
            if(isset($v->tags)){
                if(trim($v->tags)!=''){
                    $listtags = explode(',', $v->tags); 
                    foreach ($listtags as $tag) {
                        if(isset($this->tags[trim($tag)])){
                            $tags[] = $this->tags[trim($tag)];
                        }else{
                            if(trim($tag)!=''){
                                $tagid = $this->getDB->table('tags')->insertGetId([lang.'name'=>trim($tag),'typepage0'=>1]);$count_tags++;
                                $this->tags[trim($tag)] = $tagid; $tags[] = $tagid;
                            }
                        }
                    }
                    $table_page['ids_tags'] = implode(',', $tags);
                }
            }
            // Test Tin tức liên quan
            $news = array();
            if(isset($v->news_related)){
                $news_related = explode(',', $v->news_related); 
                foreach ($news_related as $v1) {
                    if(isset($this->news[trim($v1)])){
                        $news[] = $this->news[trim($v1)];
                    }
                }
                $table_page['ids_news_related'] = implode(',', $news);
            }
            // Test Sản phẩm liên quan
            $product = array();
            if(isset($v->product_related)){
                $product_related = explode(',', $v->product_related); 
                foreach ($product_related as $v1) {
                    if(isset($this->product[trim($v1)])){
                        $product[] = $this->product[trim($v1)];
                    }
                }
                $table_page['ids_product_related'] = implode(',', $product);
            }
            // Test Page hiển thị trang
            if(!isset($this->vpage[$v->page_view])){
                $count_error[] = array($count,'Page_View'); continue; // ERROR: Page hiển thị trang không tồn tại
            }
            // Get Field 
            if(isset($v->avatar)){ $table_page[lang.'avatar'] = ReturnImage::Image($v->avatar); }
            if(isset($v->description)){ $table_page[lang.'description'] = $v->description; } 
            if(isset($v->detail)){ $table_page[lang.'detail'] = $v->detail; }
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
            $table_page['typepage'] = 6;
            if($id==0||$id==''){
                $table_page['add_date'] = date('Y/m/d h:i:s');
                $table_page['add_name'] = \Session::get('UserAdmin')->id;
            }else{
                $table_page['edit_date'] = date('Y/m/d h:i:s');
                $table_page['edit_name'] = \Session::get('UserAdmin')->id;
            }
            
            //Test Code
            if(isset($v->code)){
                if(trim($v->code)!=''){
                    if($id==0){
                        if($this->getDB->table('product')->where('code',$v->code)->count()==1){
                            $count_error[] = array($count,'Code'); continue; // ERROR: Mã sản phẩm đã tồn tại
                        }
                    }else{
                        if($this->getDB->table('product')->where('code',$v->code)->where('id_page',$id)->count()==1){
                            $count_error[] = array($count,'Code'); continue; // ERROR: Mã sản phẩm đã tồn tại
                        }
                    }
                }
                $table_product['code'] = trim($v->code);
            }
            // Test location
            $location = array();
            if(isset($v->locations)){
                if(trim($v->locations)!=''){
                    $locations = explode(',', $v->locations); 
                    foreach ($locations as $v1) {
                        if(isset($this->location[trim($v1)])){
                            $id_location = $this->getDB->table('location')->insertGetId(array(lang.'name'=>trim($v1)));
                            $this->location[trim($v1)] = $id_location; $count_location++;
                            $location[] = $this->location[trim($v1)];
                        }
                    }
                    $table_product['ids_location'] = implode(',', $location);
                }
            }
            // Test Attribute
            $attribute = array();
            if(isset($v->attributes)){
                $attributes = explode(',', $v->attributes); 
                foreach ($attributes as $v1) {
                    if(isset($this->news[trim($v1)])){
                        $attribute[] = $this->news[trim($v1)];
                    }
                }
                $table_product['ids_attribute'] = implode(',', $attribute);
            }
            // Test Procedure
            if(isset($v->procedure)){
                if(isset($this->procedure[trim($v->procedure)])){
                    $table_product['id_procedure'] = trim($v->procedure);
                }
            }
            // Test time
            if(isset($v->begingold)){
                $BeginGold = explode(':', trim($v->begingold));
                if(count($BeginGold)==3){
                    $BeginGold[0] = (is_numeric($BeginGold[0])&&$BeginGold[0]>=0&&$BeginGold[0]<24)?(int)BeginGold[0]:0;
                    $BeginGold[1] = (is_numeric($BeginGold[1])&&$BeginGold[1]>=0&&$BeginGold[1]<60)?(int)BeginGold[1]:0;
                    $BeginGold[2] = (is_numeric($BeginGold[2])&&$BeginGold[2]>=0&&$BeginGold[2]<60)?(int)BeginGold[2]:0;
                    $table_product['goldtime_start'] = implode(':', $BeginGold);
                }
            }
            if(isset($v->endgold)){
                $EndGold = explode(':', trim($v->endgold));
                if(count($EndGold)==3){
                    $EndGold[0] = (is_numeric($EndGold[0])&&$EndGold[0]>=0&&$EndGold[0]<24)?(int)$EndGold[0]:0;
                    $EndGold[1] = (is_numeric($EndGold[1])&&$EndGold[1]>=0&&$EndGold[1]<60)?(int)$EndGold[1]:0;
                    $EndGold[2] = (is_numeric($EndGold[2])&&$EndGold[2]>=0&&$EndGold[2]<60)?(int)$EndGold[2]:0;
                    $table_product['goldtime_end'] = implode(':', $EndGold);
                }
            }
            // Test fields
            if(isset($v->cost)){$table_product['code'] = is_numeric($v->cost)?($v->cost>=0?(int) $v->cost:0):0;}
            if(isset($v->price)){$table_product['cost'] = is_numeric($v->price)?($v->price>0?(int) $v->price:0):0;}
            if(isset($v->promotionprice)){$table_product['promotion_price'] = is_numeric($v->promotionprice)?($v->promotionprice>0?(int) $v->promotionprice:0):0;}
            if(isset($v->goldprice)){$table_product['goldtime'] = is_numeric($v->goldprice)?($v->goldprice>0?(int) $v->goldprice:0):0;}
            if(isset($v->images)){ $table_product[lang.'images'] = ReturnImage::Image($v->images); }
            if(isset($v->videos)){ $table_product[lang.'videos'] = $v->videos; }
            if(isset($v->checkcount)){ $table_product['count_check'] = in_array($v->checkcount, array(0,1))?$v->checkcount:0; }
            if(isset($v->count)){$table_product['count'] = is_numeric($v->count)?(int) $v->count:0;}
            if(isset($v->beginpromotion)){ if(!$this->validateDate($v->beginpromotion)){ $table_product['promotion_start'] = $v->beginpromotion; } }
            if(isset($v->endpromotion)){ if(!$this->validateDate($v->endpromotion)){ $table_product['promotion_end'] = $v->endpromotion; } }
            if(isset($v->priceoptions)){ $table_product[lang.'options_price'] = $v->priceoptions; }
            if(isset($v->tabs)){ $table_product[lang.'tabs'] = $v->tabs; }
            if(isset($v->infos)){ $table_product[lang.'infos'] = $v->infos; }
            if(isset($v->unitcount)){ $table_product[lang.'count_unit'] = $v->unitcount; }
            if(isset($v->warranty)){ $table_product[lang.'warranty'] = $v->warranty; }
            
            // Update database
            if($id==0){
                if($id = $this->getDB->table('page')->insertGetId($table_page)>0){
                    $table_product['id_page'] = $id;
                    if($this->getDB->table('product')->insert($table_product)>0){  }
                    $count_success++;
                }else{
                    $count_error[] = array($count,'Error');
                }
            }else{
                if($this->getDB->table('page')->where('id',$id)->where('typepage',6)->update($table_page)>0){
                    $table_product['id_page']=$id;
                    if($this->getDB->table('product')->where('id_page',$id)->update($table_product)>0){ }
                    $count_success++; 
                }else{
                    $count_error[] = array($count,'Error');
                }
            }
            
            
        }
        $string = '<strong>'.$this->titleadmin['Số mục đã nhập Excel thành công'].$count_success.'</strong><br/><strong>'.$this->titleadmin['Số mục đã nhập Excel thất bại'].(count($count_error)-1).'</strong><br/>';
            foreach ($count_error as $v) {
                if($v[0]==''){continue;}
                $string .= 'Line: '.$v[0].': '.$v[1].'<br/>';
            }
            $string .= '<strong>'.$this->titleadmin['Số danh mục được tạo thêm'].$count_category.'</strong><br/>';
            $string .= '<strong>'.$this->titleadmin['Số địa chỉ được tạo thêm'].$count_location.'</strong><br/>';
            $string .= '<strong>'.$this->titleadmin['Số tags được tạo thêm'].$count_tags.'</strong><br/>';
            echo $string;
    }
    
    
    
    private $category; private $tags; private $news; private $product; private $vpage;
    private $procedure; private $attribute; private $location;
    private $vpage_category=0; private $vpage_procedure=0;
    private function GetDataImport(){
        $category = $this->getDB->table('page')->select('id',lang.'name AS name')->where('typepage',5)->get();
        foreach ($category as $v) { $this->category[$v->name] = $v->id; }
        $news = $this->getDB->table('page')->select('id',lang.'name AS name')->where('typepage',3)->get();
        foreach ($news as $v) { $this->news[$v->name] = $v->id; }
        $product = $this->getDB->table('page')->select('id',lang.'name AS name')->where('typepage',6)->get();
        foreach ($product as $v) { $this->product[$v->name] = $v->id; }
        $procedure = $this->getDB->table('page')->select('id',lang.'name AS name')->where('typepage',8)->get();
        foreach ($procedure as $v) { $this->procedure[$v->name] = $v->id; }
        $vpage = $this->getDB->table('v_page')->select('id','name')->get();
        foreach ($vpage as $v) { $this->vpage[$v->name] = $v->id; }
        $tags = $this->getDB->table('tags')->select('id',lang.'name AS name')->where('typepage0',1)->get();
        foreach ($tags as $v) { $this->tags[$v->name] = $v->id; }
        $attribute = $this->getDB->table('attribute')->select('id',lang.'value AS name')->get();
        foreach ($attribute as $v) { $this->attribute[$v->name] = $v->id; }
        $location = $this->getDB->table('location')->select('id',lang.'name AS name')->get();
        foreach ($location as $v) { $this->location[$v->name] = $v->id; }
        $vpage_category = $this->getDB->table('v_page')->select('id')->where('typepage',4)->orderBy('order','ASC')->orderBy('id','ASC')->first();
        $this->vpage_category = $vpage_category->id;
        $vpage_procedure = $this->getDB->table('v_page')->select('id')->where('typepage',7)->orderBy('order','ASC')->orderBy('id','ASC')->first();
        $this->vpage_procedure = $vpage_procedure->id;
    }
    private function validateDate($date, $format = 'Y-m-d H:i:s')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }
}
