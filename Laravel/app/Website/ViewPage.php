<?php
namespace App\Website;
class ViewPage extends Model {
    function __construct($url) {
        parent::__construct();
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        // Variable config website / Select Variable
        $config = $this->getDB->table('configweb')->select('name','value')->get();
        $configweb = array();
        foreach ($config as $v){ $configweb[$v->name] = $v->value; }
        \Session::put('CONFIG',$configweb);
        $ver = new ApplicationBrowser();
        define('VERSION', $configweb['Áp dụng Mobile']?$ver->SelectBrowser()=='smartphone'?'mobile':'':'');
        // Get url page
        $urlex = explode('/', $url); $count1 = count($urlex); 
        if(lang==''){ $urlpage = $url; if($count1!=1){$this->PageError(); return;} }
        else{ if(!($count1==2&&lang==$url[0])){$this->PageError(); return;} $urlpage = $url[1]; }
        // Set Lib css js
        $this->setLibcssjs(); 
        // Get data page
        $urlpagex = explode('.', $urlpage); 
        $method = 'PAGE'.(isset($urlpagex[1])?$urlpagex[1]:'');  
        if(method_exists($this, $method)){
            $page = $this->{$method}($urlpage); 
            if(!in_array(isset($urlpagex[1])?$urlpagex[1]:'', array('','html'))){ return; }
            if(!isset($page->id)){ $this->PageError(); return; }
            \Session::put('PAGE',$page); 
        }else{$this->PageError(); return;} 
        // Select Template View
        $temp = $this->getDB->table('v_page AS a')->leftJoin('v_temp AS b', 'a.'.VERSION.'id_temp', '=', 'b.id')
            ->select('a.'.VERSION.'content AS contentpage', 'a.'.VERSION.'ids_item AS ids_item', 'a.'.VERSION.'ids_fields AS ids_fields', 'b.content AS contenttemp', 'b.ids_modul AS ids_modul')
            ->where('a.id',$page->id_vpage)->first();  
        if(!isset($temp->contentpage)){$this->PageError(); return;}
        $listmodul = explode(',', $temp->ids_modul); 
        $modul = $this->getDB->table('v_modul AS a')->leftJoin('v_frame AS b', 'a.id_frame', '=', 'b.id')->leftJoin('v_typemodul AS c', 'b.typemodul', '=', 'c.id')    
            ->select('c.func', 'a.namesetup', 'a.params', 'b.content', 'a.'.lang.'name AS name')->whereIn('a.id', $listmodul)->get();    
        $contents = array(); $fields = array(); 
        foreach ($modul as $v) {
            $detail_modul = 'Modul'.$modul->func;
            $func_modul = new $detail_modul();
            $contents[] = $func_modul->index($v->name, explode(',', $v->params), $v->content);
            $fields[] = $v->namesetup;
        } 
        // Setup Language
        $languages = $this->getDB->table('configlanguage')->select('name',lang.'value AS value')->get(); $language = array();
        foreach($languages as $value) { $language[$value->name] = $value->value; }
        \Session::put('LANGUAGE',$language);
        // View Data
        echo str_replace(
            array_merge($fields, array('{Nội dung đầu}','{Nội dung giữa}','{Nội dung cuối}')),     
            array_merge($contents, array($this->getContentHeader(), $this->getContentMain($temp->contentpage, explode(',', $temp->ids_fields), explode(',', $temp->ids_item)), $this->getContentFooter())), 
            $temp->contenttemp
        ); 
    }
    private $getLibcssjs;
    private function setLibcssjs(){ 
        $libs = $this->getDB->table('libview')->select('name', (VERSION==''?'web':'mobile').' AS lib')->get();
        foreach ($libs as $lib) {
            $this->getLibcssjs[$lib->name] = $lib->lib;
        }
    }
    // Content Header, Main, Footer
    private function getContentHeader(){ 
        $data = \Session::get('PAGE');
        $content = '<title>'.($data->seo_title!=''?$data->name:$data->seo_title).'</title>
	<meta http-equiv="keywords" content="'.($data->seo_keyword!=''?$data->name:$data->seo_keyword).'" />
	<meta http-equiv="description" content="'.($data->seo_description!=''?$data->name:$data->seo_description).'" />
        <link href="/style.css" rel="stylesheet" type="text/css" />
        <script src="/Lib/jquery-1.11.3.min.js" type="text/javascript"></script>';
        $content .= $this->getLibcssjs['Thư viện Header']; 
        return $content;
    }
    private $listpage = array(
        'PageHome', 'PageNewsCategory', 'PageNewsList', 'PageNewsTags',
        'PageProductCategory', 'PageProductList', 'PageProductTags', 'PageProductProcedure'
    );
    private function getContentMain($content, $item, $item_productnews){
        //$page = new PageNewsList();  
        $class = 'App\Website\\'.$this->listpage[\Session::get('PAGE')->typepage-1];
        $page = new $class();
        return $page->index($content, $item, $item_productnews);
    }
    private function getContentFooter(){
        $content = '<div id="resultUpdate"></div>
            <script src="/Lib/scripts.js" type="text/javascript"></script>
            ';
        $content .= $this->getLibcssjs['Thư viện Footer'];
        return $content;
    }

    // Get Data Page Sys
    private function PAGE($urlpage){
        return $this->getDB->table('pagesys')->select(
            'id AS id','id AS typepage', lang.'name AS name',lang.'description AS desscription',lang.'avatar AS avatar',lang.'detail AS detail',
            'url',lang.'seo_title AS seo_title',lang.'seo_description AS seo_description',lang.'seo_keyword AS seo_keyword',
            'tags',lang.'status AS status',lang.'id_vpage AS id_vpage'    
        )->where('url',$urlpage)->where(lang.'name','<>','')->first();
    }
    // Get Data Page
    private function PAGEhtml($urlpage){
        return $this->getDB->table('page')->select(
            'id',lang.'name AS name',lang.'description AS description',lang.'detail AS detail','id_category',
            'url',lang.'seo_title AS seo_title',lang.'seo_keyword AS seo_keyword',lang.'seo_description AS seo_description','ids_tags',
            lang.'status AS status','order','views','ids_news_related','ids_product_related',
            'typepage',lang.'id_vpage AS id_vpage','add_date','add_name','edit_date','edit_name',lang.'avatar AS avatar'
        )->where('url',$urlpage)->where(lang.'name','<>','')->first();
    }
    // Get File XML
    private function PAGExml($urlpage){
        
    }
    // Get File CSS
    private function PAGEcss($urlpage){
        if($urlpage=='style.css'){
            header("Content-type: text/css; charset: UTF-8");
            echo $this->getLibcssjs['Tập tin CSS'];
        }
    }
    private function PAGEjs($urlpage){
        if($urlpage=='script.js'){
            header("Content-type: text/javascript; charset: UTF-8");
            echo $this->getLibcssjs['Tập tin Javascript'];
        }
    }
}
