$(document).ready(function(){
    var h=document.location.hash;
    var a=h.split('photo=');
    if(typeof a[1] !== 'undefined'){
        var photos=$('#album a');
        if(typeof photos[a[1]-1] !== 'undefined'){
            photos[a[1]-1].click();
        }else{
            document.location.hash='album';
        }
    }
    $('#attachments-table').tooltip({placement: 'top'});
    $('#album').tooltip({placement: 'top'});
    var photos=$('#album a img');
    for(i=0; i<photos.length; i++){
        if($(photos[i]).attr('data-original-title')){
            $(photos[i]).tooltip({placement: 'bottom'});
        }
    }
});

function add_activity_reply(form_id){
    if(user_is_guest){
        open_login_modal('add_activity_reply', form_id);
        return false;
    }
    f=$('#'+form_id);
    $('#add-activity-reply-button button').attr('disabled', 'disabled');
    $('#add-activity-reply-button').addClass('loading');
    $.ajax({
        'type':'post',
        'url':f.attr('action'),
        'data':f.serialize(),
        'success':function(data){
            $('.yw0').attr('disabled', 'enabled');
            $('#activity-replies').append(data);
            $('#ActivityReply_content').val('');
            $('#wmd-preview').html('');
            $('#add-activity-reply-button').removeClass('loading');
            $('#add-activity-reply-button button').removeAttr("disabled");
        }
    });
    return false;
}

function add_activity_reply(form_id){
    if(user_is_guest){
        open_login_modal('add_activity_reply', form_id);
        return false;
    }
    f=$('#'+form_id);
    $('#add-activity-reply-button button').attr('disabled', 'disabled');
    $('#add-activity-reply-button').addClass('loading');
    $.ajax({
        'type':'post',
        'url':f.attr('action'),
        'data':f.serialize(),
        'success':function(data){
            $('.yw0').attr('disabled', 'enabled');
            $('#activity-replies').append(data);
            $('#ActivityReply_content').val('');
            $('#wmd-preview').html('');
            $('#add-activity-reply-button').removeClass('loading');
            $('#add-activity-reply-button button').removeAttr("disabled");
        }
    });
    return false;
}