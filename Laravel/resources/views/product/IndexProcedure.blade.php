@extends('masteradmin')
@section ('tagtitle')
{{$data[0]['Trang Nhà sản xuất']}}
@stop()
@section ('title')
{{$data[0]['Trang Nhà sản xuất']}}
@stop()
@section ('breadcumb')
    <li><a href="#">{{$data[0]['Sản phẩm']}}</a></li>
    <li class="active">{{$data[0]['Trang Nhà sản xuất']}}</li>
@stop()

@section ('content')
<a href="/admin/product/procedure/add">{{$data[0]['Nút Thêm mới Danh sách']}}</a>
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
            <td><a href="/admin/product/procedure/edit/<?= $v->idpage ?>"><?= $v->namepage ?></a></td>
            <td><?= '<img src="'.$v->avatar.'" alt="'.$v->namepage.'" style="width:50px;" />' ?></td>
            <td><a target="_blink" href="/{{lang.'/'.$v->url}}">{{lang.'/'.$v->url}}</a></td>
            <td><a href="URL Trang page/{{$v->id}}">{{$v->name}}</a></td>
            <td><input type="checkbox" <?= ($v->status==1?'checked="checked"':'')?> onclick="CheckStatus('/admin/product/procedure/checkstatus',this.checked,{{$v->idpage}})" /></td>
            <td><input type="number" value="{{$v->order}}" onblur="CheckStatus('/admin/product/procedure/changeorder',this.value,{{$v->idpage}})" /></td>
            <td>{{$v->views}}</td>
            <td>
                <a href="/admin/product/procedure/edit/<?= $v->idpage ?>">{{$data[0]['Nút Sửa Danh sách']}}</a>
                <a onclick="return window.confirm('{{$data[0]['Xác nhận Xóa Nhà sản xuất']}}')" href="/admin/product/procedure/delete/<?= $v->idpage ?>">{{$data[0]['Nút Xóa danh dách']}}</a>
            </td>
        </tr>
        <?php $i++; } ?>
    </tbody>
</table>
@stop()
@section ('footer')
@stop()