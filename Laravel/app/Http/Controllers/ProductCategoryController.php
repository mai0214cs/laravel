<?php
namespace App\Http\Controllers;
use App\Http\Models;
use Illuminate\Http\Request;
use App\Common\InfoMessage;
class ProductCategoryController extends BaseController {
    private $model; private $field; private $info;
    public function __construct() {
        $this->field = parent::__construct(5);
        $this->model = new Models\ProductCategoryModel($this->field);
        $this->info = new InfoMessage();
    }
    public function index(){
        return view('product.IndexCategory')->with('data', $this->model->getData());
    }
    public function add(){
        return view('product.AddCategory')->with('data', $this->model->getDataAdd());
    }
    public function edit($id){
        return view('product.EditCategory')->with('data', $this->model->getDataEdit($id));
    }
    public function delete(Request $request){
        $get = $request->all();
        $this->model->Delete($get);
        //return redirect('/admin/product/category');
    }
    public function confirmadd(Request $request){
        $post = $request->all(); 
        $v = \Validator::make($post,
                [
                    'title'=>'required',
                ]);
        if($v->fails()){            
            return redirect()->back()->withErrors($v->errors());
        }else{
            if(!$this->model->Insert($post)){
                \Session::flash('message_error',$this->field['Thêm danh mục sản phẩm thất bại']);
                return redirect()->back();
            }else{
                \Session::flash('message_success',$this->field['Thêm danh mục sản phẩm thành công']);
                return redirect('/admin/product/category');
            }
        }
    }
    public function confirmedit(Request $request){
        $post = $request->all(); 
        $v = \Validator::make($post,
        [
            'title'=>'required',
        ]);
        if($v->fails()){            
            return redirect()->back()->withErrors($v->errors());
        }else{
            if(!$this->model->Edit($post)){
                \Session::flash('message_error',$this->field['Sửa danh mục sản phẩm thất bại']);
                return redirect()->back();
            }else{
                \Session::flash('message_success',$this->field['Sửa danh mục sản phẩm thành công']);
                return redirect('/admin/product/category');
            } 
        }
    }
    public function checkstatus($val, $id){
        if(!in_array($val, array(1,0))){echo $this->info->Error($this->field['Thông báo Trạng thái sai']); return;}
        if($this->model->Check($id, $val)){echo $this->info->Success($this->field['Thông báo Trạng thái thành công']); return;}
        echo $this->info->Error($this->field['Thông báo Trạng thái thất bại']); return;
    }
    public function changeorder($val, $id){
        if(!is_numeric($val)){echo $this->info->Error($this->field['Thông báo Thứ tự sai']); return;}
        if($this->model->Order($id, $val)){echo $this->info->Success($this->field['Thông báo Thứ tự thành công']); return;}
        echo $this->info->Error($this->field['Thông báo Thứ tự thất bại']); return;
    }
}
