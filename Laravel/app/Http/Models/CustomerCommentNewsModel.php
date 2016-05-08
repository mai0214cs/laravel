<?php
namespace App\Http\Models;
use App\Common\UpdateMenu;
class CustomerCommentNewsModel extends Model{
    private $titleadmin=array();
    public function __construct($setup) {
        parent::__construct();
        $this->titleadmin = $setup;
    }
    public function getList(){
        $menu = new UpdateMenu(); 
        $data = $this->getDB->table('comment AS a')->leftJoin('page AS b','a.id_page','=','b.id')->select('a.id AS idpage','a.parent AS idcategory','a.name AS namepage','a.email','a.mark','b.'.lang.'name','b.url','a.status','a.date')->where('a.type',0)->orderBy('a.id','DESC')->get();
        return ['data'=>array($this->titleadmin),'list'=>$menu->ListMenu($data, 0, '')];
    }
    public function editList($get){
        if($get['idcomment']!=0){
            if($this->DB->table('comment')->where('id',$get['idcomment'])->where('type',0)->where('id_page',$get['idpage'])->count()==0){return;}
        }
        if($this->DB->table('page')->where('id',$get['idpage'])->where('typepage',3)->count()==0){return;}
        if(!in_array($data['mark'], array(1,2,3,4,5))){return;}
        if(trim($get['name'])==''){
            // Họ và tên bắt buộc phải nhập
            echo json_encode(array('update'=>0, 'info'=>$this->message->Error($this->info['Họ và tên bắt buộc phải nhập']))); return;
        }
        if(trim($get['title'])==''){
            // Tiêu đề bình luận bắt buộc phải nhập
            echo json_encode(array('update'=>0, 'info'=>$this->message->Error($this->info['Tiêu đề bắt buộc phải nhập']))); return;
        }
        if(trim($get['content'])==''){
            // Nội dung bình luận bắt buộc phải nhập
            echo json_encode(array(
                'update'=>0, 
                'info'=>$this->message->Error($this->info['Nội dung bắt buộc phải nhập'])
            ));
            return;
        }
        if(!filter_var($get['email'],FILTER_VALIDATE_EMAIL)){
            // Địa chỉ email không hợp lệ
            echo json_encode(array(
                'update'=>0, 
                'info'=>$this->message->Error($this->info['Email nhập không đúng định dạng'])
            ));
            return;
        }
        $dt = [
            'type'=>0,
            'name'=>$get['name'],
            'email'=>$get['email'],
            'mark'=>$get['mark'],
            'title'=>$get['title'],
            'content'=>$get['content'],
            'parent'=>$get['idcomment'],
            'id_page'=>$get['idpage']
        ];
        if($get['idupdate']==0){
            if($this->DB->table('comment')->insert($dt)>0){
                echo json_encode(array( 'update'=>1, 'info'=>$this->message->Success($this->info['Gửi bình luận thành công'])));
            }else{
                echo json_encode(array('update'=>0, 'info'=>$this->message->Error($this->info['Gửi bình luận thất bại']))); return;
            }
        }else{
            if($this->DB->table('comment')->where('id',$get['idupdate'])->update($dt)>0){
                echo json_encode(array( 'update'=>1, 'info'=>$this->message->Success($this->info['Gửi bình luận thành công'])));
            }else{
                echo json_encode(array('update'=>0, 'info'=>$this->message->Error($this->info['Gửi bình luận thất bại']))); return;
            }
        }
        
    }
}


