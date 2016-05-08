@extends('masteradmin')
@section ('tagtitle')
{{$data[0]['Trang Cài đặt Page']}}
@stop()
@section ('title')
{{$data[0]['Trang Cài đặt Page']}}
@stop()
@section ('breadcumb')
    <li><a href="/admin">{{$data[0]['Giao diện']}}</a></li>
    <li class="active">{{$data[0]['Trang Cài đặt Page']}}</li>
@stop()

@section ('content')
<style>
section.content>.box {
    background: none;
    border: 0px;
    box-shadow: 0px 0px;
}   
.CodeMirror {
    width: 100%;
    height: 500px !important;
    border: 1px solid #eee;
}
.CodeMirror *{font-size: 12px;} 
a.active{background:#eee;}
.fancybox-wrap.fancybox-desktop.fancybox-type-inline.fancybox-opened {
    background: white;
    z-index: 1000000;
    border: 1px solid #ccc;
    min-height: 500px;
}
.fancybox-inner {
    min-height: 500px !important;
}
</style> 
<?php 
$itemdesign = isset($info->ids_item)?explode(',', $info->ids_item):array(0,0,0,0,0,0);
$itemfields = isset($info->ids_fields)?explode(',', $info->ids_fields):array();
?>
<form method="post" action="{{action('DesignPageController@update')}}">
    <input type="hidden" name="_token" value="{{csrf_token()}}" />
    <input type="hidden" name="idpage" value="{{$id}}" />
    <input type="hidden" name="idtypepage" value="{{$type}}" />
    <div class="row">
        <div class="col-sm-3">
            <div class="box box-primary">
                <div class="box-header with-border"><h3 class="box-title">{{$data[0]['Danh sách Page']}}</h3></div>
                <div class="box-body">
                    <div class="form-group">
                        <a class="form-control <?= $id==0?'active':'' ?>" href="/admin/design/page/0/{{$type}}">{{$data[0]['Thêm mới Page']}}</a>  
                        <?php  foreach ($listpage as $v) { ?>
                        <a class="form-control <?= $id==$v->id?'active':'' ?>" href="/admin/design/page/{{$v->id}}/{{$type}}">{{$v->name}}</a>  
                        <?php } ?>

                    </div>  
                </div>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="box box-primary">
                <div class="box-header with-border"><h3 class="box-title">{{$data[0]['Thông tin cài đặt']}}</h3></div>
                <div class="box-body">
                    <div class="col-sm-4">
                        <div class="form-group">
                          <label>{{$data[0]['Tiêu đề']}}</label>
                          <input type="text" name="title" class="form-control" value="{{isset($info->name)?$info->name:''}}" />
                        </div>
                        <div class="form-group">
                          <label>{{$data[0]['Template']}}</label>
                          <select name="template" class="form-control">
                            <?php $id_temp = isset($info->id_temp)?$info->id_temp:0; foreach ($template as $v) { ?>
                              <option <?= $id_temp==$v->id?'selected="selected"':'' ?> value="{{$v->id}}">{{$v->name}}</option>      
                            <?php } ?>
                          </select>
                        </div>
                        <div class="form-group" <?= $id!=0?'style="display:none;"':'' ?>>
                          <label>{{$data[0]['Kiểu trang']}}</label>
                          <select onchange="ChangeTypePage($(this).val())" name="typepage" class="form-control">
                            <?php $page_typepage = isset($info->typepage)?$info->typepage:0; for ($i = 0; $i < count($typepage); $i++) { ?>
                            <option <?= $page_typepage==$i?'selected="selected"':'' ?> value="{{$i}}">{{$typepage[$i]}}</option>      
                            <?php } ?>
                          </select>
                        </div>
                        <div class="form-group">
                          <label>{{$data[0]['Thứ tự']}}</label>
                          <input type="number" name="order" class="form-control" value="{{isset($info->order)?$info->order:0}}" />
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                          <label>{{$data[0]['Mục sản phẩm danh mục']}}</label>
                          <select name="product_list" class="form-control">
                            <?php  foreach ($item_product as $v) { ?>
                              <option <?= $itemdesign[0]==$v->id?'selected="selected"':'' ?> value="{{$v->id}}">{{$v->name}}</option>      
                            <?php } ?>
                          </select>
                        </div>
                        <div class="form-group">
                          <label>{{$data[0]['Mục sản phẩm cùng danh mục']}}</label>
                          <select name="product_category" class="form-control">
                            <?php  foreach ($item_product as $v) { ?>
                              <option <?= $itemdesign[1]==$v->id?'selected="selected"':'' ?> value="{{$v->id}}">{{$v->name}}</option>      
                            <?php } ?>
                          </select>
                        </div>
                        <div class="form-group">
                          <label>{{$data[0]['Mục sản phẩm liên quan']}}</label>
                          <select name="product_related" class="form-control">
                            <?php  foreach ($item_product as $v) { ?>
                              <option <?= $itemdesign[2]==$v->id?'selected="selected"':'' ?> value="{{$v->id}}">{{$v->name}}</option>      
                            <?php } ?>
                          </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                          <label>{{$data[0]['Mục tin tức danh mục']}}</label>
                          <select name="news_list" class="form-control">
                            <?php  foreach ($item_news as $v) { ?>
                              <option <?= $itemdesign[3]==$v->id?'selected="selected"':'' ?> value="{{$v->id}}">{{$v->name}}</option>      
                            <?php } ?>
                          </select>
                        </div>
                        <div class="form-group">
                          <label>{{$data[0]['Mục tin tức cùng danh mục']}}</label>
                          <select name="news_category" class="form-control">
                            <?php  foreach ($item_news as $v) { ?>
                              <option <?= $itemdesign[4]==$v->id?'selected="selected"':'' ?> value="{{$v->id}}">{{$v->name}}</option>      
                            <?php } ?>
                          </select>
                        </div>
                        <div class="form-group">
                          <label>{{$data[0]['Mục tin tức liên quan']}}</label>
                          <select name="news_related" class="form-control">
                            <?php  foreach ($item_news as $v) { ?>
                              <option <?= $itemdesign[5]==$v->id?'selected="selected"':'' ?> value="{{$v->id}}">{{$v->name}}</option>      
                            <?php } ?>
                          </select>
                        </div>
                    </div>
                </div><!-- /.box-body -->
            </div>

            <div class="box box-primary">
                <div class="box-header with-border"><h3 class="box-title">{{$data[0]['Thông tin giao diện']}}</h3></div>
                <div class="box-body">
                    <div class="col-sm-9">
                        <div class="form-group">
                          <label>{{$data[0]['Nội dung hiển thị']}}</label>
                          <textarea id="contenthtml" name="contenthtml" style="height: 500px;" class="form-control">
                              {{isset($info->content)?$info->content:''}}
                          </textarea>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                          <label>{{$data[0]['Danh sách fields']}}</label>
                          <select multiple name="list_field[]" id="ListFields" style="height:500px;" class="form-control">
                              <?php 
                                for ($i = 0; $i < count($selecttypepage); $i++) {
                                    echo '<option value="'.$i.'" '.(in_array($i, $selectcurrent)?'selected="selected"':'').'>'.$selecttypepage[$i].'</option>';
                                }
                              ?>
                          </select>
                        </div>
                    </div>
                </div><!-- /.box-body -->
            </div>            

            <div class="box-footer">
                <button type="submit" class="btn btn-primary">{{$data[0]['Button Xác nhận gửi Form']}}</button>
                <a id="fancyBoxLink" href="#fancybox" class="btn btn-success">{{$data[0]['Hướng dẫn']}}</a>
                <?php if($id!=0){ ?> 
                <a id="fancyBoxLink1" href="#fancybox1" class="btn btn-success">Xóa</a>
                <?php } ?>
            </div>
        </div>
    </div>
    <div style="clear: both;"></div>
</form>
@stop()
@section ('footer')
<div style="display:none;"><div id="fancybox"><?= \Session::get(lang.'guide100'); ?></div></div>
<?php if($id!=0){ ?> 
<div style="display:none;"><div id="fancybox1">
    <div class="box box-primary">
        <div class="box-header with-border"><h3 class="box-title">{{$data[0]['Chọn Page chuyển đổi']}}</h3></div>
        <div class="box-body">
            <select class="form-control" name="apppagenew">
                <?php  foreach ($listpage as $v) { 
                    if($id==$v->id){continue;} 
                    if($page_typepage!=$v->typepage){continue;}
                    ?>
                <option <?= in_array($v->id, $itemfields)?'selected="selected"':'' ?> value="{{$v->id}}">{{$v->name}}</option>
                <?php } ?>
            </select>
        </div>    
        <div class="box-footer">
            <button type="button" onclick="SubmitDeletePage()" class="btn btn-primary">{{$data[0]['Button Xác nhận gửi Form']}}</button>
        </div>
    </div>
</div></div>
<?php } ?>
<link href="/libadmin/codemirror/lib/codemirror.css" rel="stylesheet" type="text/css"/>
<script src="/libadmin/codemirror/lib/codemirror.js" type="text/javascript"></script>
<script src="/libadmin/codemirror/mode/xml/xml.js" type="text/javascript"></script>
<script src="/libadmin/codemirror/mode/javascript/javascript.js" type="text/javascript"></script>
<script src="/libadmin/codemirror/mode/css/css.js" type="text/javascript"></script>
<script src="/libadmin/codemirror/mode/htmlmixed/htmlmixed.js" type="text/javascript"></script>

<script>
    var editor = CodeMirror.fromTextArea(document.getElementById("contenthtml"), {
        mode:'text/html',
        lineNumbers: true,
        autoCloseTags: true
    });
    $("a#fancyBoxLink").fancybox({
        'href'   : '#fancybox',
        'titleShow'  : false,
        'transitionIn'  : 'elastic',
        'transitionOut' : 'elastic'
    });
    $("a#fancyBoxLink1").fancybox({
        'href'   : '#fancybox1',
        'titleShow'  : false,
        'transitionIn'  : 'elastic',
        'transitionOut' : 'elastic'
    });
    function ChangeTypePage(val){
        $.get('/admin/design/page/fields',{val:val,type:'{{$type}}'}, function(o){
            $('#ListFields').html(o);
        });
    }
    <?php if($id!=0){ ?> 
    function SubmitDeletePage(){
        $.get('/admin/design/page/delete',{id:{{$id}}, type:'{{$type}}', idm:$('[name="apppagenew"]').val()},function(o){
            window.location.href='/admin/design/page/0/{{$type}}';
        });
    }
    <?php } ?>
</script>
@stop()