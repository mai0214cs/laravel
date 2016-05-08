@extends('masteradmin')
@section ('tagtitle')
{{$data[0]['Trang Sửa Danh sách tin tức']}}
@stop()
@section ('title')
{{$data[0]['Trang Sửa Danh sách tin tức']}}
@stop()
@section ('breadcumb')
    <li><a href="/admin">{{$data[0]['Tin tức']}}</a></li>
    <li><a href="/admin/news/category">{{$data[0]['Trang Danh sách tin tức']}}</a></li>
    <li class="active">{{$data[0]['Trang Sửa Danh sách tin tức']}}</li>
@stop()

@section ('content')
<form class="form-horizontal" action="{{action('NewsListController@confirmedit')}}" method="post">
<div class="box box-info">
<!-- form start -->
<div class="row"><div class="col-sm-12">
    <div class="box-header with-border">
        <h3 class="box-title">{{$data[0]['Thông tin chung']}}</h3>
        <a href="/admin/news/list" class="btn btn-default pull-right">{{$data[0]['Nút quay lại']}}</a>
        <a href="/admin/news/list/add" style="margin-right: 10px;" class="btn btn-default pull-right">{{$data[0]['Nút Thêm mới Danh sách']}}</a>
        <button type="submit" style="margin-right: 10px;" class="btn btn-info pull-right">{{$data[0]['Button Xác nhận chỉnh sửa']}}</button>
    </div>
    <div class="box-body">
        <div class="form-group">
          <label class="col-sm-2 control-label">{{$data[0]['Tiêu đề']}}</label>
          <input type="hidden" name="_token" value="{{csrf_token()}}" />
          <input type="hidden" value="{{$data[3]->id}}" name="id" />
          <div class="col-sm-10"><input type="text" class="form-control" name="title" value="{{$data[3]->name}}" /><p class="login-box-msg">{{$errors->first('title')}}</p></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">{{$data[0]['Danh mục cha']}} <a href="/admin/news/category" target="_blink">(*)</a></label>
          <div class="col-sm-10">
              <select class="form-control" name="parentid">
                <?php foreach ($data[1] as $v) {
                    echo '<option '.($data[3]->id_category==$v->idpage?'selected="selected"':'').' value="'.$v->idpage.'">'.$v->namepage.'</option>';
                } ?>
              </select>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">{{$data[0]['Hình ảnh']}}</label>
          <div class="col-sm-10">
              <input type="hidden" class="form-control" name="avatar" value="{{$data[3]->avatar}}"/>
              <div class="uploadhinhanhavatar"><img src="{{$data[3]->avatar}}" alt="" style="width:100px;" /></div>
              <input type="button" onclick="BrowseServer('avatar');" value="{{$data[0]['Button Chọn hình ảnh']}}"/>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">{{$data[0]['Mô tả']}}</label>
          <div class="col-sm-10"><textarea class="form-control" name="description">{{$data[3]->description}}</textarea></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">{{$data[0]['Chi tiết']}}</label>
          <div class="col-sm-10"><textarea name="detail">{{$data[3]->detail}}</textarea></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">{{$data[0]['Thứ tự']}}</label>
          <div class="col-sm-10"><input type="text" class="form-control" name="order" value="{{$data[3]->order}}" /></div>
        </div>
    </div>
</div></div>  
<div class="row"><div class="col-sm-12">
    <div class="box-header with-border"><h3 class="box-title">{{$data[0]['Thông tin SEO']}}</h3></div>
    <div class="box-body">
        <div class="form-group">
          <label class="col-sm-2 control-label">{{$data[0]['URL trang']}}</label>
          <div class="col-sm-10"><input type="text" class="form-control" name="url" value="{{$data[3]->url}}" /></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">{{$data[0]['Thẻ title']}}</label>
          <div class="col-sm-10"><input type="text" class="form-control" name="tagstitle" value="{{$data[3]->seo_title}}" /></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">{{$data[0]['Thẻ description']}}</label>
          <div class="col-sm-10"><input type="text" class="form-control" name="metadescription" value="{{$data[3]->seo_description}}" /></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">{{$data[0]['Thẻ keyword']}}</label>
          <div class="col-sm-10"><input type="text" class="form-control" name="metakeyword" value="{{$data[3]->seo_keyword}}" /></div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">{{$data[0]['Tags']}} <a href="/admin/news/tags" target="_blink">(*)</a></label>
            <div class="col-sm-10"><select class="form-control select2" multiple="multiple" data-placeholder="" name="tags[]" style="width: 100%;">
                <?php  foreach ($data[4] as $v) {echo '<option '.(in_array($v->id, $data[5])?'selected="selected"':'').' value="'.$v->id.'">'.$v->{lang.'name'}.'</option>';} ?>
            </select></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">{{$data[0]['Trang hiển thị']}} (*)</label>
          <div class="col-sm-10">
              <select class="form-control" name="idvpage">
              <?php
              foreach ($data[2] as $v) {
                  echo '<option '.($data[3]->id_vpage==$v->id?'selected="selected"':'').' value="'.$v->id.'">'.$v->name.'</option>';
              }
              ?>
              </select>
              <p class="login-box-msg">{{$errors->first('idvpage')}}</p>
          </div>
        </div>
        
    </div>
</div></div>
<div class="box-footer">
    <a href="/admin/news/list" class="btn btn-default pull-right">{{$data[0]['Nút quay lại']}}</a>
    <a href="/admin/news/list/add" style="margin-right: 10px;" class="btn btn-default pull-right">{{$data[0]['Nút Thêm mới Danh sách']}}</a>
    <button type="submit" style="margin-right: 10px;" class="btn btn-info pull-right">{{$data[0]['Button Xác nhận chỉnh sửa']}}</button>
</div>
<!--<div class="row">
    <div class="col-sm-6"> 
        <div class="box-header with-border"><h3 class="box-title">Danh mục tin tức liên quan</h3></div>
        <div class="box-body">
            <div class="form-group">
              <label class="col-sm-2 control-label">Thẻ title</label>
              <div class="col-sm-10"><input type="text" class="form-control" name="title" /></div>
            </div>
        </div>
    </div>
    <div class="col-sm-6"> 
        <div class="box-header with-border"><h3 class="box-title">Danh sách tin tức liên quan</h3></div>
        <div class="box-body">
            <div class="form-group">
              <label class="col-sm-2 control-label">Thẻ title</label>
              <div class="col-sm-10"><input type="text" class="form-control" name="title" /></div>
            </div>
        </div>
    </div>
</div>-->
    
</form>
@stop()
@section ('footer')
<link href="/libadmin/plugins/select2/select2.min.css" rel="stylesheet" type="text/css"/>
<script src="/libadmin/plugins/select2/select2.full.min.js" type="text/javascript"></script>
<script>
CKEDITOR.replace('detail');  $('.select2').select2();  
</script>
@stop()