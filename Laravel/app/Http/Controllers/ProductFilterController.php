<?php
namespace App\Http\Controllers;
use App\Http\Models;
use App\Common\InfoMessage;
use Illuminate\Http\Request;
class ProductFilterController extends BaseController {
    private $model; private $field; private $info;
    public function __construct() {
        $this->field = parent::__construct(50);
        $this->model = new Models\ProductFilterModul($this->field);
        $this->info = new InfoMessage();
    }
    public function index(){
        return view('product.FilterProduct')->with('data', $this->model->getData());
    }
    public function addgroup(Request $request){
        if($this->model->addgroup($request->all())){
            \Session::flash('message_success',$this->field['Thêm nhóm thuộc tính thành công']);
        }else{
            \Session::flash('message_error',$this->field['Thêm nhóm thuộc tính thất bại']);
        }
    }
    public function editgroup(Request $request){
        if($this->model->editgroup($request->all())){
            \Session::flash('message_success',$this->field['Sửa nhóm thuộc tính thành công']);
        }else{
            \Session::flash('message_error',$this->field['Sửa nhóm thuộc tính thất bại']);
        }
    }
    public function deletegroup(Request $request){
        $get = $request->all();
        if($this->model->deletegroup($get['g_id'])){
            \Session::flash('message_success',$this->field['Xóa nhóm thuộc tính thành công']);
        }else{
            \Session::flash('message_error',$this->field['Xóa nhóm thuộc tính thất bại']);
        }
    }
    public function additem(Request $request){
        if($this->model->additem($request->all())){
            \Session::flash('message_success',$this->field['Thêm thuộc tính thành công']);
        }else{
            \Session::flash('message_error',$this->field['Thêm thuộc tính thất bại']);
        }
    }
    public function edititem(Request $request){
        if($this->model->edititem($request->all())){
            \Session::flash('message_success',$this->field['Sửa thuộc tính thành công']);
        }else{
            \Session::flash('message_error',$this->field['Sửa thuộc tính thất bại']);
        }
    }
    public function deleteitem(Request $request){
        $get = $request->all();
        if($this->model->deleteitem($get['i_id'])){
            \Session::flash('message_success',$this->field['Xóa thuộc tính thành công']);
        }else{
            \Session::flash('message_error',$this->field['Xóa thuộc tính thất bại']);
        }
    }
    
    
}
