$(document).ready(function(){
    if(document.location.pathname.indexOf('/thread/')<0){
        $('.vote-up').tooltip({placement: 'top'});
        $('.vote-down').tooltip({placement: 'bottom'});
        return;
    }
    hash=document.location.hash;
    if(hash){
        switch(hash){
            case '#me':
                switch_threads_tab(1);
                break;
            case '#top':
                switch_threads_tab(2);
                break;
        }
    }else if(typeof type!=='undefined'){
        switch(type){
            case 'me':
                $('.nav-tabs .active').removeClass('active');
                $('.tab-content .active').removeClass('active');
                document.location.hash='top';
                $('#me-tab').addClass('active');
                $('#me-tab-label').addClass('active');
                break;
            case 'top':
                $('.nav-tabs .active').removeClass('active');
                $('.tab-content .active').removeClass('active');
                document.location.hash='top';
                $('#top-tab').addClass('active');
                $('#top-tab-label').addClass('active');
                break;
            default:
                document.location.hash='recent';
        }
    }
    $('.thread-title-anchor').tooltip({placement: 'bottom'});
});

function add_thread_reply(form_id){
    if(user_is_guest){
        open_login_modal('add_thread_reply', form_id);
        return false;
    }
    f=$('#'+form_id);
    $('#add-thread-reply-button button').attr('disabled', 'disabled');
    $('#add-thread-reply-button').addClass('loading');
    $.ajax({
        'type':'post',
        'url':f.attr('action'),
        'data':f.serialize(),
        'success':function(data){
            $('.yw0').attr('disabled', 'enabled');
            $('#thread-replies').append(data);
            $('#ThreadReply_content').val('');
            $('#wmd-preview').html('');
            $('#add-thread-reply-button').removeClass('loading');
            $('#add-thread-reply-button button').removeAttr("disabled");
        }
    });
    return false;
}

function switch_threads_tab(tab){
    if(tab==1 && user_is_guest){
        open_login_modal('switch_threads_tab', tab);
        return false;
    }
    $.ajax({
        'type':'get',
        'url':'/thread/threads',
        'data':{'type':tab},
        'success':function(data){
            $('#threads-container').slideUp('slow', function(){
                $('#threads-container').html(data);
                $('#threads-container').slideDown('slow');
            });
            $('.nav-tabs .active').removeClass('active');
            $('.tab-content .active').removeClass('active');
            switch(parseInt(tab)){
                case 1:
                    document.location.hash='me';
                    $('#me-tab').addClass('active');
                    $('#me-tab-label').addClass('active');
                    break;
                case 2:
                    document.location.hash='top';
                    $('#top-tab').addClass('active');
                    $('#top-tab-label').addClass('active');
                    break;
                case 3:
                    document.location.hash='recent';
                    $('#recent-tab').addClass('active');
                    $('#recent-tab-label').addClass('active');
                    break;
            }
        }
    });
    return false;
}

function slide_up_threads_container(){
    if ($("#threads-container").css("display")=="block")
        $("#threads-container").slideUp();
    else
        $("#threads-container").slideDown();
}

function vote(form_id){
    if(user_is_guest){
        open_login_modal('vote', form_id);
        return false;
    }
    form=$('#'+form_id);
    $.ajax({
        dataType: 'json',
        type: 'post',
        url: form.attr('action'),
        data: form.serialize(),
        beforeSend: function() {
            //form.addClass('loading');
        },
        complete: function() {
            //form.removeClass('menu_loading');
        },
        error: function(request){
            //some code here
        },
        success:function(data){
            if(data.errno==0){
                if(form_id.indexOf('reply')!=-1)
                    p=$('#reply-vote-'+$('#thread-reply-vote-id').val());
                else
                    p=form.parent();
                stat_votes=p.find('.vote-number');
                stat_votes.html(data.stat_votes);
                up_arrow=p.find('.vote-up');
                down_arrow=p.find('.vote-down');
                if (data.vote_type==1){
                    up_arrow.removeClass('vote-up-off');
                    down_arrow.removeClass('vote-down-on');
                    up_arrow.addClass('vote-up-on');
                    down_arrow.addClass('vote-down-off');
                }else if(data.vote_type==-1){
                    down_arrow.removeClass('vote-down-off');
                    up_arrow.removeClass('vote-up-on');
                    down_arrow.addClass('vote-down-on');
                    up_arrow.addClass('vote-up-off');
                }else{
                    down_arrow.removeClass('vote-down-on');
                    up_arrow.removeClass('vote-up-on');
                    down_arrow.addClass('vote-up-off');
                    up_arrow.addClass('vote-down-off');
                }
            }else{
                //some code here
            }
        }
    });
    return false;
}