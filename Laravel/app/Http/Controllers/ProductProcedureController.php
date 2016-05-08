<?php
namespace App\Http\Controllers;
use App\Http\Models;
use Illuminate\Http\Request;
use App\Common\InfoMessage;
class ProductProcedureController extends BaseController {
    private $model; private $field; private $info;
    public function __construct() {
        $this->field = parent::__construct(8);
        $this->model = new Models\ProductProcedureModel($this->field);
        $this->info = new InfoMessage();
    }
    public function index(){
        return view('product.IndexProcedure')->with('data', $this->model->getData());
    }
    public function add(){
        return view('product.AddProcedure')->with('data', $this->model->getDataAdd());
    }
    public function edit($id){
        return view('product.EditProcedure')->with('data', $this->model->getDataEdit($id));
    }
    public function delete($id){
        $this->model->Delete($id);
        return redirect('/admin/product/procedure');
    }
    public function confirmadd(Request $request){
        $post = $request->all(); 
        $v = \Validator::make($post,
                [
                    'title'=>'required',
                    'email'=>'email'
                ]);
        if($v->fails()){            
            return redirect()->back()->withErrors($v->errors());
        }else{
            if(!$this->model->Insert($post)){
                \Session::flash('message_error','Thêm Nhà sản xuất thất bại');
                return redirect()->back();
            }else{
                \Session::flash('message_success','Thêm Nhà sản xuất thành công');
                return redirect('/admin/product/procedure');
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
                \Session::flash('message_error','Sửa Nhà sản xuất thất bại');
                return redirect()->back();
            }else{
                \Session::flash('message_success','Sửa Nhà sản xuất thành công');
                return redirect('/admin/product/procedure');
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
