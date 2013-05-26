<div class="row-fluid ge-ss">
	<div class="modal-header">  
		<a class="close" data-dismiss="modal" id="close-connect-modal">×</a>  
		<h4><?php echo Yii::t('core', 'Contact Us') ?></h4> 
	</div>
	<div class="modal-body" style="overflow: hidden !important;">
		<div class="span12"> 





<?php if(Yii::app()->user->hasFlash('contact')): ?>

<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('contact'); ?>
</div>

<?php else: ?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'contact-form',
	'enableAjaxValidation'=>true,
	'htmlOptions'=>array(
        'enctype'=>'multipart/form-data',
        'class'=>'form-horizontal inline-form',
        'enableClientValidation'=>true,
        'onSubmit'=>"submit_ajax(this, '.modal'); return false;",
    ),
)); ?>

	<div class="control-group">
		<?php echo $form->labelEx($model,'name', array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'name', array('class'=>'span10')); ?>
			<?php echo $form->error($model,'name'); ?>
		</div>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'email', array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'email', array('class'=>'span10')); ?>
			<?php echo $form->error($model,'email'); ?>
		</div>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'subject', array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'subject',array('maxlength'=>128, 'class'=>'span10')); ?>
			<?php echo $form->error($model,'subject'); ?>
		</div>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'body', array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textArea($model,'body',array('rows'=>6, 'class'=>'span10')); ?>
			<?php echo $form->error($model,'body'); ?>
		</div>
	</div>

	<?php if(CCaptcha::checkRequirements()): ?>
	<div class="control-group">
		<div class="controls">
			<?php $this->widget('CCaptcha'); ?>
		</div>
		<?php echo $form->labelEx($model,'verifyCode', array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'verifyCode', array('class'=>'span10')); ?>
			<?php echo $form->error($model,'verifyCode'); ?>
		</div>
		<div class="hint">Please enter the letters as they are shown in the image above.
		<br/>Letters are not case-sensitive.</div>
	</div>
	<?php endif; ?>

	<div class="form-actions">
		<button class="btn btn-primary" type="submit"><?php echo Yii::t('core','Submit'); ?></button>
	</div>

<?php $this->endWidget(); ?>

<?php endif; ?>


		</div>
	</div>
</div>
