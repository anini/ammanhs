<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'tag-create-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name_ar'); ?>
		<?php echo $form->textField($model,'name_ar'); ?>
		<?php echo $form->error($model,'name_ar'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name_en'); ?>
		<?php echo $form->textField($model,'name_en'); ?>
		<?php echo $form->error($model,'name_en'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'stat_threads'); ?>
		<?php echo $form->textField($model,'stat_threads'); ?>
		<?php echo $form->error($model,'stat_threads'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->