@extends('masteradmin')
@section ('tagtitle')
{{$data[0]['Trang Sửa Sản phẩm']}}
@stop()
@section ('title')
{{$data[0]['Trang Sửa Sản phẩm']}}
@stop()
@section ('breadcumb')
    <li><a href="/admin">{{$data[0]['Sản phẩm']}}</a></li>
    <li><a href="/admin/product/list">{{$data[0]['Trang Danh sách sản phẩm']}}</a></li>
    <li class="active">{{$data[0]['Trang Sửa Sản phẩm']}}</li>
@stop()

@section ('content')
<div class="row"><form role="form" method="post" action="{{action('ProductListController@confirmedit')}}" onsubmit="return AddEditProduct()">
<input type="hidden" name="_token" value="{{csrf_token()}}" />
<input type="hidden" name="idpage" value="{{$pageproduct->id}}" />
<div class="col-sm-6">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{$data[0]['Trang Thêm/ Sửa Giới thiệu chung']}}</h3>
        </div>
        <div class="box-body">
            <div class="form-group">
                <label>{{$data[0]['Tiêu đề']}}</label>
                <input type="text" class="form-control" name="name" value="{{$pageproduct->name}}" />
                @if ($errors->has('name'))<p style="color:red;">{!!$errors->first('name')!!}</p>@endif
            </div>
            <div class="form-group">
                <label>{{$data[0]['Mã sản phẩm']}}</label>
                <input type="text" class="form-control" name="code" value="{{$product->code}}" />
            </div>
            <div class="form-group">
                <label>{{$data[0]['Danh mục cha']}}</label>
                <select type="text" class="form-control" name="category">
                    <?php foreach ($categoryproduct as $v){ ?>
                    <option <?= $pageproduct->id_category==$v->idpage?'selected="selected"':'' ?> value="{{$v->idpage}}">{{$v->namepage}}</option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label>{{$data[0]['Hình ảnh']}}</label>
                <div class="uploadhinhanhavatar">
                    <img src="{{$pageproduct->avatar}}" alt="{{$pageproduct->name}}" style="width:50px;" />
                </div>
                <input type="hidden" class="form-control" name="avatar" />
                <input type="button" onclick="BrowseServer('avatar');" value="Browse Server"/>
            </div>
            <div class="form-group">
                <label>{{$data[0]['Địa điểm mua hàng']}}</label>
                <select multiple="multiple" class="form-control select2" name="location[]" style="width:100%;">
                    <?php $locationx = explode(',', $product->ids_location); foreach ($location as $v) { ?>
                    <option <?= in_array($v->id, $locationx)?'selected="selected"':'' ?> value="{{$v->id}}">{{$v->name}}</option>';
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label>{{$data[0]['Thông tin bảo hành']}}</label>
                <input type="text" class="form-control" name="warranty" value="{{$product->warranty}}" />
            </div>
            <div class="form-group">
                <label>{{$data[0]['Mô tả']}}</label>
                <textarea class="form-control" name="description">{{$pageproduct->description}}</textarea>
            </div>
            <div class="form-group">
                <label>{{$data[0]['Chi tiết']}}</label>
                <textarea name="detail">{{$pageproduct->detail}}</textarea>
            </div>
            <div class="form-group">
                <label>{{$data[0]['Thứ tự']}}</label>
                <input type="text" class="form-control" name="order" value="{{$pageproduct->order}}" />
                @if ($errors->has('order'))<p style="color:red;">{!!$errors->first('order')!!}</p>@endif
            </div>
        </div>
    </div>
    
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{$data[0]['Sản phẩm liên quan']}}</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>{{$data[0]['Danh mục sản phẩm liên quan']}} <a href="/admin/product/category" target="_blink">(*)</a></label>
                        <select style="min-height:300px;" multiple class="form-control" name="categoryproductrelated">
                            <?php foreach ($categoryproduct as $v){ ?>
                            <option ondblclick="SelectCategoryProduct({{$v->idpage}})" value="{{$v->idpage}}">{{$v->namepage}}</option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>{{$data[0]['Sản phẩm thuộc danh mục']}} <a href="/admin/product/list" target="_blink">(*)</a></label>
                        <select style="min-height:300px;" multiple class="form-control" name="listproductrelated"></select>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>{{$data[0]['Danh sách Sản phẩm liên quan']}}</label>
                        <select style="min-height:300px;" multiple class="form-control" name="productrelated[]">
                            <?php foreach ($product_related as $v) { ?>
                            <option ondblclick="DeleteItem($(this))" value="{{$v->id}}">{{$v->name}}</option>
                            <?php } ?>
                        </select>
                        <input type="hidden" value="" name="DataProductRelated" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{$data[0]['Tin tức liên quan']}}</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>{{$data[0]['Danh mục tin tức liên quan']}} <a href="/admin/news/category" target="_blink">(*)</a></label>
                        <select style="min-height:300px;" multiple class="form-control" name="categorynewsrelated">
                            <?php foreach ($categorynews as $v){ ?>
                            <option ondblclick="SelectCategoryNews({{$v->idpage}})" value="{{$v->idpage}}">{{$v->namepage}}</option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>{{$data[0]['Tin tức thuộc danh mục']}} <a href="/admin/news/list" target="_blink">(*)</a></label>
                        <select style="min-height:300px;" multiple class="form-control" name="listnewsrelated"></select>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>{{$data[0]['Danh sách Tin tức liên quan']}}</label>
                        <select style="min-height:300px;" multiple class="form-control" name="newsrelated[]">
                            <?php foreach ($news_related as $v) { ?>
                            <option ondblclick="DeleteItem($(this))" value="{{$v->id}}">{{$v->name}}</option>
                            <?php } ?>
                        </select>
                        <input type="hidden" value="" name="DataNewsRelated" />
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{$data[0]['Trang Bộ lọc sản phẩm']}} <a href="/admin/product/filter" target="_blink">(*)</a></h3>
        </div>
        <div class="box-body">
            <div class="form-group">
                <select style="min-height:300px;" multiple type="text" class="form-control" name="filter_product[]">
                    <?php 
                    $filter = explode(',', $product->ids_attribute);
                    $group = count($group_attribute);
                    for ($i = 0; $i < $group; $i++) {
                        echo '<optgroup label="'.$group_attribute[$i]->name.'">';
                        foreach ($item_attribute[$group_attribute[$i]->id] as $v) {
                            echo '<option '.(in_array($v->id, $filter)?'selected="selected"':'').' value="'.$v->id.'">'.$v->value.'</option>';
                        }
                        echo '</optgroup>';
                    }
                    ?>
                </select>
            </div>
        </div>
    </div>
    
    
</div>
<div class="col-sm-6">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{$data[0]['Thông tin giá bán']}}</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>{{$data[0]['Giá gốc']}}</label>
                        <input type="number" class="form-control" name="cost" value="{{$product->cost}}" />
                        @if ($errors->has('cost'))<p style="color:red;">{!!$errors->first('cost')!!}</p>@endif
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>{{$data[0]['Giá thị trường']}}</label>
                        <input type="number" class="form-control" name="price" value="{{$product->price}}" />
                        @if ($errors->has('price'))<p style="color:red;">{!!$errors->first('price')!!}</p>@endif
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>{{$data[0]['Áp dụng thuế VAT']}}:</label>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="price_vat" />
            </div>
            <hr/>
            
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>{{$data[0]['Giá khuyến mại']}}</label>
                        <input type="number" class="form-control" name="promotion_price" value="0" />
                        @if ($errors->has('promotion_price'))<p style="color:red;">{!!$errors->first('promotion_price')!!}</p>@endif
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>{{$data[0]['Thời gian khuyến mại']}}</label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            <input type="text" class="form-control pull-right" id="reservation" name="promotion_date" />
                        </div>
                    </div>
                </div>
            </div>
            <hr/>
            
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>{{$data[0]['Giá giờ vàng']}}</label>
                        <input type="number" class="form-control" name="goldtime_price" value="0" />
                        @if ($errors->has('goldtime_price'))<p style="color:red;">{!!$errors->first('goldtime_price')!!}</p>@endif
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>{{$data[0]['Giờ bắt đầu']}}</label>
                        <div class="input-group">
                            <input type="text" class="form-control timepicker" name="goldtime_start" />
                            <div class="input-group-addon"><i class="fa fa-clock-o"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>{{$data[0]['Giờ kết thúc']}}</label>
                        <div class="input-group">
                            <input type="text" class="form-control timepicker" name="goldtime_end" />
                            <div class="input-group-addon"><i class="fa fa-clock-o"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <hr/>
            
            <div class="row"><div class="col-sm-12">
                <label>{{$data[0]['Tiêu đề Giá tùy chọn']}}</label>
                <table class="table table-condensed"><tbody>
                    <tr id="OptionProduct">
                        <td><input placeholder="{{$data[0]['Mã giá tùy chọn']}}" type="text" class="form-control" name="PriceOptionsCodeAdd" /></td>
                        <td><input placeholder="{{$data[0]['Tiêu đề giá tùy chọn']}}" type="text" class="form-control" name="PriceOptionsNameAdd" /></td>
                        <td>
                            <button type="button" onclick="AddImageOption()" class="form-control"><i class="fa fa-fw fa-image"></i></button>
                            <input type="hidden" class="form-control" name="AvatarOptionAdd" />
                        </td>
                        <td><input placeholder="{{$data[0]['Giá bán tùy chọn']}}" type="number" class="form-control" name="PriceOptionsPriceAdd" /></td>
                        <td><button type="button" onclick="AddOptionNewProduct()" class="form-control"><i class="fa fa-fw fa-plus"></i></button></td>
                    </tr>
                    <?php 
                    if($product->options_price != ''){
                        $dstab = '<ArrayOfConsignmentTrack xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns="http://tempuri.org/">'.$product->options_price.'</ArrayOfConsignmentTrack>';        
                        $xml4 = simplexml_load_string($dstab); 
                        for ($i = 0; ; $i++) {
                            if(!isset($xml4->item[$i])){break;}
                            $codeoption = isset($xml4->item[$i])?$xml4->item[$i]->code:'';
                            $nameoption = isset($xml4->item[$i])?$xml4->item[$i]->name:'';
                            $priceoption = isset($xml4->item[$i])?$xml4->item[$i]->price:'';
                            $avataroption = \App\Common\ReturnImage::Image(isset($xml4->item[$i])?$xml4->item[$i]->avatar:'');
                            ?>
                            <tr>
                                <td><input type="text" class="form-control" value="{{$codeoption}}" name="PriceOptionsCode[]" /></td>
                                <td><input type="text" class="form-control" value="{{$nameoption}}" name="PriceOptionsName[]" /></td>
                                <td>
                                    <input type="hidden" class="form-control" value="{{$avataroption}}" name="AvatarOption[]" />
                                    <img src="{{$avataroption}}" style="width:35px; height:35px;" alt="fdfdfs" />
                                </td>
                                <td><input placeholder="Giá bán" type="number" value="{{$priceoption}}" class="form-control" name="PriceOptionsPriceAdd[]"></td>
                                <td><button type="button" onclick="DeleteOptionProduct($(this))" class="form-control"><i class="fa fa-fw fa-remove"></i></button></td>
                            </tr>  
                            <?php
                        }
                    }
                    ?>
                </tbody></table>
            </div></div>
        </div>
        
    </div>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{$data[0]['Quản lý kho hàng']}}</h3>
        </div>
        <div class="box-body">
            <div class="form-group">
                <label>{{$data[0]['Trang Nhà sản xuất']}} <a href="/admin/product/procedure" target="_blink">(*)</a></label>
                <select type="text" class="form-control" name="procedure">
                    <?php foreach ($procedureproduct as $v){ ?>
                    <option value="{{$v->id}}">{{$v->name}}</option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label>{{$data[0]['Đơn vị tính số lượng']}}</label>
                <input type="text" class="form-control" name="unit_count" />
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>{{$data[0]['Chọn Kiểm soát số lượng']}}</label>
                        <select type="text" class="form-control" name="check_count">
                            <option value="0">{{$data[0]['Có Kiểm soát số lượng']}}</option>
                            <option value="1">{{$data[0]['Không Kiểm soát số lượng']}}</option>
                        </select>
                        @if ($errors->has('check_count'))<p style="color:red;">{!!$errors->first('check_count')!!}</p>@endif
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>{{$data[0]['Số lượng đang bán']}}</label>
                        <input type="number" class="form-control" name="sale_count" value="0" />
                        @if ($errors->has('sale_count'))<p style="color:red;">{!!$errors->first('sale_count')!!}</p>@endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{$data[0]['Hình ảnh - Video - Thông số - Tab thông tin']}}</h3>
        </div>
        <div class="box-body">
            <div class="form-group">
                <label>{{$data[0]['Danh sách hình ảnh']}}</label>
                <div class="row">
                    <div class="col-xs-6 col-md-3" id="ImageProduct">
                      <a class="thumbnail">
                        <img onclick="AddImageNewProduct()" alt="100%x75" src="/Lib/images/image.gif" data-holder-rendered="true" style="height: 75px; width: 100%; display: block;" />
                      </a>
                    </div>
                    <?php 
                    if(trim($product->images)!=''){
                        $images = explode(',', $product->images);
                        foreach ($images as $v) {
                            $url = \App\Common\ReturnImage::Image($v);
                            echo '<div class="col-xs-6 col-md-3 relativeimage">
                                <button onclick="DeleteImageProduct($(this))" class="form-control" type="button"><i class="fa fa-fw fa-remove"></i></button>
                                <a class="thumbnail">
                                    <img onclick="AddImageNewProduct()" alt="100%x75" src="'.$url.'" data-holder-rendered="true" style="height: 75px; width: 100%; display: block;" />
                                    <input type="hidden" name="ImageProduct[]" value="'.$url.'">
                                </a>
                            </div>';
                        }
                    }
                    ?>
                </div>
            </div>
            <hr/>
            <div class="form-group">
                <label>{{$data[0]['Danh sách video']}}</label>
                <div class="input-group" id="VideoProduct">
                    <input type="text" class="form-control" placeholder="URL Video" name="AddVideoNew" />
                    <span class="input-group-addon" style="padding:0px;"><button type="button" onclick="AddVideoNewProduct()" style="border:0px;" class="form-control"><i class="fa fa-check"></i></button></span>
                </div>
                <?php 
                    if(trim($product->videos)!=''){
                        $videos = explode(',', $product->videos);
                        foreach ($videos as $v) {
                            echo '<div class="input-group">
                                <input type="text" class="form-control" value="'.$v.'" placeholder="" name="VideoProduct[]" />
                                <span class="input-group-addon" style="padding:0px;"><button type="button" onclick="DeleteVideoProduct($($(this)))" style="border:0px;" class="form-control"><i class="fa fa-fw fa-remove"></i></button></span></div>';
                        }
                    }
                ?>
            </div>
            <hr/>
            <div class="form-group">
                <label>{{$data[0]['Danh sách thông số']}}</label>
                <div class="input-group" id="InfoProduct">
                    <input style="width:50%;" type="text" name="AddInfoNewTitle" placeholder="{{$data[0]['Tiêu đề']}}" class="form-control">
                    <input style="width:50%;" type="text" name="AddInfoNewContent" placeholder="{{$data[0]['Chi tiết']}}" class="form-control">
                    <span class="input-group-addon" style="padding:0px;"><button type="button" onclick="AddInfoNewProduct()" style="border:0px;" class="form-control"><i class="fa fa-fw fa-plus"></i></button></span>
                </div>
                <?php 
                if($product->infos != ''){
                    $dstab = '<ArrayOfConsignmentTrack xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns="http://tempuri.org/">'.$product->infos.'</ArrayOfConsignmentTrack>';        
                    $xml4 = simplexml_load_string($dstab); 
                    for ($i = 0; ; $i++) {
                        if(!isset($xml4->item[$i])){break;}
                        $tieudeinfo = isset($xml4->item[$i])?$xml4->item[$i]->title:'';
                        $noidunginfo = isset($xml4->item[$i])?$xml4->item[$i]->content:'';
                        ?>
                        <div class="input-group">
                            <input value="{{$tieudeinfo}}" style="width:50%;" type="text" name="InfoProductTitle[]" placeholder="Tiêu đề" class="form-control" />
                            <input style="width:50%;" type="text" name="InfoProductContent[]" value="{{$noidunginfo}}" placeholder="Nội dung" class="form-control" />
                            <span class="input-group-addon" style="padding:0px;"><button type="button" onclick="DeleteInfoNewProduct($(this))" style="border:0px;" class="form-control"><i class="fa fa-fw fa-remove"></i></button></span>
                        </div>    
                        <?php
                    }
                }
                ?>
            </div>
            <hr/>
            <div class="form-group">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab1product">{{$data[0]['Tiêu đề Tab 1']}}</a></li>
                    <li><a href="#tab2product">{{$data[0]['Tiêu đề Tab 2']}}</a></li>
                    <li><a href="#tab3product">{{$data[0]['Tiêu đề Tab 3']}}</a></li>
                    <li><a href="#tab4product">{{$data[0]['Tiêu đề Tab 4']}}</a></li>
                    <li><a href="#tab5product">{{$data[0]['Tiêu đề Tab 5']}}</a></li>
                </ul>
                <?php 
                $dstab = '<ArrayOfConsignmentTrack xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns="http://tempuri.org/">'.$product->tabs.'</ArrayOfConsignmentTrack>';        
                $xml4 = simplexml_load_string($dstab); 
                for ($i = 0; $i < 5; $i++) {
                    $tieudetab[] = isset($xml4->item[$i])?$xml4->item[$i]->title:'';
                    $noidungtab[] = isset($xml4->item[$i])?$xml4->item[$i]->content:'';
                }
                ?>
                <div class="tab-content">
                    <div id="tab1product" class="tab-pane fade in active">
                        <div class="form-group">
                            <label>{{$data[0]['Tiêu đề']}}</label>
                            <input value="{{$tieudetab[0]}}" type="text" class="form-control" name="tab_title_1" />
                        </div>
                        <div class="form-group">
                            <label>{{$data[0]['Chi tiết']}}</label>
                            <textarea name="tab_content_1">{{$noidungtab[0]}}</textarea>
                        </div>
                    </div>
                    <div id="tab2product" class="tab-pane fade">
                        <div class="form-group">
                            <label>{{$data[0]['Tiêu đề']}}</label>
                            <input value="{{$tieudetab[1]}}" type="text" class="form-control" name="tab_title_2" />
                        </div>
                        <div class="form-group">
                            <label>{{$data[0]['Chi tiết']}}</label>
                            <textarea name="tab_content_2">{{$noidungtab[1]}}</textarea>
                        </div>
                    </div>
                    <div id="tab3product" class="tab-pane fade">
                        <div class="form-group">
                            <label>{{$data[0]['Tiêu đề']}}</label>
                            <input value="{{$tieudetab[2]}}" type="text" class="form-control" name="tab_title_3" />
                        </div>
                        <div class="form-group">
                            <label>{{$data[0]['Chi tiết']}}</label>
                            <textarea name="tab_content_3">{{$noidungtab[2]}}</textarea>
                        </div>
                    </div>
                    <div id="tab4product" class="tab-pane fade">
                        <div class="form-group">
                            <label>{{$data[0]['Tiêu đề']}}</label>
                            <input value="{{$tieudetab[3]}}" type="text" class="form-control" name="tab_title_4" />
                        </div>
                        <div class="form-group">
                            <label>{{$data[0]['Chi tiết']}}</label>
                            <textarea name="tab_content_4">{{$noidungtab[3]}}</textarea>
                        </div>
                    </div>
                    <div id="tab5product" class="tab-pane fade">
                        <div class="form-group">
                            <label>{{$data[0]['Tiêu đề']}}</label>
                            <input value="{{$tieudetab[4]}}" type="text" class="form-control" name="tab_title_5" />
                        </div>
                        <div class="form-group">
                            <label>{{$data[0]['Chi tiết']}}</label>
                            <textarea name="tab_content_5">{{$noidungtab[4]}}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{$data[0]['Thông tin SEO']}}</h3>
        </div>
        <div class="box-body">
            <div class="form-group">
                <label>{{$data[0]['URL trang']}}</label>
                <input type="text" class="form-control" name="url" placeholder="" value="{{$pageproduct->url}}" />
            </div>
            <div class="form-group">
                <label>{{$data[0]['Trang hiển thị']}}</label>
                <select class="form-control" name="vpage">
                    <?php  foreach ($page as $v) {echo '<option '.($pageproduct->id_vpage==$v->id?'selected="selected"':'').' value="'.$v->id.'">'.$v->name.'</option>';} ?>
                </select>
            </div>
            <div class="form-group">
                <label>{{$data[0]['Thẻ title']}}</label>
                <input type="text" class="form-control" name="seo_title" value="{{$pageproduct->seo_title}}" />
            </div>
            <div class="form-group">
                <label>{{$data[0]['Thẻ description']}}</label>
                <input type="text" class="form-control" name="seo_description" value="{{$pageproduct->seo_description}}" />
            </div>
            <div class="form-group">
                <label>{{$data[0]['Thẻ keyword']}}</label>
                <input type="text" class="form-control" name="seo_keyword" value="{{$pageproduct->seo_keyword}}" />
            </div>
            <div class="form-group">
                <label>{{$data[0]['Tags']}}</label>
                <select class="form-control select2" multiple="multiple" data-placeholder="" name="tags[]" style="width: 100%;">
                    <?php  
                    $tagsx = explode(',', $pageproduct->ids_tags);
                    foreach ($tags as $v) {echo '<option '.(in_array($v->id, $tagsx)?'selected="selected"':'').' value="'.$v->id.'">'.$v->{lang.'name'}.'</option>';} ?>
                </select>
            </div>
        </div>
    </div>
</div>

<div class="box-footer">
    <a href="/admin/product/list" class="btn btn-default pull-right">{{$data[0]['Nút quay lại']}}</a>
    <button type="submit" style="margin-right: 10px;" class="btn btn-info pull-right">{{$data[0]['Button Xác nhận chỉnh sửa']}}</button>
</div>

</form></div>
<style>
section.content>.box {
    background: none;
    border-top: 0px;
    box-shadow: 0px 0px;
}       
</style>
@stop()
@section ('footer')
<link href="/libadmin/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css"/>
<script src="/libadmin/plugins/daterangepicker/moment.js" type="text/javascript"></script>
<script src="/libadmin/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>

<link href="/libadmin/plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css"/>
<script src="/libadmin/plugins/timepicker/bootstrap-timepicker.min.js" type="text/javascript"></script>

<link href="/libadmin/plugins/select2/select2.min.css" rel="stylesheet" type="text/css"/>
<script src="/libadmin/plugins/select2/select2.full.min.js" type="text/javascript"></script>
<script>
CKEDITOR.replace('detail');    
CKEDITOR.replace('tab_content_1'); 
CKEDITOR.replace('tab_content_2'); 
CKEDITOR.replace('tab_content_3'); 
CKEDITOR.replace('tab_content_4'); 
CKEDITOR.replace('tab_content_5'); 
$('.select2').select2();  
$('#reservation').daterangepicker();
$(".timepicker").timepicker({showInputs: false});
$(".nav-tabs a").click(function(){$(this).tab('show');});
function AddEditProduct(){
    var ptnew = $('[name="newsrelated[]"]'), mangnew = [];
    for(var i=0; i<ptnew.size(); i++){
        mangnew[i] = ptnew.eq(i).attr('value');
    }
    $('[name="DataNewsRelated"]').val(mangnew.join(','));
    var ptproduct = $('[name="productrelated[]"]'), mangproduct = [];
    for(var i=0; i<ptproduct.size(); i++){
        mangproduct[i] = ptproduct.eq(i).attr('value');
    }
    $('[name="DataNewsRelated"]').val(mangproduct.join(','));
    return true;
}
function DeleteItem(pt){
    pt.remove();
}
</script>
<style>
.relativeimage{position:relative;}
.relativeimage button{
    position: absolute;
    bottom: 25px;
    right: 20px;
    width: 30px;
    padding: 5px;
    height: 30px;
    background: rgba(255, 255, 255, 0.75);
}
</style>
@stop()
