@extends('masteradmin')
@section ('tagtitle')
{{$data[0]['Trang Bộ lọc tùy chọn']}}
@stop()
@section ('title')
{{$data[0]['Trang Bộ lọc tùy chọn']}}
@stop()
@section ('breadcumb')
    <li><a href="#">{{$data[0]['Sản phẩm']}}</a></li>
    <li class="active">{{$data[0]['Trang Bộ lọc tùy chọn']}}</li>
@stop()

@section ('content')

    <div class="col-sm-6" id="AddGroupFilterOption">
        <div class="box box-danger">
            <div class="box-header with-border">
              <h4>{{$data[0]['Thông tin nhóm thuộc tính']}}</h4>
              
              
                <div class="input-group" style="width: 100%;">
                    <input type="text" style="width:50%;" class="form-control" name="g_title" placeholder="{{$data[0]['Nhóm thuộc tính mới']}}" />
                    <input type="text" style="width:10%;" class="form-control" name="g_order" value="0" />
                    <select style="width:30%;" class="form-control" name="g_type">
                        <option value="0">Checkbox</option>
                        <option value="1">Select</option>
                    </select>
                    <span style="width:10%;display: block;float: left;" class="input-group-addon">
                        <button style="width:100%;" onclick="AddGroupFilterOption()" class="form-control"><i class="fa fa-plus"></i></button>
                    </span>
                </div>
            </div>
        </div>
    </div>
<div style="clear:both;"></div>
<?php 
$count = count($data[1]);
for ($i = 0; $i < $count; $i++) { 
    if($i!=0&&$i%2==0){echo '<div style="clear:both;"></div>';}
    ?>

    <div class="col-sm-6" id="GroupFilterOption{{$data[1][$i]->id}}">
        <div class="box box-danger">
            <div class="box-header with-border">
              <h4>{{$data[0]['Thông tin nhóm thuộc tính']}}</h4>
                <div class="input-group" style="width: 100%;">
                    <input type="text" style="width:40%;" class="form-control" name="g_title" value="{{$data[1][$i]->name}}" />
                    <input type="text" style="width:10%;" class="form-control" name="g_order" value="{{$data[1][$i]->order}}" />
                    <select style="width:30%;" class="form-control" name="g_type">
                        <option <?= $data[1][$i]->type==0?'selected="selected"':'' ?> value="0">Checkbox</option>
                        <option <?= $data[1][$i]->type==1?'selected="selected"':'' ?> value="1">Select</option>
                    </select>
                    <span style="width:20%;display: block;float: left;" class="input-group-addon">
                        <button style="width:50%;" onclick="EditGroupFilterOption({{$data[1][$i]->id}})" class="form-control"><i class="fa fa-pencil"></i></button>
                        <button style="width:50%;" onclick="DeleteGroupFilterOption({{$data[1][$i]->id}})" class="form-control"><i class="fa fa-times"></i></button>
                    </span>
                </div>
            </div>
            <div class="box-body">
                <h4>{{$data[0]['Thông tin danh sách thuộc tính']}}</h4>
                <div class="input-group" style="margin-bottom:10px;" id="AddFilterOption{{$data[1][$i]->id}}">
                    <input type="text" style="width:50%;" class="form-control" name="i_value" placeholder="{{$data[0]['Tên thuộc tính mới']}}" />
                    <input type="text" style="width:50%;" class="form-control" name="i_order"  value="0">
                    <span class="input-group-addon">
                        <button onclick="AddFilterOption({{$data[1][$i]->id}})" class="form-control"><i class="fa fa-plus"></i></button>
                    </span>
                </div>
                <?php foreach ($data[2][$i] as $v) { ?>
                <div class="input-group" id="FilterOption{{$v->id}}">
                    <span class="input-group-addon">
                        <button onclick="DeleteFilterOption({{$v->id}})" class="form-control"><i class="fa fa-times"></i></button>
                    </span>
                    <input type="text" style="width:50%;" name="i_value" class="form-control" value="{{$v->value}}" />
                    <input type="text" style="width:50%;" name="i_order" class="form-control" value="{{$v->order}}">
                    <span class="input-group-addon">
                        <button onclick="EditFilterOption({{$v->id}})" class="form-control"><i class="fa fa-pencil"></i></button>
                    </span>
                </div>
                <?php } ?>
                
            </div><!-- /.box-body -->
        </div>
    </div>
  
<?php } ?>

<style>
.content>.box {
background: none;
box-shadow: 0px 0px 0px 0px;
border-top: 0px;
}
.input-group-addon {
padding: 0px;
border: 0px;
}
</style>
@stop()
@section ('footer')
<script>
function AddGroupFilterOption(){
    var pt = $('#AddGroupFilterOption');
    var g_name, g_order, g_type;
    g_name = pt.find('[name="g_title"]').val();
    g_order = pt.find('[name="g_order"]').val();
    g_type = pt.find('[name="g_type"]').val();
    $.get('/admin/product/filter/addgroup',{g_name:g_name, g_order:g_order, g_type:g_type},function(o){DirectPage();});
}
function EditGroupFilterOption(id){
    var pt = $('#GroupFilterOption'+id);
    var g_name, g_order, g_type;
    g_name = pt.find('[name="g_title"]').val();
    g_order = pt.find('[name="g_order"]').val();
    g_type = pt.find('[name="g_type"]').val();
    $.get('/admin/product/filter/editgroup',{g_id:id, g_name:g_name, g_order:g_order, g_type:g_type},function(o){DirectPage();});
}
function DeleteGroupFilterOption(id){
    $.get('/admin/product/filter/deletegroup',{g_id:id},function(o){DirectPage();});
}

function AddFilterOption(i_group){
    var pt = $('#AddFilterOption'+i_group);
    var i_value, i_order;
    i_value = pt.find('[name="i_value"]').val();
    i_order = pt.find('[name="i_order"]').val();
    $.get('/admin/product/filter/additem',{i_group:i_group, i_value:i_value, i_order:i_order},function(o){DirectPage();});
}
function EditFilterOption(id){
    var pt = $('#FilterOption'+id);
    var i_value, i_order;
    i_value = pt.find('[name="i_value"]').val();
    i_order = pt.find('[name="i_order"]').val();
    $.get('/admin/product/filter/edititem',{i_id:id, i_value:i_value, i_order:i_order},function(o){DirectPage();});
}
function DeleteFilterOption(id){
    $.get('/admin/product/filter/deleteitem',{i_id:id},function(o){DirectPage();});
}
</script>
@stop()