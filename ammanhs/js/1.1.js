var user_is_guest;

$(document).ready(function(){
	enable_tooltips();
});

$(window).load(function(){
	var params=document.location.hash.split('?');
	if(params[0]=='#connect'){
		if(typeof params[1]!='undefined'){
			redirect=params[1].split('=');
			if(redirect[0]=='redirect' && typeof redirect[1]!='undefined') open_login_modal(false, false, redirect[1]);
			else open_login_modal();
		}
		else open_login_modal();
	}else if(params[0]=='#contact'){
		open_contact_modal();
	}
});

function refresh_header(){
	$('#header').load('/site/refreshHeader', enable_tooltips);
}

function refresh_sidebar(){
	$('#sidebar').load('/site/refreshSidebar', enable_tooltips);
}

function open_contact_modal(hash){
    $('#contact-link').click();
    if(typeof hash==='undefined'){
    	hash='contact';
    }
    document.location.hash=hash;
    return false;
}

function submit_ajax(e, parent_selector, url) {
	var f=$(e);
	var data=f.serialize();
	var action;
	if(typeof url!='undefined' && url){
		action=url;
	}else{
		action=f.attr('action');
	}
	$.ajax({
		'type':'post',
		'url':action,
		'data':data,
		'success':function(data){
			if(typeof parent_selector=='undefined')
				f.parent().html(data);
			else
				$(parent_selector).html(data);
		}
	});
	return false;
}

function open_login_modal(callback_func, attr, redirect){
	if(!user_is_guest) return false;
	document.location.hash='connect';
	var old_uri=$('#connect-link').attr('data-src');
	var uri=old_uri;
	if(callback_func) uri=uri+'&callback_func='+callback_func;
	if(attr) uri=uri+'&attr='+attr;;
	if(redirect) uri=uri+'&redirect='+redirect;;
    $('#connect-link').attr('data-src', uri);
    $('#connect-link').click();
    $('#connect-link').attr('data-src', old_uri);
}

function connect(form, callback_func, attr, redirect){
	var f=$(form);
	var data=f.serialize();
	if(typeof callback_func!='undefined' && callback_func){
		if(typeof attr=='undefined' || !attr)
			attr='';
		data=data+'&callback_func='+callback_func+'&attr='+attr;
	}
	$.ajax({
		'type':'post',
		'url':f.attr('action'),
		'data':data,
		'success':function(data){
			if(data!='logged-in'){
				f.parent().html(data);
			}else{
				user_is_guest=0;
				document.location.hash='';
				if(typeof redirect!='undefined' && redirect){
					document.location=redirect;
				}else{
					refresh_header();
					refresh_sidebar();
					if($('#close-connect-modal')) $('#close-connect-modal').click();
					if(typeof callback_func!='undefined' && callback_func){
						if(typeof attr=='undefined' || !attr)
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
	$('.img-circle').tooltip({placement: 'bottom'});
}

(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
ga('create', 'UA-40309445-1', 'ammanhs.com');
ga('send', 'pageview');