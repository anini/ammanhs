$(document).ready(function(){
	enable_tooltips();
});

function refresh_header(){
	$('#header').load('/site/refreshHeader', enable_tooltips);
}

function connect(form){
	var f = $(form);
	$.ajax({
		'type':'post',
		'url':f.attr('action'),
		'data':f.serialize(),
		'success':function(data){
			if(data != 'logged-in')
				f.parent().html(data);
			else
				refresh_header();
		}
	});
	return false;
}

function enable_tooltips(){
	$('#header-avatar').tooltip({placement: 'bottom'});
	$('.octicons').tooltip({placement: 'bottom'});
}