var user_is_guest;

$(document).ready(function(){
	enable_tooltips();
});

function refresh_header(){
	$('#header').load('/site/refreshHeader', enable_tooltips);
}

function connect(form, callback_func, r_url){
	var f = $(form);
	$.ajax({
		'type':'post',
		'url':f.attr('action'),
		'data':f.serialize(),
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
						callback_func;
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