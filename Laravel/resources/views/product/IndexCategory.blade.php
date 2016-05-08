@extends('masteradmin')
@section ('tagtitle')
{{$data[0]['Trang Danh mục sản phẩm']}}
@stop()
@section ('title')
{{$data[0]['Trang Danh mục sản phẩm']}}
@stop()
@section ('breadcumb')
    <li><a href="#">{{$data[0]['Sản phẩm']}}</a></li>
    <li class="active">{{$data[0]['Trang Danh mục sản phẩm']}}</li>
@stop()

@section ('content')
<div class="box-header with-border">
    <a class="btn btn-info" href="/admin/product/category/add">{{$data[0]['Nút Thêm mới Danh sách']}}</a>
</div>

<table class="table table-bordered table-hover">
    <thead>
        <th>{{$data[0]['#']}}</th>
        <th>{{$data[0]['Tiêu đề']}}</th>
        <th>{{$data[0]['Hình ảnh']}}</th>
        <th>{{$data[0]['URL trang']}}</th>
        <th>{{$data[0]['Trang hiển thị']}}</th>
        <th>{{$data[0]['Trạng thái']}}</th>
        <th>{{$data[0]['Thứ tự']}}</th>
        <th>{{$data[0]['Lượt xem']}}</th>
        <th></th>
    </thead>
    <tfoot>
        <th>#</th>
        <th>{{$data[0]['Tiêu đề']}}</th>
        <th>{{$data[0]['Hình ảnh']}}</th>
        <th>{{$data[0]['URL trang']}}</th>
        <th>{{$data[0]['Trang hiển thị']}}</th>
        <th>{{$data[0]['Trạng thái']}}</th>
        <th>{{$data[0]['Thứ tự']}}</th>
        <th>{{$data[0]['Lượt xem']}}</th>
        <th></th>
    </tfoot>
    <tbody>
        <?php $i=1;foreach ($data[1] as $v) { ?>
        <tr>
            <td><?= $i ?></td>
            <td><a href="/admin/product/category/edit/<?= $v->idpage ?>"><?= $v->namepage ?></a></td>
            <td><?= '<img src="'.$v->avatar.'" alt="'.$v->namepage.'" style="width:50px;" />' ?></td>
            <td><a target="_blink" href="/{{(lang==''?'':lang.'/').$v->url}}">{{lang.'/'.$v->url}}</a></td>
            <td><a target="_blink" href="/admin/design/page/{{$v->id}}">{{$v->name}}</a></td>
            <td><input type="checkbox" <?= ($v->status==1?'checked="checked"':'')?> onclick="CheckStatus('/admin/product/category/checkstatus',(this.checked)?1:0,{{$v->idpage}})" /></td>
            <td><input class="form-control" type="number" value="{{$v->order}}" onblur="CheckStatus('/admin/product/category/changeorder',$(this).val(),{{$v->idpage}})" /></td>
            <td>{{$v->views}}</td>
            <td>
                <a href="/admin/product/category/edit/<?= $v->idpage ?>">{{$data[0]['Nút Sửa Danh sách']}}</a>
                <a onclick="$('[name=ItemDelete]').val({{$v->idpage}})" id="fancyBoxLink" href="#fancybox">{{$data[0]['Nút Xóa danh sách']}}</a>
                <!--<a onclick="return window.confirm('{{$data[0]['Xác nhận Xóa Danh mục sản phẩm']}}')" href="/admin/product/category/delete/<?= $v->idpage ?>">{{$data[0]['Nút Xóa danh dách']}}</a>-->
            </td>
        </tr>
        <?php $i++; } ?>
    </tbody>
</table>
@stop()
@section ('footer')
<style>
.fancybox-wrap.fancybox-desktop.fancybox-type-inline.fancybox-opened {
    background: #fff; z-index: 100000000;
    box-shadow: 0px 0px 3px; min-height: 250px;
}
.fancybox-overlay.fancybox-overlay-fixed,.fancybox-skin,.fancybox-outer,.fancybox-inner {
    min-height: 250px;
}
</style>


<div style="display:none;"><div id="fancybox">
    <div class="box box-primary">
    <div class="box-header with-border"><h3 class="box-title">{{$data[0]['Chọn danh mục chuyển sản phẩm sang']}}</h3></div>
    <div class="box-body">
        <div class="form-group">
            <input type="hidden" value="" name="ItemDelete" />
            <select class="form-control" name="selectlistcategory">    
                <option value="0">{{$data[0]['Select Xóa tất cả']}}</option>
                <?php $i=1;foreach ($data[1] as $v) { ?>
                <option value="{{$v->idpage}}">{{$v->namepage}}</option>    
                <?php } ?>
            </select>
        </div>  
    </div>
    <div class="box-footer">
        <a onclick="ConfirmDeleteListProduct()" class="btn btn-success">{{$data[0]['Button Xác nhận gửi Form']}}</a>
    </div>
    </div>
</div></div>
<script>
$("a#fancyBoxLink").fancybox({
    'href'   : '#fancybox',
    'titleShow'  : false,
    'transitionIn'  : 'elastic',
    'transitionOut' : 'elastic'
});

function ConfirmDeleteListProduct(){
    var id, iddirect;
    id = $('[name="ItemDelete"]').val();
    iddirect = $('[name="selectlistcategory"]').val();
    $.get('/admin/product/category/delete/',{id:id, iddirect:iddirect}, function(){DirectPage();});
}
</script>




@stop()