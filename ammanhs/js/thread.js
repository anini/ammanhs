function add_thread_reply(form){
	f = $(form);
	$('.yw0').attr('disabled', 'disabled');
	$.ajax({
		'type':'post',
		'url':f.attr('action'),
		'data':f.serialize(),
		'success':function(data){
			$('.yw0').attr('disabled', 'enabled');
			$('#thread_replies').append(data);
			$('#ThreadReply_content').val('');
			$('#wmd-preview').html('');
		}
	});
	return false;
}

function switch_threads_tab(){
	$(".nav-tabs .active a").attr('href');
	var href = $(".nav-tabs .active a").attr('href');
	var tab_no = (href.split('_'))[2];
	$.ajax({
		'type':'get',
		'url':'/thread/threads',
		'data':{'type':tab_no},
		'success':function(data){
			
			$('#threads-container').html(data);
			$('#threads-container').slideDown();
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

function vote(e){
	form = $(e);
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
            if (data.errno == 0) {
            	p = form.parent();
            	stat_votes = p.find('.vote-number');
            	stat_votes.html(data.stat_votes);
            	up_arrow = p.find('.vote-up');
            	down_arrow = p.find('.vote-down');
            	if (data.vote_type == 1) {
            		up_arrow.removeClass('vote-down-off');
            		down_arrow.removeClass('vote-up-on');
            		up_arrow.addClass('vote-up-on');
            		down_arrow.addClass('vote-down-off');
            	} else if (data.vote_type == -1) {
            		down_arrow.removeClass('vote-down-off');
            		up_arrow.removeClass('vote-up-on');
            		down_arrow.addClass('vote-up-on');
            		up_arrow.addClass('vote-down-off');
            	} else {
            		down_arrow.removeClass('vote-down-on');
            		up_arrow.removeClass('vote-up-on');
            		down_arrow.addClass('vote-up-off');
            		up_arrow.addClass('vote-down-off');
            	}
            } else {
            	//some code here
            }
        }
    });
    return false;
}