<div class="row-fluid">
	<div class="modal-header ge-ss">
		<a class="close" data-dismiss="modal">×</a>
		<h4><?php echo Yii::t('core', 'Change Password'); ?></h4> 
	</div>
	<div class="modal-body">
		<?php
		if($password_changed){
			echo Yii::t('core', 'Your password has been successfuly updated.');
		}else{
			$form=$this->beginWidget('CActiveForm', array(
				'id'=>'change-password-form',
				'action'=>'user/changePassword?modal',
				'htmlOptions'=>array(
					'class'=>'form-inline',
					'onSubmit'=>"submit_ajax(this, '.modal'); return false;",				)
				)); ?>
				<div class="control-group">
					<?php echo $form->passwordField($model,'old_password', array('class'=>'input-block-level', 'placeholder'=>Yii::t('core', 'Old Password'))); ?>
					<?php echo $form->error($model,'old_password', array('class'=>'help-inline error')); ?>
				</div>
				<div class="control-group">
					<?php echo $form->passwordField($model,'password', array('class'=>'input-block-level', 'placeholder'=>Yii::t('core', 'New Password'))); ?>
					<?php echo $form->error($model,'password', array('class'=>'help-inline error')); ?>
				</div>
				<div class="control-group">
					<?php echo $form->passwordField($model,'verify_password', array('class'=>'input-block-level', 'placeholder'=>Yii::t('core', 'Verify Password'))); ?>
					<?php echo $form->error($model,'verify_password', array('class'=>'help-inline error')); ?>
				</div>
				<div class="control-group">
					<button class="btn btn-primary btn-block" type="submit"><?php echo Yii::t('core','Change'); ?></button>
				</div>
			<?php
			$this->endWidget();
		}
		?>
	</div>
</div>

<script type="text/javascript">
$('.modal').on('hidden', function(){
	document.location.hash='';
});
</script>