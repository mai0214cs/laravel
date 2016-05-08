@extends('masteradmin')
@section ('tagtitle')
{{$data[0]['Trang Cài đặt Template']}}
@stop()
@section ('title')
{{$data[0]['Trang Cài đặt Template']}}
@stop()
@section ('breadcumb')
    <li><a href="/admin">{{$data[0]['Giao diện']}}</a></li>
    <li class="active">{{$data[0]['Trang Cài đặt Template']}}</li>
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
<form method="post" action="{{action('DesignTemplateController@update')}}">
    <input type="hidden" name="_token" value="{{csrf_token()}}" />
    <input type="hidden" name="idtemp" value="{{$id}}" />
    <div class="row">
        <div class="col-sm-3">
            <div class="box box-primary">
                <div class="box-header with-border"><h3 class="box-title">{{$data[0]['Danh sách Template']}}</h3></div>
                <div class="box-body">
                    <div class="form-group">
                        <a class="form-control <?= $id==0?'active':'' ?>" href="/admin/design/template">{{$data[0]['Thêm mới Template']}}</a> 
                    </div>  
                    <?php foreach ($listtemp as $v) { ?>
                        <div style="margin-top:5px;" class="input-group input-group-sm">
                            <a class="form-control <?= $id==$v->id?'active':'' ?>" href="/admin/design/template/{{$v->id}}">{{$v->name}}</a>
                            <span class="input-group-btn">
                                <a id="fancyBoxLink2" onclick="$('[name=SelectTemplateDelete]').val({{$v->id}})" href="#fancybox2" class="btn btn-info btn-flat" ><i class="fa fa-fw fa-remove"></i></a>
                            </span>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <input type="hidden" value="" name="SelectTemplateDelete" />
        </div>
        
        <div class="col-sm-9">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <div class="form-group">
                      <label>{{$data[0]['Tiêu đề']}}</label>
                      <input type="text" name="title" class="form-control" name="title" value="{{isset($item->name)?$item->name:''}}" />
                    </div>
                </div>
                <div class="box-body row">
                    <div class="col-sm-8">
                        <div class="form-group">
                          <label>{{$data[0]['Nội dung hiển thị']}}</label>
                          <textarea id="contenthtml" class="form-control" name="content">{{isset($item->content)?$item->content:''}}</textarea>
                        </div>

                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                          <label>{{$data[0]['Danh sách modul Template']}} (*)</label>
                          <select multiple name="listmodul[]" class="form-control" style="height:500px;">
                              <option value="0">Không lựa chọn</option>
                              <?php 
                              $curr = explode(',',isset($item->ids_modul)?$item->ids_modul:'');
                              foreach ($listmodul as $v) { ?>
                                  <option <?= in_array($v->id, $curr)?'selected="selected"':'' ?> value="{{$v->id}}">{{'{'.$v->namesetup.'}'}}</option>
                              <?php } ?>
                          </select>
                        </div>
                    </div>
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">{{$data[0]['Button Xác nhận gửi Form']}}</button>
                    <a id="fancyBoxLink" href="#fancybox" class="btn btn-success">{{$data[0]['Hướng dẫn']}}</a>
                    <a href="/admin/design/modul" target="_blink" class="btn btn-success">{{$data[0]['Quay lại Modul']}}</a>
                    <?php if($id!=0){ ?>
                    <a id="fancyBoxLink1" href="#fancybox1" class="btn btn-success">{{$data[0]['Button Danh sách trang áp dụng Template']}}</a>
                    <?php } ?>
                    
                </div>
            </div>


        </div>
    </div>
    <div style="clear: both;"></div>
</form>
@stop()
@section ('footer')
<div style="display:none;"><div id="fancybox"><?= \Session::get(lang.'guide103'); ?></div></div>
<div style="display:none;"><div id="fancybox1">
        <div class="box box-primary">
                <div class="box-header with-border"><h3 class="box-title">{{$data[0]['Danh sách page Template']}}</h3></div>
                <div class="box-body">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th><input type="checkbox" onclick="togglecheckboxes(this)" /></th>
                <th>{{$data[0]['Tiêu đề']}}</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th><button onclick="XoaCheckAll('/admin/design/template/applypage/{{$id}}', '{{$data[0]['Hỏi Áp dụng trang Template']}}')" class="btn btn-default pull-left">{{$data[0]['Button Xác nhận gửi Form']}}</button></th>
                <th>{{$data[0]['Tiêu đề']}}</th>
            </tr>
        </tfoot>
        <tbody>
            <?php foreach ($page as $v) { ?>
            <tr>
                <th><input <?= in_array($v->id, $pagecur)?'checked="checked"':'' ?> class="CheckAll" type="checkbox" rel="{{$v->id}}" /></th>
                <th>{{$v->name}}</th>
            </tr>
            <?php } ?>
        </tbody>
    </table>    
                </div></div>
</div></div>
<div style="display:none;"><div id="fancybox2">
    <div class="box box-primary">
        <div class="box-header with-border"><h3 class="box-title">{{$data[0]['Danh sách page Template']}}</h3></div>
        <div class="box-body">
            <select class="form-control" name="apptempnew">
                <?php foreach ($listtemp as $v) { 
                    if($id==$v->id){continue;}
                    ?>
                <option value="{{$v->id}}">{{$v->name}}</option>
                <?php } ?>
            </select>
        </div>    
        <div class="box-footer">
            <button type="button" onclick="SubmitDeleteTemplate()" class="btn btn-primary">{{$data[0]['Button Xác nhận gửi Form']}}</button>
        </div>
    </div>
</div></div>
<link href="/libadmin/codemirror/lib/codemirror.css" rel="stylesheet" type="text/css"/>
<script src="/libadmin/codemirror/lib/codemirror.js" type="text/javascript"></script>
<script src="/libadmin/codemirror/addon/edit/closetag.js" type="text/javascript"></script>
<script src="/libadmin/codemirror/addon/fold/xml-fold.js" type="text/javascript"></script>
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
    $("a#fancyBoxLink2").fancybox({
        'href'   : '#fancybox2',
        'titleShow'  : false,
        'transitionIn'  : 'elastic',
        'transitionOut' : 'elastic'
    });
    function SubmitDeleteTemplate(){
        $.get('/admin/design/template/delete',{id:$('[name="SelectTemplateDelete"]').val(), pagenew:$('[name="apptempnew"]').val()},function(o){
            DirectPage();
        })
    }
</script>
@stop()