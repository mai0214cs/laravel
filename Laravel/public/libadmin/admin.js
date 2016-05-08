function togglecheckboxes(pt){ 
    var cb = $('.CheckAll'); 
    for(var i = 0; i < cb.length; i++){ 
        cb[i].checked = pt.checked; 
    }
}
function XoaCheckAll(url, message){
    if(confirm(message)){
        var pt = $('input.CheckAll');
        var check = pt.size(), arr=[], j=0;
        for(var i=0; i<check; i++){ if(pt[i].checked){ arr[j] = pt.eq(i).attr('rel'); j++; }}
        $.get(url, {ids:arr}, function(){
            DirectPage();
        });
    }
}
function BrowseServer(field)
{
    var finder = new CKFinder();
    finder.basePath = '/';
    finder.selectActionFunction = function(url){
        $('[name="'+field+'"]').val(url);
        $('.uploadhinhanh'+field).html('<img src="'+url+'" alt="Hình ảnh" style="width:100px;" />');
    };
    finder.popup();
}

function ChangeLanguage(pt)
{
    $.get('/update/ChangeLanguage/'+pt,{},function(o){ 
        //alert(o);
        window.location.href = window.location.href.toString();
    });
}
function InfoMessage(){
    if($('.box-msg .alert').html()!=undefined){
        $('.box-msg .alert').show().delay(1000).slideUp(500);
    }
}
InfoMessage();

function CheckStatus(url,val,id){
    $.get(url+'/'+val+'/'+id,{},function(o){
        $('.box-msg').html(o); InfoMessage();
    });
}
function DirectPage(){
    window.location.href = window.location.href.toString();
}




//------ Danh sách các hàm dùng cho trang chi tiết sản phẩm
function AddInfoNewProduct(){
    var title, content, html;
    title = $('[name="AddInfoNewTitle"]').val(); $('[name="AddInfoNewTitle"]').val('');
    content = $('[name="AddInfoNewContent"]').val(); $('[name="AddInfoNewContent"]').val('');
    html = '<div class="input-group"><input value="'+title+'" style="width:50%;" type="text" name="InfoProductTitle[]" placeholder="Tiêu đề" class="form-control"><input style="width:50%;" type="text" name="InfoProductContent[]" value="'+content+'" placeholder="Nội dung" class="form-control"><span class="input-group-addon" style="padding:0px;"><button type="button" onclick="DeleteInfoNewProduct($(this))" style="border:0px;" class="form-control"><i class="fa fa-fw fa-remove"></i></button></span></div>';
    $('#InfoProduct').after(html); return false;
}
function DeleteInfoNewProduct(pt){
    pt.parent('.input-group-addon').parent('.input-group').remove();
}
function AddVideoNewProduct(){
    var url, html;
    url = $('[name="AddVideoNew"]').val(); $('[name="AddVideoNew"]').val('');
    html = '<div class="input-group"><input type="text" class="form-control" value="'+url+'" placeholder="Nhập URL Video" name="VideoProduct[]" /><span class="input-group-addon" style="padding:0px;"><button type="button" onclick="DeleteVideoProduct($($(this)))" style="border:0px;" class="form-control"><i class="fa fa-fw fa-remove"></i></button></span></div>';
    $('#VideoProduct').after(html); return false;
}
function DeleteVideoProduct(pt){
    pt.parent('.input-group-addon').parent('.input-group').remove();
}
function AddImageNewProduct(){
    var finder = new CKFinder();
    finder.basePath = '/';
    finder.selectActionFunction = function(url){
        var html='<div class="col-xs-6 col-md-3 relativeimage"><button onclick="DeleteImageProduct($(this))" class="form-control" type="button"><i class="fa fa-fw fa-remove"></i></button><a class="thumbnail"><img onclick="AddImageNewProduct()" alt="100%x75" src="'+url+'" data-holder-rendered="true" style="height: 75px; width: 100%; display: block;" /><input type="hidden" name="ImageProduct[]" value="'+url+'" /></a></div>';
        $('#ImageProduct').after(html);
    };
    finder.popup();
}
function DeleteImageProduct(pt){
    pt.parent('.relativeimage').remove();
}
function AddImageOption(){
    var finder = new CKFinder();
    finder.basePath = '/';
    finder.selectActionFunction = function(url){
        $('[name="AvatarOptionAdd"]').val(url);
    };
    finder.popup();
}
function AddOptionNewProduct(){
    var code, name, avatar, price, html;
    code = $('[name="PriceOptionsCodeAdd"]').val(); $('[name="PriceOptionsCodeAdd"]').val(''); 
    name = $('[name="PriceOptionsNameAdd"]').val(); $('[name="PriceOptionsNameAdd"]').val(''); 
    avatar = $('[name="AvatarOptionAdd"]').val(); $('[name="AvatarOptionAdd"]').val(''); 
    price = $('[name="PriceOptionsPriceAdd"]').val(); $('[name="PriceOptionsPriceAdd"]').val(''); 
    html = '<tr><td><input type="text" class="form-control" value="'+code+'" name="PriceOptionsCode[]" /></td><td><input type="text" class="form-control" value="'+name+'" name="PriceOptionsName[]" /></td><td><input type="hidden" class="form-control" value="'+avatar+'" name="AvatarOption[]" /><img src="'+avatar+'" style="width:35px; height:35px;" alt="'+name+'" /></td><td><input placeholder="Giá bán" type="number" value="'+price+'" class="form-control" name="PriceOptionsPriceAdd[]" /></td><td><button type="button" onclick="DeleteOptionProduct($(this))" class="form-control"><i class="fa fa-fw fa-remove"></i></button></td></tr>';
    $('#OptionProduct').after(html);
}      
function SelectCategoryNews(id){
    $.get('/admin/product/list/getCategoryNews',{id:id},function(o){
        $('[name="listnewsrelated"]').html(o);
    });
}
function SelectCategoryProduct(id){
    $.get('/admin/product/list/getCategoryProduct',{id:id},function(o){
        $('[name="listproductrelated"]').html(o);
    });
}
function SelectListNews(pt){
    $('[name="newsrelated[]"]').prepend('<option value="'+pt.attr('value')+'">'+pt.html()+'</option>');
    pt.remove();
}
function SelectListProduct(pt){
    $('[name="productrelated[]"]').prepend('<option value="'+pt.attr('value')+'">'+pt.html()+'</option>');
    pt.remove();
}
function DeleteOptionProduct(pt){
    pt.parent('td').parent('tr').remove();
}
//------ Hết Danh sách các hàm dùng cho trang chi tiết sản phẩm