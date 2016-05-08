<?php
namespace App\Http\TestModul;
use DB;
class ModulJson {
    public function Json($typemodul, $current){
        $getHTML = new ModulHTML(); 
        $htmlsetup = $getHTML->index($typemodul, $current);
        $listtypemodul = DB::table('v_frame')->select('id','name')->where('typemodul',$typemodul)->get(); $htmltype = '';
        foreach ($listtypemodul as $v) {$htmltype .='<option value="'.$v->id.'">'.$v->name.'<option>';}
        echo json_encode(array('htmlsetup'=>$htmlsetup,'htmllist'=>$htmltype));
    }
    public function JsonFrame($id){
        $data = DB::table('v_frame')->select('name', 'content')->where('id',$id)->first();
        if(isset($data->name)){
            echo json_encode(array('name'=>$data->name, 'content'=>$data->content));
        }else{
            echo json_encode(array('name'=>'', 'content'=>''));
        }
    }
}
