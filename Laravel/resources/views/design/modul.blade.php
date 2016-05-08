@extends('masteradmin')
@section ('tagtitle')
{{$data[0]['Trang Cài đặt Modul']}}
@stop()
@section ('title')
{{$data[0]['Trang Cài đặt Modul']}}
@stop()
@section ('breadcumb')
    <li><a href="/admin">{{$data[0]['Giao diện']}}</a></li>
    <li class="active">{{$data[0]['Trang Cài đặt Modul']}}</li>
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
    height: 200px !important;
    border: 1px solid #eee;
}
.CodeMirror *{font-size: 12px;} 
.fancybox-wrap.fancybox-desktop.fancybox-type-inline.fancybox-opened {
    background: #fff;
    box-shadow: 0px 0px 3px;
}
</style> 
<form method="post" action="{{action('DesignModulController@update')}}">
    <input type="hidden" name="_token" value="{{csrf_token()}}" />
    <input type="hidden" value="{{$id}}" name="idmodul" />
    <div class="row">
        <div class="col-sm-3">
            <div class="box box-primary">
                <div class="box-header with-border"><h3 class="box-title">{{$data[0]['Danh sách Modul']}}</h3></div>
                <div class="box-body">
                    <div class="form-group">
                        <a href="/admin/design/modul" class="form-control <?= $id==0?'active':'' ?>">{{$data[0]['Thêm mới Modul']}}</a>     
                    </div>
                    <?php foreach ($listmodul as $v) { ?>
                    <div style="margin-top:5px;" class="input-group input-group-sm">
                        <a class="form-control <?= $id==$v->id?'active':'' ?>" href="/admin/design/modul/{{$v->id}}">{{$v->name}}</a>
                        <span class="input-group-btn">
                            <a onclick="return window.confirm('{{$data[0]['Câu hỏi xác nhận xóa modul']}}');" href="/admin/design/modul/delete/{{$v->id}}" class="btn btn-info btn-flat" ><i class="fa fa-fw fa-remove"></i></a>
                        </span>
                    </div>
                    <?php } ?>
                    
                </div>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="box box-primary">
                <div class="box-body row">
                    <div class="col-sm-6">
                        <fieldset>
                            <legend>{{$data[0]['Thông tin cấu hình']}}</legend>
                            <div class="form-group">
                                <label>{{$data[0]['Tiêu đề']}}</label>
                                <input class="form-control" name="title" value="{{isset($modul->name)?$modul->name:''}}" />
                            </div>
                            <div class="form-group">
                                <label>{{$data[0]['Mã đanh dấu']}}</label>
                                <input type="text" class="form-control" name="code" value="{{isset($modul->namesetup)?$modul->namesetup:''}}" />
                            </div>
                            <div class="form-group">
                                <label>{{$data[0]['Kiểu Modul']}}</label>
                                <select onchange="ChangeSelectTypeModul($(this).val())" class="form-control" name="type">
                                    <option value="0">{{$data[0]['Select Không lựa chọn']}}</option>
                                    <?php 
                                        for ($i = 1; $i <= count($typemodul); $i++) { 
                                    ?>
                                    <option value="{{$i}}">{{$typemodul[$i]}}</option>    
                                    <?php } ?>
                                </select>
                                
                            </div>
                        </fieldset>
                        <br/>
                        <fieldset>
                            <legend>{{$data[0]['Cấu hình thêm']}}</legend>
                            <div id="addSetupModul"></div>
                        </fieldset>
                    </div>
                    <div class="col-sm-6">
                        <fieldset>
                            <legend>{{$data[0]['Nội dung hiển thị']}}</legend>
                            <div class="form-group">
                                <label>{{$data[0]['Tiêu đề']}}</label>
                                <input class="form-control" name="nametype" value="{{isset($frame->name)?$frame->name:''}}" />
                            </div>
                            <div class="form-group">
                                <label>{{$data[0]['Chọn danh sách hiển thị']}}</label>
                                <select onchange="SelectFrameViewModul($(this).val())" class="form-control" id="ListDesignModul" name="listtype">
                                    <option value="0">{{$data[0]['Thêm mới Frame']}}</option>
                                    <?php 
                                    if(!is_null($listframe)){
                                        foreach ($listframe as $v) { ?>
                                    <option <?= $v->id==$frame->id?'selected="selected"':'' ?> value="{{$v->id}}">{{$v->name}}</option>
                                        <?php }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>{{$data[0]['Nội dung hiển thị']}}</label>
                                <div id="ContentFrame">
                                <textarea id="contenthtml" name="content">{{isset($frame->content)?$frame->content:''}}</textarea>
                                </div>
                            </div>
                        </fieldset>
                        <div class="box-footer">
                            <button type="button" class="btn btn-primary">{{$data[0]['Xóa nội dung hiển thị Modul']}}</button>
                        </div>
                    </div>
                    
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">{{$data[0]['Button Xác nhận gửi Form']}}</button>
                    <a id="fancyBoxLink" href="#fancybox" class="btn btn-success">{{$data[0]['Hướng dẫn']}}</a>
                    <a target="_blink" href="/admin/design/template" class="btn btn-success">{{$data[0]['Chuyển trang Template']}}</a>
                    <a target="_blink" href="/admin/design/item" class="btn btn-success">{{$data[0]['Quay lại Item']}}</a>
                </div>
            </div>
        </div>
    </div>
    <div style="clear: both;"></div>
</form>
@stop()
@section ('footer')
<div style="display:none;"><div id="fancybox"><?= \Session::get(lang.'guide102'); ?></div></div>
<link href="/libadmin/codemirror/lib/codemirror.css" rel="stylesheet" type="text/css"/>
<script src="/libadmin/codemirror/lib/codemirror.js" type="text/javascript"></script>
<script src="/libadmin/codemirror/addon/edit/closetag.js" type="text/javascript"></script>
<script src="/libadmin/codemirror/addon/fold/xml-fold.js" type="text/javascript"></script>
<script src="/libadmin/codemirror/mode/xml/xml.js" type="text/javascript"></script>
<script src="/libadmin/codemirror/mode/javascript/javascript.js" type="text/javascript"></script>
<script src="/libadmin/codemirror/mode/css/css.js" type="text/javascript"></script>
<script src="/libadmin/codemirror/mode/htmlmixed/htmlmixed.js" type="text/javascript"></script>
<script>
    function triggerEditor(){
        var editor = CodeMirror.fromTextArea(document.getElementById("contenthtml"), {
          mode:'text/html',
          lineNumbers: true,
          autoCloseTags: true
        });
    }
    triggerEditor();
    function ChangeSelectTypeModul(val){
        $.getJSON('/admin/design/modul/getDataModul',{type:val, id:{{$id}} }, function(data) {
            $('#addSetupModul').html(data.htmlsetup);
            $('#ListDesignModul').html('<option>Thêm mới</option>'+data.htmllist);
            <?php if(isset($frame->typemodul)){ ?>
            $('#ListDesignModul').val({{$frame->id}}); $('#ListDesignModul').trigger('change',function(){});
            <?php } ?>
	});
    }
    function SelectFrameViewModul(val){
        $.getJSON('/admin/design/modul/getDataFrame',{id:val}, function(data) {
            $('[name="nametype"]').val(data.name);
            $('#ContentFrame').html('<textarea id="contenthtml" name="content">'+data.content+'</textarea>');
            triggerEditor();
	});
    }
    <?php 
    if(isset($frame->typemodul)){
        echo '$(\'[name="type"]\').val('.$frame->typemodul.');$(\'[name="type"]\').trigger(\'change\',function(){});';
    }
    ?>
    $("a#fancyBoxLink").fancybox({
        'href'   : '#fancybox',
        'titleShow'  : false,
        'transitionIn'  : 'elastic',
        'transitionOut' : 'elastic'
    });
</script>
@stop()