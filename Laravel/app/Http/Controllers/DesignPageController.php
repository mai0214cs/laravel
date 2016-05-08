<?php
namespace App\Http\Controllers;
use App\Http\Models;
use Illuminate\Http\Request;
use App\Common\InfoMessage;
class DesignPageController extends BaseController {
    private $model; private $field; private $info;
    public function __construct() {
        $this->field = parent::__construct(100);
        $this->model = new Models\DesignPageModel($this->field);
        $this->info = new InfoMessage();
    }
    public function index($id=0, $type=''){
        return view('design.page')->with($this->model->getData($id, $type));
        
    }
    public function update(Request $request){
        $post = $request->all();
        $rs = $this->model->update($post);
        if($rs[0]){
            return redirect('/admin/design/page/'.$rs[1].'/'.$rs[2]);
        }else{
            return redirect()->back();
        }
    }
    public function delete(Request $request){
        $get = $request->all();
        $this->model->delete($get);
    }
    public function fields(Request $request){
        $get = $request->all();
        $this->model->fields($get);
    }
}
