<?php
namespace App\Website;
class PageNewsList extends Model{
    private $data;    private $related;
    private $fields = array(
        0=>'{Tiêu đề}',     1=>'{Mô tả}',       2=>'{Chi tiết}',    3=>'{URL Hình ảnh}',
        4=>'{Ngày đăng}',   5=>'{Người đăng}',  6=>'{Ngày sửa}',    7=>'{Người sửa}',
        8=>'{Bình luận}',   9=>'{Tags Tin tức}',10=>'{Tin tức liên quan}'
    );
    public function index($content, $item, $item_productnews){
        $this->data = \Session::get('PAGE'); $data = array(); $fields = array(); $this->related = $item_productnews;
        foreach ($item as $v) {
            if(!isset($this->fields[$v])){continue;}
            $datas[] = $this->{'Info'.$v}();
            $fields[] = $this->fields[$v];   
        }
        return str_replace($fields, $datas, $content);
    }
    private function Info0(){ return $this->data->name; }           // Tiêu đề
    private function Info1(){ return $this->data->description; }    // Mô tả
    private function Info2(){ return $this->data->detail; }         // Chi tiết
    private function Info3(){ return \App\Common\ReturnImage::Image($this->data->avatar); }    // Hình ảnh
    private function Info4(){ 
        return date_format(date_create_from_format("Y-m-d H:i:s", $this->data->add_date), Model::Language('Định dạng ngày tháng'));
    } // Ngày đăng
    private function Info5(){
        $name = $this->getDB->table('useradmin')->select('fullname')->where('id', $this->data->add_name)->first();
        return isset($name->fullname);
    } // Người đăng
    private function Info6(){
        return date_format(date_create_from_format("Y-m-d H:i:s", $this->data->edit_date), Model::Language('Định dạng ngày tháng'));
    } // Ngày sửa
    private function Info7(){
        $name = $this->getDB->table('useradmin')->select('fullname')->where('id', $this->data->edit_name)->first();
        return isset($name->fullname);
    } // Người sửa
    private function Info8(){
        return '<div class="row">
            <div class="container">
                <div class="row">
                    <div class="form-group">
                        <label>Tiêu đề</label>
                        <input type="text" class="form-control" name="comment_name" />
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" name="comment_email" />
                    </div>
                    <div class="form-group">
                        <label>Điểm</label>
                        <select name="comment_mark" class="form-control" placeholder="Điểm đánh giá">
                            <option value="5">Tốt nhất</option>
                            <option value="4">Rất hay</option>
                            <option value="3">Hay</option>
                            <option value="2">Trung bình</option>
                            <option value="1">Kém</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tiêu đề</label>
                        <input type="text" class="form-control" name="comment_title" />
                    </div>
                    <div class="form-group">
                        <label>Nội dung</label>
                        <textarea class="form-control" name="comment_content"></textarea>
                    </div>
                    <div class="box-footer">
                        <button type="button" class="btn btn-info pull-right" onclick="SendComment('.$this->data->id.',0,0)">Gửi bình luận</button>
                    </div>
                </div>
            </div>
        </div>';
        \Session::put('Comment',TRUE);
    } // Bình luận
    private function Info9(){
        $tags = $this->getDB->table('tags')->select('id',lang.'name AS name')->whereIn('id',  explode(',', \Session::get('PAGE')->ids_tags))->where('typepage0',0)->get();
        if(!isset($tags[0])){return;} $content = '';
        foreach ($tags as $tag){ $content .= '<li><a href="/tags-tin-tuc.html?tags='.$tag->id.'">'.$tag->name.'</a></li>'; }
        return '<ul class="tag">'.$content.'</ul>';
    }
    private function Info10(){
        $menunews = new ItemNews();
        $news = $menunews->index($this->related[5], 
                array(
                    array(
                        'field'=>'id_category',
                        'compare'=>'=',
                        'value'=>$this->data->id_category),
                    array(
                        'field'=>'id',
                        'compare'=>'<>',
                        'value'=>$this->data->id)), 
                array());
        return '<ul id="NewsRelated">'.$news.'</ul>';
    } // Tin tức cùng danh mục
} 
