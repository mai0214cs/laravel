<?php
namespace App\Http\Controllers;
use App\Http\Models;
use App\Common\InfoMessage;
use Illuminate\Http\Request;
class ProductListController extends BaseController {
    private $model; private $field; private $info;
    public function __construct() {
        $this->field = parent::__construct(6);
        $this->model = new Models\ProductListModel($this->field);
        $this->info = new InfoMessage();
    }
    
    public function index(){
        return view('product.IndexProduct')->with('data', $this->model->data());
    }
    public function add(){
        return view('product.AddProduct')->with($this->model->datainsert());
    }
    public function getCategoryNews(){
        $this->model->getCategoryNews();
    }
    public function getCategoryProduct(){
        $this->model->getCategoryProduct();
    }

    public function confirmadd(Request $request){
        $post = $request->all(); 
        $message = [
            'name.required'=>$this->field['Tiêu đề sản phẩm bắt buộc phải nhập'],
            'cost.required'=>$this->field['Giá gốc bắt buộc phải nhập số nguyên lớn hơn hoặc bằng 0'],
            'cost.integer'=>$this->field['Giá gốc bắt buộc phải nhập số nguyên lớn hơn hoặc bằng 0'],
            'cost.min'=>$this->field['Giá gốc bắt buộc phải nhập số nguyên lớn hơn hoặc bằng 0'],
            'price.required'=>$this->field['Giá bán bắt buộc phải nhập số nguyên lớn hơn hoặc bằng 0'],
            'price.integer'=>$this->field['Giá bán bắt buộc phải nhập số nguyên lớn hơn hoặc bằng 0'],
            'price.min'=>$this->field['Giá bán bắt buộc phải nhập số nguyên lớn hơn hoặc bằng 0'],
            'promotion_price.required'=>$this->field['Giá khuyến mại bắt buộc phải nhập số nguyên lớn hơn hoặc bằng 0'],
            'promotion_price.integer'=>$this->field['Giá khuyến mại bắt buộc phải nhập số nguyên lớn hơn hoặc bằng 0'],
            'promotion_price.min'=>$this->field['Giá khuyến mại bắt buộc phải nhập số nguyên lớn hơn hoặc bằng 0'],
            'goldtime_price.required'=>$this->field['Giá giờ vàng bắt buộc phải nhập số nguyên lớn hơn hoặc bằng 0'],
            'goldtime_price.integer'=>$this->field['Giá giờ vàng bắt buộc phải nhập số nguyên lớn hơn hoặc bằng 0'],
            'goldtime_price.min'=>$this->field['Giá giờ vàng bắt buộc phải nhập số nguyên lớn hơn hoặc bằng 0'],
            'sale_count.required'=>$this->field['Số lượng bán bắt buộc phải nhập số nguyên lớn hơn hoặc bằng 0'],
            'sale_count.integer'=>$this->field['Số lượng bán bắt buộc phải nhập số nguyên lớn hơn hoặc bằng 0'],
            'sale_count.min'=>$this->field['Số lượng bán bắt buộc phải nhập số nguyên lớn hơn hoặc bằng 0'],
            'check_count.required'=>$this->field['Bạn chưa chọn kiểm soát số lượng'],
            'check_count.integer'=>$this->field['Bạn chưa chọn kiểm soát số lượng'],
            'check_count.min'=>$this->field['Bạn chưa chọn kiểm soát số lượng'],
            'check_count.max'=>$this->field['Bạn chưa chọn kiểm soát số lượng'],
            'order.required'=>$this->field['Thứ tự bạn phải nhập vào một số nguyên'],
            'order.integer'=>$this->field['Thứ tự bạn phải nhập vào một số nguyên'],
        ];
        $rules = [
            'name'=>'required',
            'cost'=>'required|integer|min:0',
            'price'=>'required|integer|min:0',
            'promotion_price'=>'required|integer|min:0',
            'goldtime_price'=>'required|integer|min:0',
            'sale_count'=>'required|integer|min:0',
            'check_count'=>'required|integer|min:0|max:0',
            'order'=>'required|integer',
        ];
        $v = \Validator::make($post,$rules,$message);
        if($v->fails()){            
            return redirect()->back()->withErrors($v->errors());
        }else{
            if(!$this->model->insert($post)){
                return redirect()->back();
            }else{
                return redirect('/admin/product/list');
            }
        }
    }
    public function edit($id){
        //print_r($this->model->dataupdate($id);
        return view('product.EditProduct')->with($this->model->dataupdate($id));
    }
    public function confirmedit(Request $request){
        $post = $request->all(); 
        $message = [
            'name.required'=>$this->field['Tiêu đề sản phẩm bắt buộc phải nhập'],
            'cost.required'=>$this->field['Giá gốc bắt buộc phải nhập số nguyên lớn hơn hoặc bằng 0'],
            'cost.integer'=>$this->field['Giá gốc bắt buộc phải nhập số nguyên lớn hơn hoặc bằng 0'],
            'cost.min'=>$this->field['Giá gốc bắt buộc phải nhập số nguyên lớn hơn hoặc bằng 0'],
            'price.required'=>$this->field['Giá bán bắt buộc phải nhập số nguyên lớn hơn hoặc bằng 0'],
            'price.integer'=>$this->field['Giá bán bắt buộc phải nhập số nguyên lớn hơn hoặc bằng 0'],
            'price.min'=>$this->field['Giá bán bắt buộc phải nhập số nguyên lớn hơn hoặc bằng 0'],
            'promotion_price.required'=>$this->field['Giá khuyến mại bắt buộc phải nhập số nguyên lớn hơn hoặc bằng 0'],
            'promotion_price.integer'=>$this->field['Giá khuyến mại bắt buộc phải nhập số nguyên lớn hơn hoặc bằng 0'],
            'promotion_price.min'=>$this->field['Giá khuyến mại bắt buộc phải nhập số nguyên lớn hơn hoặc bằng 0'],
            'goldtime_price.required'=>$this->field['Giá giờ vàng bắt buộc phải nhập số nguyên lớn hơn hoặc bằng 0'],
            'goldtime_price.integer'=>$this->field['Giá giờ vàng bắt buộc phải nhập số nguyên lớn hơn hoặc bằng 0'],
            'goldtime_price.min'=>$this->field['Giá giờ vàng bắt buộc phải nhập số nguyên lớn hơn hoặc bằng 0'],
            'sale_count.required'=>$this->field['Số lượng bán bắt buộc phải nhập số nguyên lớn hơn hoặc bằng 0'],
            'sale_count.integer'=>$this->field['Số lượng bán bắt buộc phải nhập số nguyên lớn hơn hoặc bằng 0'],
            'sale_count.min'=>$this->field['Số lượng bán bắt buộc phải nhập số nguyên lớn hơn hoặc bằng 0'],
            'check_count.required'=>$this->field['Bạn chưa chọn kiểm soát số lượng'],
            'check_count.integer'=>$this->field['Bạn chưa chọn kiểm soát số lượng'],
            'check_count.min'=>$this->field['Bạn chưa chọn kiểm soát số lượng'],
            'check_count.max'=>$this->field['Bạn chưa chọn kiểm soát số lượng'],
            'order.required'=>$this->field['Thứ tự bạn phải nhập vào một số nguyên'],
            'order.integer'=>$this->field['Thứ tự bạn phải nhập vào một số nguyên'],
        ];
        $rules = [
            'name'=>'required',
            'cost'=>'required|integer|min:0',
            'price'=>'required|integer|min:0',
            'promotion_price'=>'required|integer|min:0',
            'goldtime_price'=>'required|integer|min:0',
            'sale_count'=>'required|integer|min:0',
            'check_count'=>'required|integer|min:0|max:0',
            'order'=>'required|integer',
        ];
        $v = \Validator::make($post,$rules,$message);
        if($v->fails()){            
            return redirect()->back()->withErrors($v->errors());
        }else{
            $this->model->update($post);
            return redirect()->back();
        }
    }
    public function deleteAll(Request $request){
        $get = $request->all(); 
        $count = $this->model->delete($get['ids']);
        \Session::flash('message_success',$this->field['Xác nhận xóa nhóm'].$count);
    }
    public function updatedataproduct(Request $request){
        $get = $request->all();
        $this->model->updatedataproduct($get);
    }
    function updatelist(Request $request){
        $get = $request->all();
        $this->model->updatelist($get);
    }
    function exportExcel(){
        $this->model->exportExcel();
    }
    function importExcel(Request $request){
        $get = $request->all();
        $this->model->importExcel($get);
    }
    
}
