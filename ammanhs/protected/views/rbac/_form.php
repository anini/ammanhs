<div class="form">
	<?php
	$form=$this->beginWidget('CActiveForm', array(
		'id'=>'rbac-form',
		'enableAjaxValidation'=>false,
	)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username'); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'itemname'); ?>
		<?php echo CHtml::activeDropDownList($model, 'itemname', CHtml::listData(AuthItem::model()->findAll(), 'name', 'name')); ?>
		<?php echo $form->error($model,'itemname'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord?'Add':'Save'); ?>
	</div>

	<?php $this->endWidget(); ?>
</div><!-- form -->
