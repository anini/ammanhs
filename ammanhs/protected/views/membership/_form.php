<?php
$this->renderPartial('membership_offers');
?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'membership-form',
	'enableAjaxValidation'=>false,
)); ?>

	<div class="control-group">
		<?php echo $form->labelEx($user,'mobile', array('class'=>'ge-ss')); ?>
		<?php echo $form->textField($user,'mobile',array('class'=>'english-field','maxlength'=>256)); ?>
		<?php echo $form->error($user,'mobile', array('class'=>'help-inline error ge-ss')); ?>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'type', array('class'=>'ge-ss')); ?>
		<?php echo CHtml::hiddenField('Membership[type]', $model->type, array('id'=>'membership-type')); ?>
		<div class="btn-group" data-toggle="buttons-radio" style="margin-bottom: 20px;">
			<button type="button" onclick="$('#membership-type').val('Free');" class="btn <?php if($model->type=='Free') echo 'active'; ?>">&nbsp<?php echo Yii::t('core', 'Free'); ?>&nbsp</button>
			<button type="button" onclick="$('#membership-type').val('Golden');" class="btn <?php if($model->type=='Golden') echo 'active'; ?>">&nbsp<?php echo Yii::t('core', 'Golden'); ?>&nbsp</button>
			<button type="button" onclick="$('#membership-type').val('Premium');" class="btn <?php if($model->type=='Premium') echo 'active'; ?>">&nbsp<?php echo Yii::t('core', 'Premium'); ?>&nbsp</button>
		</div>
		<?php echo $form->error($model,'type', array('class'=>'help-inline error ge-ss')); ?>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'organization', array('class'=>'ge-ss')); ?>
		<?php echo $form->textField($model,'organization',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'organization', array('class'=>'help-inline error ge-ss')); ?>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'title', array('class'=>'ge-ss')); ?>
		<?php echo $form->textField($model,'title',array('maxlength'=>256)); ?>
		<?php echo $form->error($model,'title', array('class'=>'help-inline error ge-ss')); ?>
	</div>

	<div class="form-actions">
	<button class="btn btn-primary" type="submit"><?php echo Yii::t('core',($model->isNewRecord ? 'Register' : 'Save')); ?></button>
</div>

<?php $this->endWidget(); ?>

</div><!-- form -->