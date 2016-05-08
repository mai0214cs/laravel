@extends('masteradmin')
@section ('tagtitle')
{{$data[0]['Trang Bình luận tin tức']}}
@stop()
@section ('title')
{{$data[0]['Trang Bình luận tin tức']}}
@stop()
@section ('breadcumb')
    <li><a href="/admin">{{$data[0]['Giao diện']}}</a></li>
    <li class="active">{{$data[0]['Trang Bình luận tin tức']}}</li>
@stop()

@section ('content')
<div class="box-header with-border">
    
</div>
<table class="table table-bordered table-hover">
    <thead>
        <th>{{$data[0]['#']}}</th>
        <th>{{$data[0]['Họ và tên']}}</th>
        <th>{{$data[0]['Email']}}</th>
        <th>{{$data[0]['Điểm']}}</th>
        <th>{{$data[0]['Bài viết']}}</th>
        <th>{{$data[0]['Ngày đăng']}}</th>
        <th>{{$data[0]['Trạng thái']}}</th>
        <th></th>
    </thead>
    <tfoot>
        <th>{{$data[0]['#']}}</th>
        <th>{{$data[0]['Họ và tên']}}</th>
        <th>{{$data[0]['Email']}}</th>
        <th>{{$data[0]['Điểm']}}</th>
        <th>{{$data[0]['Bài viết']}}</th>
        <th>{{$data[0]['Ngày đăng']}}</th>
        <th>{{$data[0]['Trạng thái']}}</th>
        <th></th>
    </tfoot>
    <tbody>
        <?php $i=1;foreach ($list as $v) { ?>
        <tr>
            <td>{{$i}}</td>
            <td>{{$v->namepage}}</td>
            <td><a href="mailto:{{$v->email}}">{{$v->email}}</a></td>
            <td>{{$v->mark}}/5</td>
            <td><a href="{{lang.'/'.$v->url}}">{{$v->name}}</a><input type="hidden" name="idnews" /></td>
            <td>{{$v->date}}</td>
            <td><input type="checkbox" <?= $v->status?'checked':''?>  /></td>
            <td>
                <a href="javascript:;" onclick="CommentReply({{$v->idpage}},$(this))">Phản hồi</a>
                <a href="javascript:;" onclick="CommentEdit({{$v->idpage}},$(this))">Sửa</a>
            </th>
        </tr>
        <?php $i++; } ?>
    </tbody>
</table>
@stop()
@section ('footer')
<div>
    <div id="fancybox">
        <div class="box box-primary">
            <div class="box-header with-border"><h3 class="box-title">{{$data[0]['Trang Bình luận tin tức']}}</h3></div>
            <div class="box-body">
                <div class="form-group">
                    <label>{{$data[0]['Họ và tên']}}</label>
                    <input type="text" class="form-control" name="comment_name" />
                </div>
                <div class="form-group">
                    <label>{{$data[0]['Email']}}</label>
                    <input type="text" class="form-control" name="comment_email" />
                </div>
                <div class="form-group">
                    <label>{{$data[0]['Điểm']}}</label>
                    <select name="comment_mark" class="form-control" placeholder="Điểm đánh giá">
                        <option value="5">Tốt nhất</option>
                        <option value="4">Rất hay</option>
                        <option value="3">Hay</option>
                        <option value="2">Trung bình</option>
                        <option value="1">Kém</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>{{$data[0]['Tiêu đề']}}</label>
                    <input type="text" class="form-control" name="comment_title" />
                </div>
                <div class="form-group">
                    <label>{{$data[0]['Nội dung']}}</label>
                    <textarea class="form-control" name="comment_content"></textarea>
                </div>
                <input type="hidden" value="" name="idpagecomment" />
                <input type="hidden" value="" name="idpagepage" />
                <input type="hidden" value="0" name="idupdate" />
            </div>
            <div class="box-footer">
                <button type="button" class="btn btn-info pull-right" onclick="SendComment()">Gửi bình luận</button>
            </div>
        </div>
    </div>
</div>
<script>
function CommentReply(id,pt){
    $('[name="idpagecomment"]').val(id);
    //$('[name="idupdate"]').val(id);
}

function SendComment(){
    var idcomment, idpage, name, email, mark, title, content, idupdate;
    idcomment = $('[name="idpagecomment"]').val();
    idpage = $('[name="idpagepage"]').val();
    idupdate = $('[name="idupdate"]').val();
    name = $('[name="comment_name"]').val();
    email = $('[name="comment_email"]').val();
    mark = $('[name="comment_mark"]').val();
    title = $('[name="comment_title"]').val();
    content = $('[name="comment_content"]').val();
    $.getJSON('/admin/customer/commentnewsedit',{idupdate:idupdate,idcomment:idcomment, idpage:idpage, name:name, email:email, mark:mark, title:title, content:content}, function($result){
        
    });
}
</script>
@stop()