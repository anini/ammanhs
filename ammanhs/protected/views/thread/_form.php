<?php
Yii::app()->clientScript->registerCSSFile('/css/tag.css');
Yii::app()->clientScript->registerScriptFile('/js/tag.js', CClientScript::POS_END);
?>

<?php
$form=$this->beginWidget('CActiveForm',array(
	'id'=>'thread-form',
	'enableAjaxValidation'=>true,
	'htmlOptions'=>array(
		//'onsubmit'=>'return add_thread_reply("thread-reply-form");'
	),
)); ?>

<div class="control-group">
	<?php echo $form->labelEx($model,'title'); ?>
	<?php echo $form->textField($model,'title',array('class'=>'span5','maxlength'=>256)); ?>
	<?php echo $form->error($model,'title', array('class'=>'help-inline error ge-ss')); ?>
</div>

<?php //echo $form->textField($model,'type',array('class'=>'span5','maxlength'=>12)); ?>

<div class="control-group">
	<?php echo $form->labelEx($model,'content'); ?>
	<?php echo $form->markdownEditor($model, 'content', array('error'=>$form->error($model,'content', array('class'=>'help-inline error ge-ss', 'style'=>'float: left; margin-top:-30px;'))));?>
</div>

<div class="control-group">
	<?php //echo $form->labelEx($model,'tags', array('class'=>'ge-ss')); ?>
	<?php //echo $form->textField($model,'tags',array('class'=>'span5','maxlength'=>128,'data-provide'=>'tag')); ?>
	<?php //echo $form->error($model,'tags', array('class'=>'help-inline error ge-ss')); ?>
</div>

<div class="form-actions">
	<button class="btn btn-primary" type="submit"><?php echo Yii::t('core',($model->isNewRecord ? 'Create' : 'Save')); ?></button>
</div>

<?php $this->endWidget(); ?>