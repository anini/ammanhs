<div class="row-fluid">
	<div class="modal-header ge-ss">  
		<a class="close" data-dismiss="modal">×</a>
		<h4><?php echo ($model->scenario=='create')?Yii::t('core', 'Create Membership'):Yii::t('core', 'Edit Membership'); ?></h4> 
	</div>
	<div class="modal-body" style="overflow: hidden !important;">
		<div class="span6">
			<?php if(!$saved){ ?>
				<?php echo $this->renderPartial('_form', array('model'=>$model, 'user'=>$user)); ?>
			<?php }else{ ?>
				<div style="margin-top: 10px; font-size: 15px;">
					<?php echo Yii::t('core', 'Thank you! Your membership request has been received, we will contact you as soon as possible.'); ?>
				</div>
			<?php } ?>
		</div>
		<div class="span6">
			<?php echo $this->renderPartial('_privileges', array('type'=>$model->type)); ?>
		</div>
	</div>
	<div class="modal-footer">
		<?php echo Yii::t('core', 'You would be able to edit your membership later'); ?>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	document.location.hash='<?php echo $model->scenario; ?>';
	$('.modal').on('hidden', function(){
		document.location.hash='';
		<?php if($saved) echo 'location.reload();'; ?>
	});
});
</script>