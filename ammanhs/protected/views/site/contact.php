<div class="row-fluid ge-ss">
	<div class="modal-header">
		<a class="close" data-dismiss="modal" onclick="document.location.hash='';">×</a>
		<h4><?php echo Yii::t('core', 'Contact Us'); ?></h4> 
	</div>
	<div class="modal-body">
		<div class="span12"> 
			<?php if(Yii::app()->user->hasFlash('contact')): ?>
			<div class="flash-success">
				<?php echo Yii::app()->user->getFlash('contact'); ?>
			</div>

			<?php else: ?>
			<?php $form=$this->beginWidget('CActiveForm', array(
				'id'=>'contact-form',
				'enableAjaxValidation'=>true,
				'action'=>'/contact?modal',
				'htmlOptions'=>array(
					'enctype'=>'multipart/form-data',
					'class'=>'form-horizontal inline-form',
					'style'=>'margin-bottom: 0;',
					'enableClientValidation'=>true,
					'onSubmit'=>"submit_ajax(this, '.modal'); return false;",
					),
				)); ?>

				<div class="control-group">
					<?php echo $form->labelEx($model, 'name', array('class'=>'control-label')); ?>
					<div class="controls">
						<?php echo $form->textField($model, 'name', array('class'=>'span10', 'value'=>((Yii::app()->user->isGuest)?'':Yii::app()->user->model->name))); ?>
						<?php echo $form->error($model, 'name', array('class'=>'help-inline error ge-ss')); ?>
					</div>
				</div>

				<div class="control-group">
					<?php echo $form->labelEx($model, 'email', array('class'=>'control-label')); ?>
					<div class="controls">
						<?php echo $form->textField($model,'email', array('class'=>'span10', 'value'=>((Yii::app()->user->isGuest)?'':Yii::app()->user->model->email))); ?>
						<?php echo $form->error($model, 'email', array('class'=>'help-inline error ge-ss')); ?>
					</div>
				</div>

				<div class="control-group">
					<?php echo $form->labelEx($model, 'subject', array('class'=>'control-label')); ?>
					<div class="controls">
						<?php echo $form->textField($model, 'subject',array('maxlength'=>128, 'class'=>'span10')); ?>
						<?php echo $form->error($model, 'subject', array('class'=>'help-inline error ge-ss')); ?>
					</div>
				</div>

				<div class="control-group">
					<?php echo $form->labelEx($model, 'body', array('class'=>'control-label')); ?>
					<div class="controls">
						<?php echo $form->textArea($model, 'body',array('rows'=>6, 'class'=>'span10')); ?>
						<?php echo $form->error($model, 'body', array('class'=>'help-inline error ge-ss')); ?>
					</div>
				</div>

				<?php if(CCaptcha::checkRequirements()): ?>
				<div class="control-group">
					<div class="controls">
						<?php $this->widget('CCaptcha'); ?>
					</div>
					<?php echo $form->labelEx($model, 'verifyCode', array('class'=>'control-label')); ?>
					<div class="controls">
						<?php echo $form->textField($model, 'verifyCode', array('class'=>'span10', 'placeholder'=>Yii::t('core', 'Please enter the letters shown in the image above.'))); ?>
						<?php echo $form->error($model, 'verifyCode', array('class'=>'help-inline error ge-ss')); ?>
					</div>
				</div>
			<?php endif; ?>

			<div class="form-actions" style="margin-bottom: 0;">
				<button class="btn btn-primary" type="submit"><?php echo Yii::t('core', 'Send'); ?></button>
			</div>

			<?php echo CHTML::hiddenField('ContactForm[ref]', '', array('id'=>'contact-ref')); ?>

			<?php $this->endWidget(); ?>

			<?php endif; ?>
		</div>
	</div>
</div>

<script type="text/javascript">
$('.modal').on('hidden', function(){
	document.location.hash='';
});
document.getElementById('contact-ref').value=document.location.href;
</script>
