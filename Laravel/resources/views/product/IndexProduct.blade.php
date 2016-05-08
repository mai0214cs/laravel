@extends('masteradmin')
@section ('tagtitle')
{{$data[0]['Trang Danh sách sản phẩm']}}
@stop()
@section ('title')
{{$data[0]['Trang Danh sách sản phẩm']}}
@stop()
@section ('breadcumb')
    <li><a href="#">{{$data[0]['Sản phẩm']}}</a></li>
    <li class="active">{{$data[0]['Trang Danh sách sản phẩm']}}</li>
@stop()

@section ('content')
<div class="box-header with-border">
    <a href="/admin/product/list/add" style="margin-right: 10px;" class="btn bg-green pull-left"><i class="fa fa-fw fa-plus"></i> {{$data[0]['Nút Thêm mới Danh sách']}}</a>
    <a style="margin-right: 10px;" onclick="XoaCheckAll('/admin/product/list/deleteAll', '{{$data[0]['Thông báo xác nhận xóa']}}')" class="btn bg-red pull-left"><i class="fa fa-fw fa-remove"></i> {{$data[0]['Nút Xóa tất cả mục chọn']}}</a>
    <a href="/admin/product/list/exportExcel" style="margin-right: 10px;" class="btn btn-info pull-left"><i class="fa fa-fw fa-cloud-download"></i> {{$data[0]['Xuất Excel']}}</a>
    <button type="button" onclick="AddFileImport()" style="margin-right: 10px;" class="btn bg-green pull-left"><i class="fa fa-fw fa-cloud-upload"></i> {{$data[0]['Nhập Excel']}}</button>
</div>


<div class="box-header with-border">
    <div class="col-sm-3">
        <div style="width: 50%; float: left;">
            <div class="form-group">
              <label>{{$data[0]['Số lượng hiển thị']}}</label>
              <input type="number" min="10" max="300" value="10" class="form-control" name="PageCount" onblur="LoadListProductFind()" />
            </div>
        </div>
        <div style="width: 50%; float: left;">
            <div class="form-group">
              <label>{{$data[0]['Trang hiển thị']}}</label>
              <select onchange="LoadListProductFind()" style="width: 100%;" name="PageItem" class="form-control">
                  <option value="1">{{$data[0]['Thứ tự trang']}} 1</option>
              </select>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
            <div class="form-group">
              <label>{{$data[0]['Từ khóa hiển thị']}}</label>
              <input style="width: 100%;" type="text" class="form-control" name="PageKey" value="" onblur="LoadListProductFind()" />
            </div>
    </div>
    <div class="col-sm-3">
            <div class="form-group">
              <label>{{$data[0]['Danh mục hiển thị']}}</label>
              <select style="width: 100%;" name="PageCategory" class="form-control" onchange="LoadListProductFind()">
                  <option value="0">{{$data[0]['Tất cả danh mục']}}</option>
                  <?php foreach ($data[2] as $v) { ?>
                  <option value="{{$v->idpage}}">{{$v->namepage}}</option>
                  <?php } ?>
              </select>
            </div>
    </div>
    <div class="col-sm-3">
            <div class="form-group">
              <label>{{$data[0]['Sắp xếp hiển thị']}}</label>
              <select name="PageOrder" class="form-control" onchange="LoadListProductFind()">
                  <option value="0">{{$data[0]['Sản phẩm mới']}}</option>
                  <option value="1">{{$data[0]['Sản phẩm cũ']}}</option>
                  <option value="2">{{$data[0]['Tiêu đề A-Z']}}</option>
                  <option value="3">{{$data[0]['Tiêu đề Z-A']}}</option>
                  <option value="4">{{$data[0]['Giá bán tăng']}}</option>
                  <option value="5">{{$data[0]['Giá bán giảm']}}</option>
                  <option value="6">{{$data[0]['Xem nhiều']}}</option>
              </select>
            </div>
    </div>
</div>




<table class="table table-bordered table-hover">
    <thead>
        <th><input type="checkbox" onclick="togglecheckboxes(this)" /></th>
        <th>{{$data[0]['Tiêu đề']}}</th>
        <th>{{$data[0]['Mã sản phẩm']}}</th>
        <th>{{$data[0]['Giá bán sản phẩm']}}</th>
        <th>{{$data[0]['Hình ảnh']}}</th>
        <th>{{$data[0]['URL trang']}}</th>
        <th>{{$data[0]['Trang hiển thị']}}</th>
        <th>{{$data[0]['Trạng thái']}}</th>
        <th>{{$data[0]['Thứ tự']}}</th>
        <th>{{$data[0]['Lượt xem']}}</th>
        <th></th>
    </thead>
    <tfoot>
        <th><input type="checkbox" onclick="togglecheckboxes(this)" /></th>
        <th>{{$data[0]['Tiêu đề']}}</th>
        <th>{{$data[0]['Mã sản phẩm']}}</th>
        <th>{{$data[0]['Giá bán sản phẩm']}}</th>
        <th>{{$data[0]['Hình ảnh']}}</th>
        <th>{{$data[0]['URL trang']}}</th>
        <th>{{$data[0]['Trang hiển thị']}}</th>
        <th>{{$data[0]['Trạng thái']}}</th>
        <th>{{$data[0]['Thứ tự']}}</th>
        <th>{{$data[0]['Lượt xem']}}</th>
        <th></th>
    </tfoot>
    <tbody id="ListProduct">
        <?php $i=1;foreach ($data[1] as $v) { ?>
        <tr>
            <td><input type="checkbox" class="CheckAll" rel="<?= $v->idpage ?>" /></td>
            <td><a href="/admin/product/list/edit/<?= $v->idpage ?>"><?= $v->namepage ?></a></td>
            <td><input class="form-control" type="text" value="{{$v->code}}" onblur="UpdateDataProduct($(this).val(),{{$v->idpage}},1)" /></td>
            <td><input class="form-control" type="number" value="{{$v->price}}" onblur="UpdateDataProduct($(this).val(),{{$v->idpage}},2)" /></td>
            <td><?= '<img src="'.\App\Common\ReturnImage::Image($v->avatar).'" alt="'.$v->namepage.'" style="width:50px;" />' ?></td>
            <td><a target="_blink" href="{{lang.'/'.$v->url}}">{{lang.'/'.$v->url}}</a></td>
            <td><a target="_blink" href="/admin/design/page/{{$v->id}}">{{$v->name}}</a></td>
            <td><input type="checkbox" <?= ($v->status==1?'checked="checked"':'')?> onclick="UpdateDataProduct(this.checked?1:0,{{$v->idpage}},3)" /></td>
            <td><input class="form-control" type="number" value="{{$v->order}}" onblur="UpdateDataProduct($(this).val(),{{$v->idpage}},4)" /></td>
            <td>{{$v->views}}</td>
            <td>
                <a href="/admin/product/list/edit/<?= $v->idpage ?>">{{$data[0]['Nút Sửa Danh sách']}}</a>
                <a onclick="return window.confirm('{{$data[0]['Xác nhận Xóa Danh sách sản phẩm']}}')" href="/admin/product/list/delete/<?= $v->idpage ?>">{{$data[0]['Nút Xóa danh dách']}}</a>
            </td>
        </tr>
        <?php $i++; } ?>
    </tbody>
</table>
@stop()
@section ('footer')
<!--
<style>
.fancybox-skin,.box.box-primary {
    min-height: 300px;
}
</style> 

<div style="display:none;" class="col-sm-6"><div id="fancybox" style="position:relative;">
<div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Thiết lập các trường hiển thị</h3>
        </div>
        <div class="box-body">
            <
<div class="input-group" id="InfoProduct">
    <select style="width:50%;" type="text" name="AddFields" class="form-control">
        <?php 
        $phancach = array(
            'Tiêu đề','Mã sản phẩm','Danh mục cha','Hình ảnh','Địa điểm mua hàng','Thông tin bảo hành',
            'Mô tả','Chi tiết','Thứ tự','Sản phẩm liên quan','Tin tức liên quan','Trang Bộ lọc sản phẩm',
            'Giá gốc','Giá thị trường','Giá khuyến mại','Thời gian khuyến mại','Thời gian khuyến mại',
            'Giá giờ vàng','Giờ bắt đầu','Giờ kết thúc','Tiêu đề Giá tùy chọn','Quản lý kho hàng','Trang Nhà sản xuất',
            'Đơn vị tính số lượng','Chọn Kiểm soát số lượng','Số lượng đang bán','Danh sách hình ảnh','Danh sách video',
            'Danh sách thông số','Tiêu đề Tab 1','URL trang','Trang hiển thị','Thẻ title','Thẻ description','Thẻ keyword','Tags');
        for ($i = 0; $i < count($phancach); $i++) { ?>
        <option value="{{$i}}">{{$data[0][$phancach[$i]]}}</option>
        <?php } ?>
    </select>
    <input style="width:50%;" type="text" name="AddTitle" placeholder="{{$data[0]['Tiêu đề']}}" class="form-control" />
    <span class="input-group-addon" style="padding:0px;"><button type="button" onclick="AddFieldsProduct()" style="border:0px;" class="form-control"><i class="fa fa-fw fa-plus"></i></button></span>
</div>
<button type="button" onclick="ConfirmExport()" style="border:0px;" class="form-control"><i class="fa fa-fw fa-plus"></i></button>            
        </div>
</div>
        
</div></div>-->


<script>
    function AddFieldsProduct(){
        var field, value;
        field = $('[name="AddFields"]').val(); $('[name="AddFields"]').val(0);
        value = $('[name="AddTitle"]').val(); $('[name="AddTitle"]').val('');
        $content = '<div class="input-group"><input type="hidden" name="AddIDReport[]" value="'+field+'" /><input type="hidden" name="AddTitleReport[]" value="'+value+'" /><span class="form-control">'+value+'</span><span class="input-group-addon" style="padding:0px;"><button type="button" onclick="DeleteFieldsProduct($(this))" style="border:0px;" class="form-control"><i class="fa fa-fw fa-plus"></i></button></span></div>';    
        $('#InfoProduct').after($content);
    }
    
function UpdateDataProduct(val,id, code){
    $.get('/admin/product/list/updatedataproduct',{id:id, val:val, code:code}, function(o){
        $('.box-msg').html(o); InfoMessage();
    });
}
/*function confirmConfirmExport(){
    count = $('[name="PageCount"]').val();
    item = $('[name="PageItem"]').val();
    key = $('[name="PageKey"]').val();
    category = $('[name="PageCategory"]').val();
    order = $('[name="PageOrder"]').val();
}*/
function LoadListProductFind(){
    $('.box-msg').html('<p class="alert alert-warning" role="alert">{{$data[0]['Đang tải dữ liệu']}}</p>'); 
    var count, item, key, category, order;
    count = $('[name="PageCount"]').val();
    item = $('[name="PageItem"]').val();
    key = $('[name="PageKey"]').val();
    category = $('[name="PageCategory"]').val();
    order = $('[name="PageOrder"]').val();
    $.getJSON('/admin/product/list/updatelist', {count:count, item:item, key:key, category:category, order:order}, function(o){
        $('[name="PageItem"]').html(o.pagecount); 
        $('#ListProduct').html(o.content); InfoMessage();
    });
}
$("a#fancyBoxLink").fancybox({
    'href'   : '#fancybox',
    'titleShow'  : false,
    'transitionIn'  : 'elastic',
    'transitionOut' : 'elastic'
});


    
function DeleteFieldsProduct(pt){        
    pt.parent('span').parent('div').remove();
}
function AddFileImport(){
    $('.box-msg').html('<p class="alert alert-warning" role="alert">{{$data[0]['Đang tải dữ liệu']}}</p>'); 
    var finder = new CKFinder();
    finder.basePath = '/';
    finder.selectActionFunction = function(url){
        $.get('/admin/product/list/importExcel',{url:url},function(o){
            $('.box-msg').html('<p class="alert alert-warning" role="alert">'+o+'</p>'); 
        })
    };
    finder.popup();
}
</script>


@stop()