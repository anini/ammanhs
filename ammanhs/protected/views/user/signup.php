<?php 
$input_class=(isset($input_class))?$input_class:'span3';
if(!isset($model)) $model=new User('signup');
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-signup-form',
	'action'=>'/signup',
	'htmlOptions'=>array(
		'class'=>'form-inline',
		'onsubmit'=>'return connect(this,'.((isset($callback_func))?'"'.$callback_func.'"':'false').','.((isset($attr))?'"'.$attr.'"':'false').','.((isset($redirect))?'"'.$redirect.'"':'false').');'
		)
	)); ?>
	<?php echo CHtml::hiddenField('input_class', $input_class); ?>
	<div class="control-group">
		<?php echo $form->textField($model,'username', array('class'=>$input_class, 'placeholder'=>Yii::t('core', 'Pick a Username'))); ?>
		<?php echo $form->error($model,'username', array('class'=>'help-inline error')); ?>
	</div>
	<div class="control-group">
		<?php echo $form->textField($model,'email', array('class'=>$input_class, 'placeholder'=>Yii::t('core', 'Your Email'))); ?>
		<?php echo $form->error($model,'email', array('class' => 'help-inline error')); ?>
	</div>
	<div class="control-group">
		<?php echo $form->passwordField($model,'password', array('class'=>$input_class, 'placeholder'=>Yii::t('core', 'Strong Password'))); ?>
		<?php echo $form->error($model,'password', array('class'=>'help-inline error')); ?>
	</div>
	<div class="control-group">
		<button class="btn btn-primary btn-block" type="submit"><?php echo Yii::t('core','Signup for Free!'); ?></button>
	</div>
<?php $this->endWidget(); ?>