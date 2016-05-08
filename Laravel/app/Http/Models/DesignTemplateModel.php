<?php
namespace App\Http\Models;
class DesignTemplateModel extends Model {
    private $titleadmin=array();
    public function __construct($setup) {
        parent::__construct();
        $this->titleadmin = $setup;
    }
    public function getData($id=0){
        $listtemp = $this->getDB->table('v_temp')->select('id','name')->orderBy('id', 'ASC')->get();
        $item = $this->getDB->table('v_temp')->select('id','name','content','ids_modul')->where('id',$id)->first();
        $listmodul = $this->getDB->table('v_modul')->select('id', 'namesetup')->orderBy('id','DESC')->get();
        $apply = $this->getDB->table('v_page')->select('id')->where('id_temp',$id)->orwhere('mobileid_temp',$id)->get(); $pagecur = array();
        foreach ($apply as $v) {
            $pagecur[] = $v->id;
        }
        return [
            'data'=>array($this->titleadmin),
            'listtemp'=>$listtemp,
            'listmodul'=>$listmodul,
            'item'=>$item,
            'id'=>$id,
            'page'=>$this->getDB->table('v_page')->select('id','name')->get(),
            'pagecur'=>$pagecur
        ];
    }
    public function update($post){
        $id_modul = array();
        if(isset($post['listmodul'])){ foreach ($post['listmodul'] as $v) { if($this->getDB->table('v_modul')->where('id',$v)->count()==1){$id_modul[]=$v;}}}
        $data = [
            'name'=>$post['title'],
            'content'=>$post['content'],
            'ids_modul'=>  implode(',', $id_modul)
        ];
        if($post['idtemp']==0){
            $idm = $this->getDB->table('v_temp')->insertGetId($data);
            if($idm>0){
                \Session::flash('message_success',$this->titleadmin['Thêm Template thành công']); return array(TRUE, $idm);
            }else{
                \Session::flash('message_error',$this->titleadmin['Thêm Template thất bại']); return array(FALSE, 0);
            }
        }else{
            if($this->getDB->table('v_temp')->where('id',$post['idtemp'])->update($data)>0){
                \Session::flash('message_success',$this->titleadmin['Sửa Template thành công']); return array(TRUE, $post['idtemp']);
            }else{
                \Session::flash('message_error',$this->titleadmin['Sửa Template thất bại']); return array(FALSE, $post['idtemp']);
            }
        }
    }
    
    public function applypage($id, $get){
        $data = [
            'id_temp'=>$id,
            'mobileid_temp'=>$id
        ];
        $count = 0;
        foreach ($get['ids'] as $v) {
            if($this->getDB->table('v_page')->where('id',$v)->update($data)>0){$count++;}
        }
        \Session::flash('message_success',$this->titleadmin['Thông báo số mục đã cập nhật'].$count);
    }
    public function delete($get){
        if($get['id']==$get['pagenew']){
            \Session::flash('message_error',$this->titleadmin['Thông báo xóa Template thất bại']);
            return;
        }
        if($this->getDB->table('v_temp')->where('id',$get['id'])->orwhere('id',$get['pagenew'])->count()!=2){
            \Session::flash('message_error',$this->titleadmin['Thông báo xóa Template thất bại']);
            return;
        }
        $data0 = ['id_temp'=>$get['pagenew']]; $data1 = ['mobileid_temp'=>$get['pagenew']]; 
        $this->getDB->table('v_page')->where('id_temp',$get['id'])->update($data0);
        $this->getDB->table('v_page')->where('mobileid_temp',$get['id'])->update($data1);
        if($this->getDB->table('v_temp')->where('id',$get['id'])->delete()>0){
            \Session::flash('message_success',$this->titleadmin['Thông báo xóa Template thành công']);
            return;
        }else{
            \Session::flash('message_error',$this->titleadmin['Thông báo xóa Template thất bại']);
            return;
        }
    }
}
