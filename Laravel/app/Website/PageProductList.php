<?php
namespace App\Website;
class PageProductList extends Model{
    private $data; private $type; private $product; private $price; private $tabs;

    private $fields = array(
        0=>'{Tiêu đề}', 1=>'{Mô tả}', 2=>'{Chi tiết}', 3=>'{URL Hình ảnh}', 4=>'{URL Sản phẩm}', 5=>'{Danh mục Sản phẩm}',
        6=>'{Sản phẩm liên quan}', 7=>'{Tin tức liên quan}', 8=>'{Sản phẩm cùng danh mục}', 9=>'{Tags Sản phẩm}',
        10=>'{Lượt xem}', 11=>'{Ngày đăng}', 12=>'{Người đăng}', 13=>'{Ngày sửa}', 14=>'{Người sửa}',
        15=>'{Mã sản phẩm}', 16=>'{Giá gốc}', 17=>'{Giá bán}', 18=>'{Ngày khuyến mại}', 19=>'{Thời điểm giờ vàng}', 20=>'{Giá tùy chọn}', 21=>'{Hình ảnh}', 22=>'{Video}', 
        23=>'{Tiêu đề tabs 1}', 24=>'{Tiêu đề tabs 2}', 25=>'{Tiêu đề tabs 3}', 26=>'{Tiêu đề tabs 4}', 27=>'{Tiêu đề tabs 5}',    
        28=>'{Nội dung tabs 1}', 29=>'{Nội dung tabs 2}', 30=>'{Nội dung tabs 3}', 31=>'{Nội dung tabs 4}', 32=>'{Nội dung tabs 5}', 
        33=>'{Thông số sản phẩm}', 34=>'{Nhà sản xuất}', 35=>'{Thuộc tính}', 36=>'{Địa điểm mua}', 37=>'{Số lượng bán}',   
        38=>'{Thông tin bảo hành}', 39=>'{Số lượng đã bán}', 40=>'{Giá cũ}', 41=>'{Độ giảm giá}'
    );
    public function index($content, $item, $item_productnews){
        $this->data = \Session::get('PAGE'); $this->type = $item_productnews;
        $this->product = $this->getDB->table('product')
            ->select('code','cost','price','promotion_price','promotion_start','promotion_end',
'goldtime','goldtime_start','goldtime_end',lang.'options_price AS options_price',lang.'images AS images',lang.'videos AS videos',lang.'tabs AS tabs',lang.'infos AS infos',
'id_procedure','ids_attribute','ids_location','count_check','count',lang.'count_unit AS count_unit',lang.'warranty AS warranty','count_sale')->first();
        if(!isset($this->product->code)){return;}
        $this->price = $this->getPrice(
            $this->product->price, 
            array($this->product->promotion_price, $this->product->promotion_start, $this->product->promotion_end),
            array($this->product->goldtime, $this->product->goldtime_start, $this->product->goldtime_end)
        ); // Lấy thông tin giá
        $this->getTabs(); // Lấy thông tin tabs
        // Lọc qua các fields dữ liệu
        $fields = array(); $datas = array(); 
        foreach ($item as $v) {
            if(!isset($this->fields[$v])){continue;}
            $fields[] = $this->fields[$v];
            $datas[] = $this->{'Info'.$v}();
        } 
        return str_replace($fields, $datas, $content);
    }
    private function getTabs(){
        $xml = simplexml_load_string('<ArrayOfConsignmentTrack xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns="http://tempuri.org/">'.$this->product->tabs.'</ArrayOfConsignmentTrack>');        
        for ($i = 0; $i < 5; $i++) {
            $this->tabs['title'][$i] = isset($xml->item[$i])?$xml->item[$i]->title:'';
            $this->tabs['content'][$i] = isset($xml->item[$i])?$xml->item[$i]->content:'';
        }
    }
    private function Info15(){ 
        return '<div class="code"><span class="title">'.Model::Language('Mã sản phẩm').'</span><span class="content">'.$this->product->code.'</span></div>';
    }// Mã sản phẩm
    private function Info16(){
        return Model::ViewPrice($this->product->code, 'Giá gốc', 'cost');
    }// Giá gốc
    private function Info17(){
        return Model::ViewPrice($this->price['PriceNew'], 'Giá bán', 'pricenew');
    }// Giá bán
    private function Info18(){
        if($this->price['PriceNew']!=$this->product->promotion_price){return;}
        $datebegin = date_format(date_create_from_format("Y-m-d", $this->product->promotion_start), Model::Language('Định dạng ngày'));
        $dateend = date_format(date_create_from_format("Y-m-d", $this->product->promotion_end), Model::Language('Định dạng ngày'));
        return '<div class="datepromotion"><span class="begin">'.$datebegin.'</span><span class="end">'.$dateend.'</span><span class="clock"></span></div>';
    }// Ngày khuyến mại
    private function Info19(){
        if($this->price['PriceNew']!=$this->product->goldtime){return;}
        $timebegin = date_format(date_create_from_format("H:i:s", $this->product->goldtime_start), 'H:i:s');
        $timeend = date_format(date_create_from_format("H:i:s", $this->product->goldtime_end), 'H:i:s');
        return '<div class="timegold"><span class="begin">'.$timebegin.'</span><span class="end">'.$timeend.'</span><span class="clock"></span></div>';
    }// Thời điểm giờ vàng
    private function Info20(){
        if($this->product->options_price != ''){
            $xml = simplexml_load_string('<ArrayOfConsignmentTrack xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns="http://tempuri.org/">'.$this->product->options_price.'</ArrayOfConsignmentTrack>');        
            if(!isset($xml->item[0])){return;}
            $content = '<table class="table table-hover tablepriceoptions"><thead><tr>
                    <th>'.Model::Language('Mã tùy chọn').'</th>
                    <th>'.Model::Language('Tên tùy chọn').'</th>
                    <th>'.Model::Language('Hình ảnh tùy chọn').'</th>
                    <th>'.Model::Language('Giá tùy chọn').'</th>
                <th></th></tr></thead><tbody>';
            for ($i = 0; ; $i++) {
                $content .= '<tr>
                    <td>'.(isset($xml->item[$i])?$xml->item[$i]->code:'').'</td>
                    <td>'.(isset($xml->item[$i])?$xml->item[$i]->name:'').'</td>
                    <td><img src="'.(Model::Image(isset($xml->item[$i])?$xml->item[$i]->avatar:'')).'" alt="'.(isset($xml->item[$i])?$xml->item[$i]->name:'').'" /></td>
                    <td>'.(isset($xml->item[$i])?$xml->item[$i]->price:'').'</td>
                    <td><a href="javascript:;" onclick="CartPriceOptions('.$i.','.$this->data->id.')">Đặt hàng</a></td>
                </tr>';
            }
            $content .= '</tbody></table>';
            return $content;
        }
    }// Giá tùy chọn
    private function Info21(){
        $list = explode(',', $this->product->images); $count = count($list);
        if($count==0){return;} $content = '';
        foreach ($list as $v) {
            $content .= '<li><a href="javascript:;" onclick="SelectImageProduct($(this),\''.$v.'\')"><img src="'.Model::Image($v).'" /></a></li>';
        } 
        return '<div class="videos_product">
            <div class="primaryvideo">
                <img src="'.Model::Image($list[0]).'" />
            </div><ul class="listvideo">'.$content.'</ul></div>';
    }// Hình ảnh
    private function Info22(){
        $list = explode(',', $this->product->videos); $count = count($list);
        if($count==0){return;} $content = '';
        foreach ($list as $v) {
            $content .= '<li><a href="javascript:;" onclick="SelectVideoProduct($(this),\''.$v.'\')"><img src="http://img.youtube.com/vi/'.$v.'/0.jpg" /></a></li>';
        } 
        return '<div class="videos_product">
            <div class="primaryvideo">
                <iframe src="https://www.youtube.com/embed/'.$list[0].'" frameborder="0" allowfullscreen></iframe>
            </div><ul class="listvideo">'.$content.'</ul></div>';
    }// Video
    private function Info23(){return $this->tabs['title'][0];}// Tiêu đề tabs 1
    private function Info24(){return $this->tabs['title'][1];}// Tiêu đề tabs 2
    private function Info25(){return $this->tabs['title'][2];}// Tiêu đề tabs 3
    private function Info26(){return $this->tabs['title'][3];}// Tiêu đề tabs 4
    private function Info27(){return $this->tabs['title'][4];}// Tiêu đề tabs 5
    private function Info28(){return $this->tabs['content'][0];}// Nội dung tabs 1
    private function Info29(){return $this->tabs['content'][1];}// Nội dung tabs 2
    private function Info30(){return $this->tabs['content'][2];}// Nội dung tabs 3
    private function Info31(){return $this->tabs['content'][3];}// Nội dung tabs 4
    private function Info32(){return $this->tabs['content'][4];}// Nội dung tabs 5
    private function Info33(){
        if($this->product->infos == ''){return '';} $content = '';
        $xml = simplexml_load_string('<ArrayOfConsignmentTrack xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns="http://tempuri.org/">'.$this->product->infos.'</ArrayOfConsignmentTrack>'); 
        for ($i = 0; ; $i++) {
            if(!isset($xml->item[$i])){break;}
            $titlei = isset($xml->item[$i])?$xml->item[$i]->title:'';
            $contenti = isset($xml->item[$i])?$xml->item[$i]->content:'';
            $content .= '<li><span class="title">'.$titlei.'</span><span class="content">'.$contenti.'</span></li>';
        }
        return '<ul class="infomation">'.$content.'</ul>';
    }// Thông số sản phẩm
    private function Info34(){
        $procedure = $this->getDB->table('page')->select('url', lang.'name AS name')->where('id', $this->product->id_procedure)->where(lang.'name','')->where(lang.'status',1)->where('typepage',8)->first();
        if(!isset($procedure->url)){return;}
        return '<div class="procedure"><span class="title">'.Model::Language('Nhà sản xuất').'</span><span class="content"><a href="/'.(lang==''?'':lang.'/').$procedure->url.'">'.$procedure->name.'</a></span></div>';
    }// Nhà sản xuất
    private function Info35(){
        /* THÔNG TIN THUỘC TÍNH SẢN PHẨM */
    }// Thuộc tính
    private function Info36(){
        $location = explode(',', $this->product->ids_location);
        $locations = $this->getDB->table('location')->select('id',lang.'name AS name')->whereIn('id', $location)->get();
        $content = '';
        foreach ($locations as $v) {
            $content .= '<li><a href="javascript" onclick="SelectLocationProduct('.$v->id.')">'.$v->name.'</a></li>';
        }
        return '<ul id="LocationProduct">'.$content.'</ul>';
    }// Địa điểm mua
    private function Info37(){
        if($this->product->count_check==1){
            return '<div class="quantitysold"><span class="title">'.Model::Language('Số lượng bán').'</span><span class="content">'.$this->product->count.' '.$this->product->count_unit.'</span></div>';
        }
    }// Số lượng bán
    private function Info38(){
        if($this->product->warranty!=''){
            return '<div class="infowarranty"><span class="title">'.Model::Language('Thông tin bảo hành').'</span><span class="content">'.$this->product->warranty.'</span></div>';
        }
    }// Thông tin bảo hành
    private function Info39(){
        if($this->product->count_sale>0){
            return '<div class="quantitybuy"><span class="title">'.Model::Language('Số lượng mua').'</span><span class="content">'.$this->product->count_sale.'</span></div>';
        }
    }// Số lượng đã bán
    private function Info40(){
        return Model::ViewPrice($this->price['PriceOld'], 'Giá cũ', 'priceold');
    }// Giá cũ
    private function Info41(){
        if($this->product->options_price==''){return;}
        if(Model::SysPage('Giảm giá % - 000')==1){
            return '<div class="sale"><span class="title">'.Model::Language('Giảm giá').'</span><span class="content">'.(ceil(100*($this->price['PriceNew']-$this->price['PriceOld'])/$this->price['PriceOld'])).'%</span></div>';
        }
        return Model::ViewPrice($this->price['PriceNew']-$this->price['PriceOld'], 'Giảm giá', 'sale');
    }// Độ giảm giá
    
    private function Info0(){ return $this->data->name; } // Tiêu đề 
    private function Info1(){ return $this->data->description; } // Mô tả
    private function Info2(){ return $this->data->detail; } // Chi tiết
    private function Info3(){ return Model::Image($this->data->avatar); } // URL Hình ảnh
    private function Info4(){ return '/'.(lang==''?'':lang.'/').$this->data->url; } // URL Sản phẩm
    private function Info5(){
        $category = $this->getDB->table('page')->select('url',lang.'name AS name')->where('id_category',  $this->data->id_category)->where('typepage',5)->where(lang.'name','<>','')->where(lang.'status',1)->first();
        if(!isset($category->url)){return '';}
        return '<a href="'.$category->url.'">'.$category->name.'</a>';
    } // Danh mục sản phẩm
    private function Info6(){
        $lists = new ItemProduct();$listid = explode(',', $this->data->ids_product_related); $where = array();
        foreach ($listid as $v) {$where[] = array('field'=>'a.id','compare'=>'=','value'=>$v);}
        return $lists->index($this->type[2], array(), $where, array(),array());
    } // Sản phẩm liên quan
    private function Info7(){
        $lists = new ItemNews(); $listid = explode(',', $this->data->ids_news_related); $where = array();
        foreach ($listid as $v) {$where[] = array('id','=',$v);}
        return $lists->index($this->type[5],$where, array(), array());
    } // Tin tức liên quan
    private function Info8(){
        $lists = new ItemProduct();
        $lists->index($this->type[0], array($this->data->id_category), array(array('field'=>'a.id','compare'=>'<>','value'=>$this->data->id)), array(), array('count'=>  $this->SysPage('Số lượng Sản phẩm Cùng danh mục'),'page'=>1));
    } // Sản phẩm cùng danh mục 
    private function Info9(){
        $tags = $this->getDB->table('tags')->select('id',lang.'name AS name')->whereIn('id',  explode(',', $this->data->ids_tags))->where('typepage0',1)->get();
        if(!isset($tags[0])){return;} $content = '';
        foreach ($tags as $tag){ $content .= '<li><a href="/tags-san-pham.html?tags='.$tag->id.'">'.$tag->name.'</a></li>'; }
        return '<ul class="tag">'.$content.'</ul>';
    } // Tags Sản phẩm
    private function Info10(){
        return '<div class="view"><span class="title">'.Model::Language('Tiêu đề Lượt xem').'</span><span class="content">'.$this->data->views.'</span></div>';
    } // Số lượt xem
    private function Info11(){
        $date = date_format(date_create_from_format("Y-m-d H:i:s", $this->data->add_date), Model::Language('Định dạng ngày tháng'));
        return '<span class="dateadd"><span class="title">'.Model::Language('Tiêu đề ngày đăng').'</span><span class="content">'.$date.'</span></span>'; 
    } // Ngày đăng
    private function Info12(){
        $people = $this->getDB->table('useradmin')->select('fullname')->where('id', $this->data->add_name)->first();
        if(!isset($people->fullname)){return;}
        return '<span class="nameadd"><span class="title">'.Model::Language('Tiêu đề người đăng').'</span><span class="content">'.$people->fullname.'</span></span>'; 
    } // Người đăng
    private function Info13(){
        if($this->data->edit_date == '0000-00-00 00:00:00'){$this->data->edit_date = $this->data->add_date;}
        $date = date_format(date_create_from_format("Y-m-d H:i:s", $this->data->edit_date), Model::Language('Định dạng ngày tháng'));
        return '<span class="dateedit"><span class="title">'.Model::Language('Tiêu đề ngày đăng').'</span><span class="content">'.$date.'</span></span>'; 
    } // Ngày sửa
    private function Info14(){
        if($this->data->edit_name==0){$this->data->edit_name = $this->data->add_name; }
        $people = $this->getDB->table('useradmin')->select('fullname')->where('id', $this->data->edit_name)->first();
        if(!isset($people->fullname)){return;}
        return '<span class="nameedit"><span class="title">'.Model::Language('Tiêu đề người sửa').'</span><span class="content">'.$people->fullname.'</span></span>'; 
    } // Người sửa
    
}