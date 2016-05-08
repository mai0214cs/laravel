@extends('masteradmin')
@section ('tagtitle')
{{$data[0]['Trang Danh sách tin tức']}}
@stop()
@section ('title')
{{$data[0]['Trang Danh sách tin tức']}}
@stop()
@section ('breadcumb')
    <li><a href="#">{{$data[0]['Tin tức']}}</a></li>
    <li class="active">{{$data[0]['Trang Danh sách tin tức']}}</li>
@stop()

@section ('content')
<div class="box-header with-border">
    <a href="/admin/news/list/add" style="margin-right: 10px;" class="btn btn-info pull-left"><i class="fa fa-fw fa-plus"></i> {{$data[0]['Nút Thêm mới Danh sách']}}</a>
    <a style="margin-right: 10px;" onclick="XoaCheckAll('/admin/news/list/deleteAll', '{{$data[0]['Thông báo xác nhận xóa']}}')" class="btn btn-default pull-left">{{$data[0]['Nút Xóa tất cả mục chọn']}}</a>
    <a href="/admin/news/list/ExportExcel" style="margin-right: 10px;" class="btn btn-info pull-left"><i class="fa fa-fw fa-cloud-download"></i> {{$data[0]['Xuất Excel']}}</a>
    <button type="button" onclick="AddFileImport()" style="margin-right: 10px;" class="btn bg-green pull-left"><i class="fa fa-fw fa-cloud-upload"></i> {{$data[0]['Nhập Excel']}}</button>
</div>
<div class="box-header with-border">
    <div class="col-sm-3">
        <div style="width: 50%; float: left;">
            <div class="form-group">
              <label>Số lượng</label>
              <input type="number" min="10" max="300" value="20" class="form-control" name="PageCount" onblur="LoadListNewsFind()" />
            </div>
        </div>
        <div style="width: 50%; float: left;">
            <div class="form-group">
              <label>Chọn trang</label>
              <select onchange="LoadListNewsFind()" style="width: 100%;" name="PageItem" class="form-control">
                  <option value="1">Trang 1</option>
              </select>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
            <div class="form-group">
              <label>Tiêu đề</label>
              <input style="width: 100%;" type="text" class="form-control" name="PageKey" value="" onblur="LoadListNewsFind()" />
            </div>
    </div>
    <div class="col-sm-3">
            <div class="form-group">
              <label>Danh mục</label>
              <select style="width: 100%;" name="PageCategory" class="form-control" onchange="LoadListNewsFind()">
                  <option value="0">Tất cả danh mục</option>
                  <?php foreach ($data[2] as $v) { ?>
                  <option value="{{$v->idpage}}">{{$v->namepage}}</option>
                  <?php } ?>
              </select>
            </div>
    </div>
    <div class="col-sm-3">
            <div class="form-group">
              <label>Sắp xếp</label>
              <select name="PageOrder" class="form-control" onchange="LoadListNewsFind()">
                  <option selected="true" value="0">Tin tức mới</option>
                  <option value="1">Tin tức cũ</option>
                  <option value="2">Tiêu đề A-Z</option>
                  <option value="3">Tiêu đề Z-A</option>
                  <option value="4">Tin tức xem nhiều</option>
              </select>
            </div>
    </div>
</div>
<table class="table table-bordered table-hover">
    <thead>
        <th><input type="checkbox" onclick="togglecheckboxes(this)" /></th>
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
        <th><input type="checkbox" onclick="togglecheckboxes(this)" /></th>
        <th>{{$data[0]['Tiêu đề']}}</th>
        <th>{{$data[0]['Hình ảnh']}}</th>
        <th>{{$data[0]['URL trang']}}</th>
        <th>{{$data[0]['Trang hiển thị']}}</th>
        <th>{{$data[0]['Trạng thái']}}</th>
        <th>{{$data[0]['Thứ tự']}}</th>
        <th>{{$data[0]['Lượt xem']}}</th>
        <th></th>
    </tfoot>
    <tbody id="ListNews">
        <?php $i=1;foreach ($data[1] as $v) { ?>
        <tr>
            <td><input type="checkbox" class="CheckAll" rel="<?= $v->idpage ?>" /></td>
            <td><a href="/admin/news/list/edit/<?= $v->idpage ?>"><?= $v->namepage ?></a></td>
            <td><?= '<img src="'.\App\Common\ReturnImage::Image($v->avatar).'" alt="'.$v->namepage.'" style="width:50px;" />' ?></td>
            <td><a target="_blink" href="{{lang.'/'.$v->url}}">{{lang.'/'.$v->url}}</a></td>
            <td><a target="_blink" href="/admin/design/page/{{$v->id}}">{{$v->name}}</a></td>
            <td><input type="checkbox" <?= ($v->status==1?'checked="checked"':'')?> onclick="CheckStatus('/admin/news/list/checkstatus',this.checked?1:0,{{$v->idpage}})" /></td>
            <td><input class="form-control" type="number" value="{{$v->order}}" onblur="CheckStatus('/admin/news/list/changeorder',this.value,{{$v->idpage}})" /></td>
            <td>{{$v->views}}</td>
            <td>
                <a href="/admin/news/list/edit/<?= $v->idpage ?>">{{$data[0]['Nút Sửa Danh sách']}}</a>
                <a onclick="return window.confirm('{{$data[0]['Xác nhận Xóa Danh sách tin tức']}}')" href="/admin/news/list/delete/<?= $v->idpage ?>">{{$data[0]['Nút Xóa danh dách']}}</a>
            </td>
        </tr>
        <?php $i++; } ?>
    </tbody>
</table>
@stop()
@section ('footer')
<script>
function LoadListNewsFind(){
    var count, item, key, category, order;
    count = $('[name="PageCount"]').val();
    item = $('[name="PageItem"]').val();
    key = $('[name="PageKey"]').val();
    category = $('[name="PageCategory"]').val();
    order = $('[name="PageOrder"]').val();
    //alert(12);
    $.getJSON('/admin/news/list/updatelist', {count:count, item:item, key:key, category:category, order:order}, function(o){
        $('[name="PageItem"]').html(o.pagecount); 
        $('#ListNews').html(o.content);
    });
}
function AddFileImport(){
    $('.box-msg').html('<p class="alert alert-warning" role="alert">{{$data[0]['Đang tải dữ liệu']}}</p>'); 
    var finder = new CKFinder();
    finder.basePath = '/';
    finder.selectActionFunction = function(url){
        $.get('/admin/news/list/ImportExcel',{url:url},function(o){
            $('.box-msg').html('<p class="alert alert-warning" role="alert">'+o+'</p>'); 
        })
    };
    finder.popup();
}
</script>
@stop()