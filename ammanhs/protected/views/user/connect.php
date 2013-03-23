<?php
$data = array();
if(isset($callback_func)){
	$data['callback_func'] = $callback_func;
}
if(isset($attr)){
	$data['attr'] = $attr;
}
?>
<div class="row-fluid">
	<div class="modal-header ge-ss">  
		<a class="close" data-dismiss="modal" id="close-connect-modal">×</a>  
		<h4>سجل الدخول أو انضم إلى فضاء المتمكنين | عمان</h4> 
	</div>
	<div class="modal-body row-fluid">
		<div class="span6"> 
			<?php $this->renderPartial('//user/login', $data); ?>
		</div>
		<div class="span6"> 
			<?php $this->renderPartial('//user/signup', $data); ?>
		</div>
	</div>
	<div class="modal-footer">
		لماذا أسجل 
	</div>
</div>