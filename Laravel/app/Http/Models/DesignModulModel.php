<?php
namespace App\Http\Models;
use App\Http\TestModul;
class DesignModulModel extends Model{
    private $titleadmin=array();
    public function __construct($setup) {
        parent::__construct();
        $this->titleadmin = $setup;
    }
    public function getData($id){
        $listmodul = $this->getDB->table('v_modul')->select('id','name')->get();
        $modul = $this->getDB->table('v_modul')->select('name', 'namesetup', 'id_frame', 'params')->where('id',$id)->first(); $frame=NULL; $listframe=NULL;
        if(isset($modul->id_frame)){
            $frame = $this->getDB->table('v_frame')->select('id', 'name', 'content', 'typemodul')->where('id',$modul->id_frame)->first();
            if(isset($frame->typemodul)){
                $listframe = $this->getDB->table('v_frame')->select('id','name')->where('typemodul',$frame->typemodul)->get();
            }
        }
        $listtypemodul = new TestModul\ModulListType();
        return [
            'id'=>$id,
            'data'=>array($this->titleadmin),
            'typemodul'=>$listtypemodul->listmodul,
            'modul'=>$modul,
            'frame'=>$frame,
            'listmodul'=>$listmodul,
            'listframe'=>$listframe
        ];
    }
    public function getDataModul($get){
        $json = new TestModul\ModulJson();
        $json->Json($get['type'], $get['id']);
    }
    public function getDataFrame($get){
        $json = new TestModul\ModulJson();
        $json->JsonFrame($get['id']);
    }

    public function update($post){
        $listtypemodul = new TestModul\ModulListType();
        $idframe=$post['listtype']; $idmodul = $post['idmodul']; 
        // Test type modul
        if(!isset($listtypemodul->listmodul[$post['type']])){
            \Session::flash('message_error',$this->titleadmin['Kiểu modul bạn chọn không hợp lệ']);
            return array(FALSE,$idmodul);
        }
        //Test namesetup
        if($idmodul==0){
            if($this->getDB->table('v_modul')->where('namesetup',$post['code'])->count()!=0){
                \Session::flash('message_error',$this->titleadmin['Mã cài đặt Modul đã tồn tại']);
                return array(FALSE,$idmodul);
            }
            
        }else{
            if($this->getDB->table('v_modul')->where('namesetup',$post['code'])->where('id','<>',$idmodul)->count()==1){
                \Session::flash('message_error',$this->titleadmin['Mã cài đặt Modul đã tồn tại']);
                return array(FALSE,$idmodul);
            }
        }
        // Test Setup modul
        $setupmodul=array();
        if(isset($post['setupmodul'])){
            $setupmodul = $post['setupmodul'];
        }
        $test = new TestModul\ModulTest();
        if(!$test->Test($post['type'], $setupmodul)){
            \Session::flash('message_error',$this->titleadmin['Thông số cài đặt Modul không hợp lệ']);
            return array(FALSE,$idmodul);
        }
        // Update table frame
        $frame = [
            'name'=>$post['nametype'], 
            'content'=>$post['content'],
            'typemodul'=>$post['type'] 
        ];
        if($idframe==0){
            $idframe = $this->getDB->table('v_frame')->insertGetId($frame);
            if($idframe<=0){
                \Session::flash('message_error',$this->titleadmin['Thêm mẫu trình bày modul thất bại']);
                return array(FALSE,$idmodul);
            }
        }else{
            if($this->getDB->table('v_frame')->where('id',$idframe)->update($frame)<=0){
                \Session::flash('message_error',$this->titleadmin['Cập nhật mẫu trình bày modul thất bại']);
            }
        }
        // Update table modul
        $modul = [
            'name'=>$post['title'], 
            'namesetup'=>$post['code'], 
            'id_frame'=>$idframe, 
            'params'=>  implode(',', $setupmodul),
        ];
        if($idmodul==0){
            $idmodul = $this->getDB->table('v_modul')->insertGetId($modul);
            if($idmodul>0){
                \Session::flash('message_success',$this->titleadmin['Thêm modul thành công']); return array(TRUE,$idmodul);
            }else{
                \Session::flash('message_error',$this->titleadmin['Thêm modul thất bại']); return array(FALSE,$idmodul);
            }
        }else{
            if($this->getDB->table('v_modul')->where('id',$idmodul)->update($modul)>0){
                \Session::flash('message_success',$this->titleadmin['Cập nhật modul thành công']); return array(TRUE,$idmodul);
            }else{
                \Session::flash('message_error',$this->titleadmin['Cập nhật modul thất bại']); return array(FALSE,$idmodul);
            }
        }
    }
    public function delete($id){
        if($this->getDB->table('v_modul')->where('id',$id)->delete()>0){
            \Session::flash('message_success',$this->titleadmin['Xóa Modul thành công']);
            return 0;
        }else{
            \Session::flash('message_error',$this->titleadmin['Xóa Modul thất bại']);
            return $id;
        }
    }
    
}
