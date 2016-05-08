@extends('masteradmin')
@section ('tagtitle')
{{$data[0]['Trang Tags Sản phẩm']}}
@stop()
@section ('title')
{{$data[0]['Trang Tags Sản phẩm']}}
@stop()
@section ('breadcumb')
    <li><a href="#">{{$data[0]['Sản phẩm']}}</a></li>
    <li class="active">{{$data[0]['Trang Tags Sản phẩm']}}</li>
@stop()

@section ('content')
<div style="row">
<div class="col-sm-4">
    <div class="input-group addtagsproduct" style="margin: 5px 0px;" rel="0">
        <span class="input-group-addon">&nbsp;</span>
        <input type="text" class="form-control" placeholder="{{$data[0]['Thêm mới tags']}}" name="value" value="" />
        <span class="input-group-addon" onclick="InsertData()"><i class="fa fa-tag"></i></span>
    </div>    
</div>
<?php foreach ($data[1] as $v) { ?>

<div class="col-sm-4">
    <div class="input-group edittagsproduct{{$v->id}}" style="margin: 5px 0px;">
        <span class="input-group-addon"><input class="CheckAll" type="checkbox" rel="{{$v->id}}" /></span>
        <input type="text" class="form-control" value="{{$v->{lang.'name'} }}" name="value" />
        <span class="input-group-addon" onclick="UpdateData({{$v->id}})"><i class="fa fa-edit"></i></span>
    </div>    
</div>
<?php } ?>
    </div>
<div class="box-footer">
    <a href="javascript:;" class="btn btn-info" onclick="XoaCheckAll('/admin/product/tags/delete', '{{$data[0]['Thông báo xác nhận xóa']}}')" style="clear: both;">{{$data[0]['Nút Xóa tất cả mục chọn']}}</a>
</div>
@stop()
@section ('footer')
<script>
function InsertData(){
    var val = $('.addtagsproduct [name="value"]').val();
    $.get('/admin/product/tags/add',{val:val},function(o){
        DirectPage();
    });
}
function UpdateData(id){
    var val = $('.edittagsproduct'+id+' [name="value"]').val();
    $.get('/admin/product/tags/edit',{id:id, val:val},function(o){
        DirectPage();
    });
}
</script>
@stop()