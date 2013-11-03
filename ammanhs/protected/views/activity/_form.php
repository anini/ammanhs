<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'activity-form',
	'enableAjaxValidation'=>true,
	'htmlOptions'=>array(
        'enctype'=>'multipart/form-data',
        'class'=>'form-horizontal',
        'enableClientValidation'=>true
    ),
    'clientOptions'=>array(
    	'validateOnSubmit'=>true,
    ),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="control-group">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'content'); ?>
		<?php echo $form->markdownEditor($model, 'content', array('error'=>$form->error($model,'content', array('class'=>'help-inline error ge-ss', 'style'=>'float: left; margin-top:-30px;'))));?>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'date'); ?>
		<?php
		$this->widget('zii.widgets.jui.CJuiDatePicker', array(
			'name'=>'Activity[date]',
			'value'=>$model->date,
			'options'=>array(
				'showAnim'=>'fold'
			)
		));
		?>
		<?php echo $form->error($model,'date'); ?>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'tags'); ?>
		<?php echo $form->textField($model,'tags',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'tags'); ?>
	</div>

	<div class="form-actions">
		<button class="btn btn-primary" type="submit"><?php echo Yii::t('core',($model->isNewRecord ? 'Create' : 'Save')); ?></button>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->