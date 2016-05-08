<?php
namespace App\Http\Controllers;
use App\Http\Models\ProductTagsModel;
use App\Common\InfoMessage;
use Illuminate\Http\Request;
class ProductTagsController extends BaseController{
    private $model; private $field; private $info;
    public function __construct() {
        $this->field = parent::__construct(7);
        $this->model = new ProductTagsModel($this->field);
        $this->info = new InfoMessage();
    }
    public function index(){
        //print_r($this->model->data()); exit();
        return view('product.Tags')->with('data', $this->model->data());
    }
    public function add(Request $request){
        $get = $request->all();
        $v = \Validator::make($get,
        [
            'val'=>'required',
        ]);
        if($v->fails()){            
            \Session::flash('message_error',$this->field['Tiêu đề tag sản phẩm bắt buộc phải nhập']);
        }else{
            if(!$this->model->insert($get['val'])){
                \Session::flash('message_error',$this->field['Thêm tags sản phẩm thất bại']);
            }else{
                \Session::flash('message_success',$this->field['Thêm tags sản phẩm thành công']);
            }
        }
    }
    public function edit(Request $request){
        $get = $request->all();
        $v = \Validator::make($get,
        [
            'val'=>'required',
        ]);
        if($v->fails()){            
            \Session::flash('message_error',$this->field['Tiêu đề tag sản phẩm bắt buộc phải nhập']);
        }else{
            if(!$this->model->edit($get['id'],$get['val'])){
                \Session::flash('message_error',$this->field['Sửa tags sản phẩm thất bại']);
            }else{
                \Session::flash('message_success',$this->field['Sửa tags sản phẩm thành công']);
            }
        }
    }
    public function delete(Request $request){
        $get = $request->all();
        if(!isset($get['ids'])){return;}
        if(!is_array($get['ids'])){return;}
        $count = $this->model->delete($get['ids']);
        \Session::flash('message_success',$this->field['Xác nhận xóa nhóm'].$count);
    }
}
