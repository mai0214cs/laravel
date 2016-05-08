<?php
namespace App\Http\Controllers;
use App\Common\LanguagePage;
use Illuminate\Http\Request;
class UpdateController extends Controller {
    private $DB = NULL;    private $info;    private $message;
    public function __construct() {
        $lang = new LanguagePage();
        $lang->defaultLanguage();
        
        $conn = new \App\Website\Model();
        $this->DB = $conn->getDB;
        
        $data = $this->DB->table('configlanguage')->select('name',lang.'value AS value')->get();
        foreach ($data as $value) { $this->info[$value->name] = $value->value; } 
        
        $this->message = new \App\Common\InfoMessage();
    }

    public function index($function_name, $id='', Request $request=NULL){ 
        $data = $request->all();
        if(method_exists($this, $function_name)){
            $this->$function_name($id, $data);
        }
    }
    private function ChangeLanguage($code, $data){
        $a = new LanguagePage(); $a->setLanguage($code);
    }
    private function Comment($type, $data){
        if(!in_array($type, array(0,1))){return;}
        if($data['parent']!=0){
            if($this->DB->table('comment')->where('id',$data['parent'])->where('type',$type)->where('id_page',$data['id'])->count()==0){return;}
        }
        if($this->DB->table('page')->where('id',$data['id'])->where('typepage',($type==0)?3:6)->count()==0){return;}
        if(!in_array($data['mark'], array(1,2,3,4,5))){return;}
        if(trim($data['name'])==''){
            // Họ và tên bắt buộc phải nhập
            echo json_encode(array('update'=>0, 'info'=>$this->message->Error($this->info['Họ và tên bắt buộc phải nhập']))); return;
        }
        if(trim($data['title'])==''){
            // Tiêu đề bình luận bắt buộc phải nhập
            echo json_encode(array('update'=>0, 'info'=>$this->message->Error($this->info['Tiêu đề bắt buộc phải nhập']))); return;
        }
        if(trim($data['content'])==''){
            // Nội dung bình luận bắt buộc phải nhập
            echo json_encode(array(
                'update'=>0, 
                'info'=>$this->message->Error($this->info['Nội dung bắt buộc phải nhập'])
            ));
            return;
        }
        if(!filter_var($data['email'],FILTER_VALIDATE_EMAIL)){
            // Địa chỉ email không hợp lệ
            echo json_encode(array(
                'update'=>0, 
                'info'=>$this->message->Error($this->info['Email nhập không đúng định dạng'])
            ));
            return;
        }
        $dt = [
            'type'=>$type,
            'name'=>$data['name'],
            'email'=>$data['email'],
            'mark'=>$data['mark'],
            'title'=>$data['title'],
            'content'=>$data['content'],
            'parent'=>$data['parent'],
            'id_page'=>$data['id']
        ];
        if($this->DB->table('comment')->insert($dt)>0){
            echo json_encode(array( 'update'=>1, 'info'=>$this->message->Success($this->info['Gửi bình luận thành công'])));
            if(!\Session::get('Comment')){return;} \Session::put('Comment',NULL); return;
        }else{
            echo json_encode(array('update'=>0, 'info'=>$this->message->Error($this->info['Gửi bình luận thất bại']))); return;
        }
    }
}
