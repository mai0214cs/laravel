<?php
namespace App\Http\Controllers;
use App\Http\Models;
use Illuminate\Http\Request;
use App\Common\InfoMessage;
class NewsListController extends BaseController {
    private $model; private $field; private $info;
    public function __construct() {
        $this->field = parent::__construct(3);
        $this->model = new Models\NewsListModel($this->field);
        $this->info = new InfoMessage();
    }
    public function index(){
        return view('news.IndexList')->with('data', $this->model->getData());
    }
    public function add(){
        return view('news.AddList')->with('data', $this->model->getDataAdd());
    }
    public function edit($id){
        return view('news.EditList')->with('data', $this->model->getDataEdit($id));
    }
    public function updatelist(Request $request){
        $get = $request->all();
        $this->model->updatelist($get);
    }

    public function delete($id){
        $this->model->Delete($id);
        return redirect('/admin/news/list');
    }
    public function deleteAll(Request $request){
        $get = $request->all(); 
        $count = $this->model->deleteAll($get['ids']);
        \Session::flash('message_success',$this->field['Xác nhận xóa nhóm'].$count);
    }
    public function ExportExcel(){
        $this->model->ExportExcel();
    }
    public function ImportExcel(Request $request){
        $get = $request->all();
        $this->model->ImportExcel($get['url']);
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
                \Session::flash('message_error',$this->field['Thêm danh sách tin tức thất bại']);
                return redirect()->back();
            }else{
                \Session::flash('message_success',$this->field['Thêm danh sách tin tức thành công']);
                return redirect('/admin/news/list');
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
                \Session::flash('message_error',$this->field['Sửa danh sách tin tức thất bại']);
                return redirect()->back();
            }else{
                \Session::flash('message_success',$this->field['Sửa danh sách tin tức thành công']);
                return redirect('/admin/news/list');
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
