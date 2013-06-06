$(window).load(function(){
	if(document.location.hash=='#create' || document.location.hash=='#update'){
		open_membership_modal();
	}
});

$(document).ready(function(){
	$('.free-membership').hover(
		function(){
			$('.free-membership.btn-info').css('border-top-left-radius', '7px');
			$('.free-membership.btn-info').css('border-top-right-radius', '7px');
			$('.free-membership.btn-inverse').css('border-bottom-left-radius', '7px');
			$('.free-membership.btn-inverse').css('border-bottom-right-radius', '7px');
			$('.free-membership').addClass('membership-hover');
			$('.free-membership.btn-info').addClass('btn-hover');
		},
		function(){
			$('.free-membership').removeClass('membership-hover');
			$('#membership-offers .btn-info').removeClass('btn-hover');
			$('#membership-offers .btn-info').css('border-radius', '0');
			$('#membership-offers .btn-inverse').css('border-radius', '0');
		}
	);
	$('.gold-membership').hover(
		function(){
			$('.gold-membership.btn-warning').css('border-top-left-radius', '7px');
			$('.gold-membership.btn-warning').css('border-top-right-radius', '7px');
			$('.gold-membership.btn-inverse').css('border-bottom-left-radius', '7px');
			$('.gold-membership.btn-inverse').css('border-bottom-right-radius', '7px');
			$('.gold-membership').addClass('membership-hover');
			$('.gold-membership.btn-warning').addClass('btn-hover');
		},
		function(){
			$('.gold-membership').removeClass('membership-hover');
			$('.gold-membership.btn-warning').removeClass('btn-hover');
			$('.gold-membership.btn-warning').css('border-radius', '0');
			$('.gold-membership.btn-inverse').css('border-radius', '0');
		}
	);
	$('.premium-membership').hover(
		function(){
			$('.premium-membership.btn-danger').css('border-top-left-radius', '7px');
			$('.premium-membership.btn-danger').css('border-top-right-radius', '7px');
			$('.premium-membership.btn-inverse').css('border-bottom-left-radius', '7px');
			$('.premium-membership.btn-inverse').css('border-bottom-right-radius', '7px');
			$('.premium-membership').addClass('membership-hover');
			$('.premium-membership.btn-danger').addClass('btn-hover');
		},
		function(){
			$('.premium-membership').removeClass('membership-hover');
			$('.premium-membership.btn-danger').removeClass('btn-hover');
			$('.premium-membership.btn-danger').css('border-radius', '0');
			$('.premium-membership.btn-inverse').css('border-radius', '0');
		}
	);

	$('.free-membership').click(function(){
		open_membership_modal('Free');
	});
	$('.gold-membership').click(function(){
		open_membership_modal('Golden');
	});
	$('.premium-membership').click(function(){
		open_membership_modal('Premium');
	});
});

function open_membership_modal(type){
	if(user_is_guest){
		open_login_modal('open_membership_modal', type, false);
		return false;
	}
	var old_uri=$('#membership-form-link').attr('data-src');
	var uri=old_uri+'?modal';
	if(typeof type!='undefined' && type) uri=uri+'&type='+type;
    $('#membership-form-link').attr('data-src', uri);
    $('#membership-form-link').click();
    $('#membership-form-link').attr('data-src', old_uri);
}

function switch_privileges(type){
	if($('#membership-type').val()){
		$('.modal-body #'+($('.modal-body #membership-type').val()).toLowerCase()+'-mem').fadeOut('slow', function(){$('.modal-body #'+type+'-mem').fadeIn('slow');});
	}else{
		$('.modal-body #'+type+'-mem').fadeIn('slow');
	}
}