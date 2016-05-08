<?php
class MenuMultiLevel {
    private $datanew = array();
    private $dem = 0;
    public function DequiMenuDacap($danhsach,$id_capchads,$string = ''){
        foreach ($danhsach as $key => $item) {
            if($item[1] == $id_capchads){
                unset($danhsach[$key]);
                $this->datanew[$this->dem] = $item;
                $this->datanew[$this->dem][2] = $string.$item[2];
                $this->dem++;
                if($danhsach){$this->DequiMenuDacap($danhsach, $item['id'],$string.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');}
            }
        }
        return $this->datanew;
    }
    public function DequiSelectEditMenu($danhsach,$id_capchads,$current,$string = ''){        
        foreach ($danhsach as $key => $item) {
            if($item[1] == $id_capchads){
                unset($danhsach[$key]);
                if($item[0]!=$current){
                    $this->datanew[$this->dem] = $item;
                    $this->datanew[$this->dem][2] = $string.$item[2];
                    $this->dem++;
                    if($danhsach){$this->DequiSelectEditMenu($danhsach, $item['id'],$current,$string.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');}
                }
            }
        }
        return $this->datanew;
    }
    public function DequiMenuDacap1($danhsach,$id_capchads){
        foreach ($danhsach as $key => $item) {
            if($item[1] == $id_capchads){
                unset($danhsach[$key]);
                $this->datanew[] = $item[0];
                if($danhsach){$this->DequiMenuDacap1($danhsach, $item['id']);}
            }
        }
        return $this->datanew;
    }
    public function DequiSelectEditMenu1($danhsach,$id_capchads,$current){        
        foreach ($danhsach as $key => $item) {
            if($item[1] == $id_capchads){
                unset($danhsach[$key]);
                if($item[0]!=$current){
                    $this->datanew[] = $item[0];
                    if($danhsach){$this->DequiSelectEditMenu1($danhsach, $item['id'],$current);}
                }
            }
        }
        return $this->datanew;
    }
    public function LocId($current,$type, $typeadd){
        $x = DB::GetData('page', array('id, danhmuc, tieude'), 'id_Type=?', array($type),'thutu ASC, id DESC');
        $dsx = $this->DequiSelectEditMenu($x,0,$current);
        $dm = array();
        foreach ($dsx as $v) { $dm[] = $v['id']; }
        return 'NOT (danhmuc IN ('.  implode(',', $dm).')) AND id_Type='.$typeadd;
    }
    public function LocId1($current,$type, $typeadd){
        $x = DB::GetData('page', array('id, danhmuc, tieude'), 'id_Type=?', array($type),'thutu ASC, id DESC');
        $dsx = $this->DequiSelectEditMenu($x,0,$current);
        $dm = array();
        foreach ($dsx as $v) { $dm[] = $v['id']; }
        return 'NOT (a.danhmuc IN ('.implode(',',$dm).')) AND a.id_Type='.$typeadd;
    }
    public function LocIdXoa($current,$type){
        $x = DB::GetData('page', array('id, id_page, tieude'), 'type=?', array($type),'id_page ASC, thutu ASC, id DESC');
        $dsx = $this->DequiSelectEditMenu($x,0,$current);
        $dm = array();
        foreach ($dsx as $v) { $dm[] = $v['id']; }
        return 'NOT(id IN ('.  implode(',', $dm).')) AND id_Type='.$type;
    }
    
    
    
    public function Locdanhmuc($id, $type, $field){
        $x = DB::GetData('page', array('id, id_page, tieude'), 'type=?', array($type),'id_page ASC, thutu ASC, id DESC');
        $dsx = $this->DequiSelectEditMenu($x,0,$id);
        $dm = array(); foreach ($dsx as $v) { $dm[] = $v['id']; }
        return 'NOT('.$field.' IN ('.implode(',', $dm).'))';
    }
}
