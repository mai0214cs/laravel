<?php
namespace App\Http\Controllers;
use App\HandleString;
use DB;
use Illuminate\Http\Request;

class loginController extends Controller{
    public function __construct() {
        //if(isset($_SESSION['Role'])){header('Location:/admin');} exit();
    }
    public function index(){
        return view('login');
    }
    public function confirmlogin(Request $request){
        $post = $request->all();
        $v = \Validator::make($post,
                [
                    'username'=>'required',
                    'password'=>'required'
                ]);
        if($v->fails()){            
            return redirect()->back()->withErrors($v->errors());
        }else{
            $post['password'] = HandleString::Cryption($post['password']);
            $data = DB::select('SELECT id, fullname, birthday, gender, address, phone, email, role FROM useradmin WHERE username=? AND password=?',array($post['username'],$post['password']));
            if(count($data)==0){
                \Session::flash('message','Đăng nhập thất bại');
                return redirect()->back();
            }else{
                \Session::put('UserAdmin',$data[0]);
                \Session::put('Role',explode(',',$data[0]->role));
                return redirect('admin/');
            }
        }
        
    }
    public function __destruct() {
        
    }
}
