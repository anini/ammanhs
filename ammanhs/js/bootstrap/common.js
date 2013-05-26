$(function(){
    $.fn.modalmanager.defaults.resize = true;
    $('.popoverme').popover();
    // my own ajax modals short cut
    $(document).on('click', '[data-toggle="ajax-modal"]', function(){
    //$('[data-toggle="ajax-modal"]').click(function(){
        var $target, modal_attr=this.getAttribute('data-modal-attr'), target=this.getAttribute('data-target'), src=this.getAttribute('data-src');
        var attr={class:"modal hide fade", tabindex:"-1", role:"dialog"};
        if (modal_attr) $.extend(attr, $.parseJSON(modal_attr));
        if (target) $target=$(target);
        else $target=$('<div>').attr(attr);
        $('body').modalmanager('loading');
        $target.load(src, '', function(response, status, xhr){
            $('body').modalmanager('loading');
            if (status != "error") $target.modal(); else alert('Server Error: unable to load dialog');});
        });
});

window.flashmsg=function(opts) {
    if (!opts) opts={};
    if (!opts.type) opts.type='info';
    if (!opts.target_selector) opts.target_selector='#mainContent';
    if (!opts.target) opts.target=$(opts.target_selector);
    window.flashmsg
    var $d=$('<div>').attr({'class':'alert alert-block fade in alert-'+opts.type});
    if (opts.html) $d.html(opts.html);
    else $d.text(opts.text);
    $d.html('<button type="button" class="close" data-dismiss="alert">&times;</button>'+$d.html());
    opts.target.prepend($d);
}

function nearest_modal() {
    var scripts=document.getElementsByTagName("script");
    var current = scripts[scripts.length-1];
    return $(current).closest('.modal');
}

function nearest_modal_flashmsg(opts) {
    opts.target=nearest_modal().find('.modal-body');
    window.flashmsg(opts);
}

function ajax_modal_form(f, opts) {
    var $f=$(f), $target;
    if (!opts) opts={};
    if (opts.selector) $target=$(selector);
    else $target=$f.closest('.modal');
    
    if (opts.before && !opts.before($target)) return false;
    
    //if (typeof(opts.with_close)=='undefined') with_close=false;
    if (!opts.loading) {
    /*
    if (typeof($target.modal)=='function')
        opts.loading=function() {$target.modal('loading');}
    else */
        opts.loading=function(){$('body').modalmanager('loading');}
    }
    $.ajax({
        type:'post',
		url:$f.attr('action'),
		data:$f.serialize() ,
		beforeSend:opts.loading, complete:opts.loading, /*error:opts.loading,*/
        error:function(d) {
            if (typeof($target.modal)=='function')
                $target.find('.modal-body').prepend('<div class="alert alert-block alert-error fade in"><button type="button" class="close" data-dismiss="alert">&times;</button>' +d.responseText+'</div>');
        },
		success:function(d){
            $target.html(d);
            if (opts.with_close) $target.modal('hide');
            if (opts.cb) {opts.cb($target);}
        }
	});
    return false;
} 

// TODO: remove from common

function show_login_hero() {
    $('#hero_welcome_guest').hide();
    $('#login_hero').show();
}

function contact_us_show_tab(i) {
    $('#contactUsModal .nav-tabs li').removeClass('active');
    $('#contactUsModal .mytab').hide();
    $('#contactUsModal .nav-tabs li:eq('+i+')').addClass('active')
    $('#contactUsModal .mytab:eq('+i+')').show();
    return false;
}
