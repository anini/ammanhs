var user_is_guest;

$(document).ready(function(){
	enable_tooltips();
});

function refresh_header(){
	$('#header').load('/site/refreshHeader', enable_tooltips);
}

function open_login_modal(callback_func, attr){
	old_uri=$('#connect-link').attr('data-src');
    $('#connect-link').attr('data-src', old_uri+'?callback_func='+callback_func+'&attr='+attr);
    $('#connect-link').click();
    $('#connect-link').attr('data-src', old_uri);
}

function connect(form, callback_func, attr, r_url){
	var f = $(form);
	var data = f.serialize();
	if(typeof callback_func != 'undefined' && callback_func){
		if(typeof attr == 'undefined' || !attr)
			attr='';
		data=data+'&callback_func='+callback_func+'&attr='+attr;
	}
	$.ajax({
		'type':'post',
		'url':f.attr('action'),
		'data':data,
		'success':function(data){
			if(data != 'logged-in'){
				f.parent().html(data);
			}else{
				user_is_guest = 0;
				if(typeof r_url != 'undefined' && r_url){
					document.location = r_url;
				}else{
					refresh_header();
					if(typeof callback_func != 'undefined' && callback_func){
						$('#close-connect-modal').click()
						if(typeof attr == 'undefined' || !attr)
							attr='';
						window[callback_func](attr);
					}
				}
			}
		}
	});
	return false;
}

function enable_tooltips(){
	$('#header-avatar').tooltip({placement: 'bottom'});
	$('.octicons').tooltip({placement: 'bottom'});
}