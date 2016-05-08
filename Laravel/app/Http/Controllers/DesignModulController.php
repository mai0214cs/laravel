<?php
namespace App\Http\Controllers;
use App\Http\Models;
use Illuminate\Http\Request;
use App\Common\InfoMessage;
class DesignModulController extends BaseController {
    private $model; private $field; private $info;
    public function __construct() {
        $this->field = parent::__construct(102);
        $this->model = new Models\DesignModulModel($this->field);
        $this->info = new InfoMessage();
    }
    public function index($id=0){
        return view('design.modul')->with($this->model->getData($id));
    }
    public function getDataModul(Request $request){
        $get = $request->all();
        $this->model->getDataModul($get);
    }
    public function getDataFrame(Request $request){
        $get = $request->all();
        $this->model->getDataFrame($get);
    }

    public function update(Request $request){
        $post = $request->all();
        $message = [
            'title.required'=>$this->field['Tiêu đề Modul bắt buộc phải nhập'],
            'nametype.required'=>$this->field['Tiêu đề kiểu Modul bắt buộc phải nhập']
        ];
        $rules = [
            'title'=>'required',
            'nametype'=>'required'
        ];
        $v = \Validator::make($post,$rules,$message);
        if($v->fails()){            
            return redirect()->back()->withErrors($v->errors());
        }else{
            $rs = $this->model->update($post);
            if(!$rs[0]){
                return redirect()->back();
            }else{
                return redirect('/admin/design/modul/'.$rs[1]);
            }
        }
    }
    public function delete($id){
        $rs = $this->model->delete($id);
        return redirect('/admin/design/modul/'.$rs);
    }
}
