info_wait = 'Updating';
function SendComment(id, type, parent){
    InfoResult(info_wait,0);
    var name, email, mark, title, content;
    name    = $('[name="comment_name"]');
    email   = $('[name="comment_email"]');
    mark    = $('[name="comment_mark"]');
    title   = $('[name="comment_title"]');
    content = $('[name="comment_content"]'); 
    $.getJSON('/update/Comment/'+type,{id:id, parent:parent, name:name.val(), email:email.val(), mark:mark.val(), title:title.val(), content:content.val()}, function(result){
        if(result.update==1){
            name.val(''); email.val(''); mark.val(''); title.val(''); content.val(''); 
        }
        InfoResult(result.info,1);
    });
}
function InfoResult(info,status){
    $('#resultUpdate').html(info);
    if(status==1){
        if($('#resultUpdate').html()!=undefined){
            $('#resultUpdate').show().delay(1000).slideUp(500);
        }
    }
}