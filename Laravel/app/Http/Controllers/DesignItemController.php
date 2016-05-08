<?php
namespace App\Http\Controllers;
use App\Http\Models;
use Illuminate\Http\Request;
use App\Common\InfoMessage;
class DesignItemController extends BaseController {
    private $model; private $field; private $info;
    public function __construct() {
        $this->field = parent::__construct(101);
        $this->model = new Models\DesignItemModel($this->field);
        $this->info = new InfoMessage();
    }
    public function index($id, $item=''){
        return view('design.item')->with($this->model->getData($id, $item));
    }
    public function update(Request $request){
        $post = $request->all();
        $update = $this->model->updateData($post);
        if($update[0]){
            return redirect('/admin/design/item/'.$update[1].'/'.$update[2]);
        }else{
            return redirect()->back();
        }
    }
    public function delete($id, $item){
        $this->model->delete($id, $item);
        return redirect('/admin/design/item/'.$id);
    }
}
