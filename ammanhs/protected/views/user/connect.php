<?php
$data=array();
$data['input_class']='span12';
if(isset($callback_func)) $data['callback_func']=$callback_func;
if(isset($attr)) $data['attr']=$attr;
if(isset($redirect)) $data['redirect']=$redirect;
?>
<div class="row-fluid ge-ss">
	<div class="modal-header">  
		<a class="close" data-dismiss="modal" id="close-connect-modal" onclick="document.location.hash='';">×</a>
		<h4><?php echo Yii::t('core', 'Login or Join Amman Hackerspace'); ?></h4> 
	</div>
	<div class="modal-body">
		<div class="span6"> 
			<?php $this->renderPartial('//user/login', $data); ?>
		</div>
		<div class="span6"> 
			<?php $this->renderPartial('//user/signup', $data); ?>
		</div>
	</div>
	<div class="modal-footer">
		<a>
		لماذا أسجل 
		</a>
	</div>
</div>

<script type="text/javascript">
$('.modal').on('hidden', function(){
	document.location.hash='';
});
</script>