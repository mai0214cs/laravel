@extends('masteradmin')
@section ('tagtitle')
{{$data[0]['Trang Thêm Danh mục sản phẩm']}}
@stop()
@section ('title')
{{$data[0]['Trang Thêm Danh mục sản phẩm']}}
@stop()
@section ('breadcumb')
    <li><a href="/admin">{{$data[0]['Sản phẩm']}}</a></li>
    <li><a href="/admin/product/category">{{$data[0]['Trang Danh mục sản phẩm']}}</a></li>
    <li class="active">{{$data[0]['Trang Thêm Danh mục sản phẩm']}}</li>
@stop()

@section ('content')
<p class="login-box-msg">
    <?php echo Session::get('message').'<br/>'; ?>
</p>
<form class="form-horizontal" action="{{action('ProductCategoryController@confirmadd')}}" method="post">
<div class="box box-info">
<!-- form start -->
<div class="row"><div class="col-sm-12">
    <div class="box-header with-border"><h3 class="box-title">{{$data[0]['Thông tin chung']}}</h3></div>
    <div class="box-body">
        <div class="form-group">
          <label class="col-sm-2 control-label">{{$data[0]['Tiêu đề']}}</label>
          <input type="hidden" name="_token" value="{{csrf_token()}}" />
          <div class="col-sm-10"><input type="text" class="form-control" name="title" /><p class="login-box-msg">{{$errors->first('title')}}</p></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">{{$data[0]['Danh mục cha']}} (*)</label>
          <div class="col-sm-10">
              <select class="form-control" name="parentid">
                <option value="0">{{$data[0]['Select Không lựa chọn']}}</option>
                <?php foreach ($data[1] as $v) {echo '<option value="'.$v->idpage.'">'.$v->namepage.'</option>';} ?>
              </select>
              <p class="login-box-msg">{{$errors->first('parentid')}}</p>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">{{$data[0]['Hình ảnh']}}</label>
          <div class="col-sm-10">
              <div class="uploadhinhanhavatar"></div>
              <input type="hidden" class="form-control" name="avatar" />
              <input type="button" onclick="BrowseServer('avatar');" value="Browse Server"/>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">{{$data[0]['Mô tả']}}</label>
          <div class="col-sm-10"><input type="text" class="form-control" name="description" /></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">{{$data[0]['Thứ tự']}}</label>
          <div class="col-sm-10"><input type="text" class="form-control" name="order" value="0" /><p class="login-box-msg">{{$errors->first('order')}}</p></div>
        </div>
    </div>
</div></div>  
<div class="row"><div class="col-sm-12">
    <div class="box-header with-border"><h3 class="box-title">{{$data[0]['Thông tin SEO']}}</h3></div>
    <div class="box-body">
        <div class="form-group">
          <label class="col-sm-2 control-label">{{$data[0]['URL trang']}}</label>
          <div class="col-sm-10"><input type="text" class="form-control" name="url" /></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">{{$data[0]['Thẻ title']}}</label>
          <div class="col-sm-10"><input type="text" class="form-control" name="tagstitle" /></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">{{$data[0]['Thẻ description']}}</label>
          <div class="col-sm-10"><input type="text" class="form-control" name="metadescription" /></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">{{$data[0]['Thẻ keyword']}}</label>
          <div class="col-sm-10"><input type="text" class="form-control" name="metakeyword" /></div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">{{$data[0]['Trang hiển thị']}} 
                <a href="/admin/design/page">(<i class="fa fa-fw fa-plus"></i></a> <i class="fa fa-fw fa-refresh"></i>)</label>
          <div class="col-sm-10">
              <select class="form-control" name="idvpage">
              <?php
              foreach ($data[2] as $v) {
                  echo '<option value="'.$v->id.'">'.$v->name.'</option>';
              }
              ?>
              </select>
              <p class="login-box-msg">{{$errors->first('idvpage')}}</p>
          </div>
        </div>
        
    </div>
</div></div>
<div class="row"><div class="col-sm-12">
        <input type="submit" value="{{$data[0]['Button Xác nhận thêm']}}" />
</div></div>
    
</form>
@stop()
@section ('footer')
<script>
CKEDITOR.replace('description');    
</script>
@stop()