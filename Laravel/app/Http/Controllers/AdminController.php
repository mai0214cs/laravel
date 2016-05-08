<?php
namespace App\Http\Controllers;
class AdminController extends BaseController {
    private $field;
    public function __construct() {
        $this->field = parent::__construct(0);
    }

    public function index(){
        return view('admin.index')->with('data',  array($this->field));
    }
}
