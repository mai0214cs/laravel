@extends('masteradmin')
@section ('tagtitle')
{{$titlepage}}
@stop()
@section ('title')
{{$titlepage}}
@stop()
@section ('breadcumb')
    <li><a href="/admin">{{$data[0]['Giao diện']}}</a></li>
    <li class="active">{{$titlepage}}</li>
@stop()

@section ('content')
<style>
section.content>.box {
    background: none;
    border: 0px;
    box-shadow: 0px 0px;
}    
a.active{background:#eee;}
.CodeMirror {
    width: 100%;
    height: 574px !important;
    border: 1px solid #eee;
}
.CodeMirror *{font-size: 12px;}  
</style> 
<form role="form" method="post" action="{{action('DesignItemController@update')}}">
    <input type="hidden" name="_token" value="{{csrf_token()}}" />
    <input type="hidden" value="{{$item}}" name="typepage" />
    <input type="hidden" value="{{$itemid}}" name="iditem" />
    <div class="row">
        <div class="col-sm-3">
            <div class="box box-primary" style="height: 692px; overflow-y: scroll;">
                <div class="box-header with-border"><h3 class="box-title">{{$data[0]['Danh sách mục đã thêm']}}</h3></div>
                <div class="box-body">
                    <div class="input-group input-group-sm">
                        <a class="form-control <?= $itemid==0?'active':'' ?>" href="/admin/design/item/{{$item}}">{{$data[0]['Thêm mới mục sản phẩm tin tức']}}</a>     
                    </div>  
                        <?php foreach ($pageitem as $v) { ?>
                        <div style="margin-top:5px;" class="input-group input-group-sm">
                            <a class="form-control <?= $itemid==$v->id?'active':'' ?>" href="/admin/design/item/{{$item}}/{{$v->id}}">{{$v->name}}</a>
                            <span class="input-group-btn">
                                <a onclick="return window.confirm('{{$data[0]['Câu hỏi xác nhận xóa mục trình bày']}}');" href="/admin/design/item/delete/{{$item}}/{{$v->id}}" class="btn btn-info btn-flat" ><i class="fa fa-fw fa-remove"></i></a>
                            </span>
                        </div>
                        <?php } ?>
                </div>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="box box-primary">
                <div class="box-body row">
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label>{{$data[0]['Nội dung hiển thị']}}</label>
                            <textarea class="form-control" name="content" id="contenthtml">{{isset($value->content)?$value->content:''}}</textarea>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>{{$data[0]['Tiêu đề']}}</label>
                            <input name="title" class="form-control" value="{{isset($value->name)?$value->name:''}}" />
                        </div>
                        <div class="form-group">
                            <label>{{$data[0]['Thứ tự']}}</label>
                            <input name="order" class="form-control" value="{{isset($value->order)?$value->order:''}}" />
                        </div>
                        <div class="form-group">
                            <label>{{$data[0]['Danh sách lựa chọn']}}</label>
                            <select name="item[]" multiple class="form-control" style="height:425px;">
                                <option value="-1">{{$data[0]['Select Không lựa chọn']}}</option>
                                <?php $ex1 = explode(',', isset($value->ids_fields)?$value->ids_fields:'');  for($i=0; $i<count($fields); $i++) { ?>
                                <option <?= in_array($i, $ex1)?'selected="selected"':'' ?> value="{{$i}}">{{$fields[$i]}}</option>    
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">{{$data[0]['Button Xác nhận gửi Form']}}</button>
                    <a id="fancyBoxLink" href="#fancybox" class="btn btn-success">{{$data[0]['Hướng dẫn']}}</a>
                    <a href="/admin/design/modul" target="_blink" class="btn btn-success">{{$data[0]['Chuyển trang Modul']}}</a>
                    <a href="/admin/design/page" target="_blink" class="btn btn-success">{{$data[0]['Chuyển trang Page']}}</a>
                </div>
            </div>


        </div>
    </div>
    <div style="clear: both;"></div>
    <div style="display:none;"><div id="fancybox"><?= \Session::get(lang.'guide101'); ?></div></div>
</form>
@stop()
@section ('footer')
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
</script>
@stop()