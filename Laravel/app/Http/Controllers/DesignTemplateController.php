<?php
namespace App\Http\Controllers;
use App\Http\Models;
use Illuminate\Http\Request;
use App\Common\InfoMessage;
class DesignTemplateController extends BaseController {
    private $model; private $field; private $info;
    public function __construct() {
        $this->field = parent::__construct(103);
        $this->model = new Models\DesignTemplateModel($this->field);
        $this->info = new InfoMessage();
    }
    public function index($id=0){
        return view('design.template')->with($this->model->getData($id));
    }
    public function update(Request $request){
        $post = $request->all();
        $rs = $this->model->update($post);
        if($rs[0]){
            return redirect('/admin/design/template/'.$rs[1]);
        }else{
            return redirect()->back();
        }
    }
    public function applypage($id, Request $request){
        $get = $request->all();
        $this->model->applypage($id, $get);
    }
    public function delete(Request $request){
        $get = $request->all();
        $this->model->delete($get);
    }
}
