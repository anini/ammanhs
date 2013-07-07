$(window).load(function(){
	if(document.location.hash=='#changePassword'){
		open_change_password_modal();
	}
});

function open_change_password_modal(){
	if(user_is_guest) return false;
    $('#change-password-link').click();
    document.location.hash='changePassword';
    return false;
}