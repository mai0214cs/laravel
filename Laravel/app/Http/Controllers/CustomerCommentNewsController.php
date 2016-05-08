<?php
namespace App\Http\Controllers;
use App\Http\Models\CustomerCommentNewsModel;
use App\Common\InfoMessage;
use Illuminate\Http\Request;
class CustomerCommentNewsController extends BaseController{
    private $model; private $field; private $info;
    public function __construct() {
        $this->field = parent::__construct('3a');
        $this->model = new CustomerCommentNewsModel($this->field);
        $this->info = new InfoMessage();
    }
    public function index(){
        return view('customer.CommentNews')->with($this->model->getList());
    }
    public function edit(Request $request){
        $get = $request->all();
        $this->model->editList($get);
    }
}
