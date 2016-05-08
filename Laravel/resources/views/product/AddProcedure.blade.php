@extends('masteradmin')
@section ('tagtitle')
{{$data[0]['Trang Thêm Nhà sản xuất']}}
@stop()
@section ('title')
{{$data[0]['Trang Thêm Nhà sản xuất']}}
@stop()
@section ('breadcumb')
    <li><a href="/admin">{{$data[0]['Sản phẩm']}}</a></li>
    <li><a href="/admin/product/procedure">{{$data[0]['Trang Nhà sản xuất']}}</a></li>
    <li class="active">{{$data[0]['Trang Thêm Nhà sản xuất']}}</li>
@stop()

@section ('content')
<form class="form-horizontal" action="{{action('ProductProcedureController@confirmadd')}}" method="post">
<div class="box box-info">
<!-- form start -->
<div class="row"><div class="col-sm-12">
    <div class="box-header with-border"><h3 class="box-title">{{$data[0]['Thông tin chung']}}</h3></div>
    <div class="box-body">
        <div class="form-group">
          <label class="col-sm-2 control-label">{{$data[0]['Tiêu đề']}}</label>
          <input type="hidden" name="_token" value="{{csrf_token()}}" />
          <div class="col-sm-10"><input type="text" class="form-control" name="title" /><p>{{$errors->first('title')}}</p></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">{{$data[0]['Địa chỉ']}}</label>
          <div class="col-sm-10"><input type="text" class="form-control" name="address" /></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">{{$data[0]['Điện thoại']}}</label>
          <div class="col-sm-10"><input type="text" class="form-control" name="phone" /></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">{{$data[0]['Thư điện tử']}}</label>
          <div class="col-sm-10"><input type="text" class="form-control" name="email" /><p>{{$errors->first('email')}}</p></div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">{{$data[0]['Hình ảnh']}}</label>
          <div class="uploadhinhanhavatar"></div>
          <div class="col-sm-10"><input type="hidden" class="form-control" name="avatar" /><input type="button" onclick="BrowseServer('avatar');" value="Browse Server"/></div>
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
          <label class="col-sm-2 control-label">{{$data[0]['Trang hiển thị']}} (*)</label>
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
<script>
CKEDITOR.replace('description');    
</script>
@stop()