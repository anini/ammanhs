<?php
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('core', 'Contact Us');
$this->breadcrumbs=array(
	Yii::t('core', 'Contact Us'),
);
?>

<h1><?php echo Yii::t('core', 'Contact Us') ?></h1>

<?php if(Yii::app()->user->hasFlash('contact')): ?>

<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('contact'); ?>
</div>

<?php else: ?>

<p>
If you have business inquiries or other questions, please fill out the following form to contact us. Thank you.
</p>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'contact-form',
	'enableAjaxValidation'=>true,
	'htmlOptions'=>array(
        'enctype'=>'multipart/form-data',
        'class'=>'form-horizontal',
        'enableClientValidation'=>true
    ),
)); ?>

<div class="form-inline">
	<div class="control-group">
		<?php echo $form->labelEx($model,'name'); ?>
		<div class="controls">
		<?php echo $form->textField($model,'name'); ?>
		<?php echo $form->error($model,'name'); ?>
		</div>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'email'); ?>
		<div class="controls">
		<?php echo $form->textField($model,'email'); ?>
		<?php echo $form->error($model,'email'); ?>
		</div>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'subject'); ?>
		<div class="controls">
		<?php echo $form->textField($model,'subject',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'subject'); ?>
		</div>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'body'); ?>
		<div class="controls">
		<?php echo $form->textArea($model,'body',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'body'); ?>
		</div>
	</div>

	<?php if(CCaptcha::checkRequirements()): ?>
	<div class="control-group">
		<?php echo $form->labelEx($model,'verifyCode'); ?>
		<div>
		<?php $this->widget('CCaptcha'); ?>
		<?php echo $form->textField($model,'verifyCode'); ?>
		</div>
		<div class="hint">Please enter the letters as they are shown in the image above.
		<br/>Letters are not case-sensitive.</div>
		<?php echo $form->error($model,'verifyCode'); ?>
	</div>
	<?php endif; ?>

	<div class="form-actions">
		<button class="btn btn-primary" type="submit"><?php echo Yii::t('core','Submit'); ?></button>
	</div>
</div>

<?php $this->endWidget(); ?>


<?php endif; ?>