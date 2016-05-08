<?php
namespace App\Http\TestModul;
use DB;
class ModulHTML {
    public function index($type,$id){
        $value_old = explode(',', '');
        $type_old = 0;
        if(method_exists($this, 'Modul'.$type)){
            return $this->{'Modul'.$type}($type_old, $value_old);
        }
    } 
    private function Modul1($type_old, $value_old){
        
    }
    private function Modul2($type_old, $value_old){ // Menu Danh mục tin tức
        $value = ($type_old==5)?(count($value_old)==1?$value_old[0]:0):0;
        return $this->HTMLSelect('Danh mục sản phẩm gốc', $value, DB::table('page')->select('id',lang.'name AS name')->where('typepage',2)->get());
    }
    private function Modul3($type_old, $value_old){ // Danh sách tin tức thuộc danh mục
        $value = ($type_old==5)?(count($value_old)==4?$value_old:array(0,4,0,0)):array(0,4,0,0); $html = '';
        $classic = array(
            array(0,'Tất cả tin tức'),
            array(1,'Tin tức mới'),
            array(2,'Tin tức nổi bật')
        );
        $html .= $this->HTMLSelect('Danh mục tin tức', $value[0], DB::table('page')->select('id',lang.'name AS name')->where('typepage',2)->get(), TRUE);
        $html .= $this->HTMLSelectArray('Phân loại tin tức', $value[1], $classic);
        $html .= $this->HTMLSelect('Item Hiển thị', $value[2], DB::table('v_item')->select('id','name')->where('typepage0',0)->get());
        $html .= $this->HTMLInput('Số lượng hiển thị', $value[3], 'number');
        return $html;
    }
    private function Modul4($type_old, $value_old){ // Danh sách tag tin tức
        $value = ($type_old==5)?(count($value_old)==4?$value_old:array(0,4,0,0)):array(0,4,0,0); $html = '';
        $classic = array(
            array(0,'Tất cả tin tức'),
            array(1,'Tin tức mới'),
            array(2,'Tin tức nổi bật')
        );
        $html .= $this->HTMLSelect('Tags tin tức', $value[0], DB::table('tags')->select('id',lang.'name AS name')->where('typepage0',0)->get());
        $html .= $this->HTMLSelectArray('Phân loại tin tức', $value[1], $classic);
        $html .= $this->HTMLSelect('Item Hiển thị', $value[2], DB::table('v_item')->select('id','name')->where('typepage0',0)->get());
        $html .= $this->HTMLInput('Số lượng hiển thị', $value[3], 'number');
        return $html;
    }
    private function Modul5($type_old, $value_old){ // Menu Danh mục sản phẩm
        $value = ($type_old==5)?(count($value_old)==1?$value_old[0]:0):0;
        return $this->HTMLSelect('Danh mục sản phẩm gốc', $value, DB::table('page')->select('id',lang.'name AS name')->where('typepage',5)->get(), TRUE);
    }
    private function Modul6($type_old, $value_old){ // Danh sách sản phẩm thuộc danh mục
        $value = ($type_old==5)?(count($value_old)==4?$value_old:array(0,4,0,0)):array(0,4,0,0); $html = '';
        $classic = array(
            array(0, 'Tất cả sản phẩm'),
            array(1,'Sản phẩm mới'),
            array(2,'Sản phẩm nổi bật'),
            array(3,'Sản phẩm bán chạy'),
            array(4,'Sản phẩm khuyến mại')
        );
        $html .= $this->HTMLSelect('Danh mục sản phẩm', $value[0], DB::table('page')->select('id',lang.'name AS name')->where('typepage',5)->get(), TRUE);
        $html .= $this->HTMLSelectArray('Phân loại sản phẩm', $value[1], $classic);
        $html .= $this->HTMLSelect('Item Hiển thị', $value[2], DB::table('v_item')->select('id','name')->where('typepage0',1)->get());
        $html .= $this->HTMLInput('Số lượng hiển thị', $value[3], 'number');
        return $html;
    }
    private function Modul7($type_old, $value_old){ // Danh sách sản phẩm theo tags
        $value = ($type_old==5)?(count($value_old)==4?$value_old:array(0,4,0,0)):array(0,4,0,0); $html = '';
        $classic = array(
            array(0, 'Tất cả sản phẩm'),
            array(1,'Sản phẩm mới'),
            array(2,'Sản phẩm nổi bật'),
            array(3,'Sản phẩm bán chạy'),
            array(4,'Sản phẩm khuyến mại')
        );
        $html .= $this->HTMLSelect('Tags sản phẩm', $value[0], DB::table('tags')->select('id',lang.'name AS name')->where('typepage0',1)->get());
        $html .= $this->HTMLSelectArray('Phân loại sản phẩm', $value[1], $classic);
        $html .= $this->HTMLSelect('Item Hiển thị', $value[2], DB::table('v_item')->select('id','name')->where('typepage0',1)->get());
        $html .= $this->HTMLInput('Số lượng hiển thị', $value[3], 'number');
        return $html;
    }
    
    private function HTMLInput($name, $value, $type='text'){
        return '<div class="form-group">
            <label>'.$name.'</label>
            <input type="'.$type.'" value="'.$value.'" class="form-control" name="setupmodul[]" />
        </div>';
    }
    private function HTMLSelect($name, $value, $options, $all = FALSE){
        $html = $all?'<option '.($value==0?'selected="selected"':'').' value="0">-----</option>':''; foreach ($options as $v) { $html .= '<option '.($value==$v->id?'selected="selected"':'').' value="'.$v->id.'">'.$v->name.'</option>'; }
        return '<div class="form-group">
            <label>'.$name.'</label>
            <select class="form-control" name="setupmodul[]">'.$html.'</select>
        </div>';
    }
    private function HTMLSelectArray($name, $value, $options, $all = FALSE){
        $html = $all?'<option '.($value==0?'selected="selected"':'').' value="0">-----</option>':''; foreach ($options as $v) { $html .= '<option '.($value==$v[0]?'selected="selected"':'').' value="'.$v[0].'">'.$v[1].'</option>'; }
        return '<div class="form-group">
            <label>'.$name.'</label>
            <select class="form-control" name="setupmodul[]">'.$html.'</select>
        </div>';
    }
}
