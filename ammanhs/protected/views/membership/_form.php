<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'membership-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array(
		'enctype'=>'multipart/form-data',
		'class'=>'form-horizontal inline-form',
		'style'=>'margin-bottom: 0;',
		'enableClientValidation'=>true,
		'onSubmit'=>"submit_ajax(this, '.modal'); return false;",
		),
)); ?>

	<div class="control-group">
		<?php echo $form->labelEx($user,'mobile'); ?>
		<?php echo $form->textField($user,'mobile',array('class'=>'english-field','maxlength'=>256, 'class'=>'span12')); ?>
		<?php echo $form->error($user,'mobile', array('class'=>'help-inline error ge-ss')); ?>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo CHtml::hiddenField('Membership[type]', $model->type, array('id'=>'membership-type')); ?>
		<div class="btn-group span12" data-toggle="buttons-radio" style="margin-right: 0;">
			<button type="button" style="width: 30%;" onclick="switch_privileges('free'); $('#membership-type').val('Free');" class="btn <?php if($model->type=='Free') echo 'active'; ?>"><?php echo Yii::t('core', 'Free'); ?></button>
			<button type="button" style="width: 30%;" onclick="switch_privileges('golden'); $('#membership-type').val('Golden');" class="btn <?php if($model->type=='Golden') echo 'active'; ?>"><?php echo Yii::t('core', 'Golden'); ?></button>
			<button type="button" style="width: 40%;" onclick="switch_privileges('premium'); $('#membership-type').val('Premium');" class="btn <?php if($model->type=='Premium') echo 'active'; ?>"><?php echo Yii::t('core', 'Premium'); ?></button>
		</div>
		<?php echo $form->error($model,'type', array('class'=>'help-inline error ge-ss')); ?>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'organization'); ?>
		<?php echo $form->textField($model,'organization',array('size'=>60,'maxlength'=>256, 'class'=>'span12')); ?>
		<?php echo $form->error($model,'organization', array('class'=>'help-inline error ge-ss')); ?>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('maxlength'=>256, 'class'=>'span12')); ?>
		<?php echo $form->error($model,'title', array('class'=>'help-inline error ge-ss')); ?>
	</div>

	<div class="form-actions">
		<button class="btn btn-primary" type="submit"><?php echo Yii::t('core',($model->isNewRecord ? 'Register' : 'Save')); ?></button>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->