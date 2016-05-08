<?php
namespace App\Common;

class UpdateMenu extends \App\Http\Models\Model {
    public function __construct() {
        parent::__construct();
    }

    private $datanew=array(); private $dem=0;
    // Danh sách Trình đơn quản trị trang thêm mới hoặc xuất danh sách
    public function ListMenu($data, $parent, $string){
        foreach ($data as $key => $item) {
            if($item->idcategory == $parent){
                unset($data[$key]);
                $this->datanew[$this->dem] = $item;
                $this->datanew[$this->dem]->namepage = $string.$item->namepage;
                if(isset($item->avatar)){$this->datanew[$this->dem]->avatar =  ReturnImage::Image($item->avatar);}
                $this->dem++;
                if($data){$this->ListMenu($data, $item->idpage,$string.'-----');}
            }
        }
        return $this->datanew;
    }
    
    // Danh sách Trình đơn quản trị trang chỉnh sửa 
    public function ListMenuEdit($data,$parentid,$current,$string = ''){        
        foreach ($data as $key => $item) {
            if($item->idcategory == $parentid){
                unset($data[$key]);
                if($item->idcategory!=$current){
                    $this->datanew[$this->dem] = $item;
                    $this->datanew[$this->dem]->namepage = $string.$item->namepage;
                    $this->dem++;
                    if($data){$this->ListMenuEdit($data, $item->idpage,$current,$string.'-----');}
                }
            }
        }
        return $this->datanew;
    }
    
    // Kiểm tra việc lựa chọn menu cha có phù hợp không
    public function SelectListMenuEdit($data,$id_capchads,$current){        
        foreach ($data as $key => $item) {
            if($item->idcategory == $id_capchads){
                unset($data[$key]);
                if($item->idpage!=$current){
                    $this->datanew[] = $item->idpage;
                    if($data){$this->SelectListMenuEdit($data, $item->idpage,$current);}
                }
            }
        }
        return $this->datanew;
    }
    
    public function ListId($data, $parent, $string){
        foreach ($data as $key => $item) {
            if($item->idcategory == $parent){
                unset($data[$key]);
                $this->datanew[$this->dem] = $item->idpage;
                $this->dem++;
                if($data){$this->ListMenu($data, $item->idpage,$string);}
            }
        }
        return $this->datanew;
    }
}
