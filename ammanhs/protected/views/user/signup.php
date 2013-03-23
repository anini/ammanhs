<?php 
if(!isset($model))
	$model = new User('signup');
$form=$this->beginWidget('CActiveForm', array(
		'id'=>'user-signup-form',
		'action'=>'/signup',
		'htmlOptions'=>array(
			'class'=>'form-inline popup-form',
			'style'=>'float: right;',
			'onsubmit'=>'return connect(this'.((isset($callback_func))?',"'.$callback_func.'"':'').((isset($attr))?',"'.$attr.'"':'').');'
			)
		)); ?>
		<div class="control-group">
			<?php echo $form->textField($model,'username', array('placeholder' => Yii::t('core', 'Pick a Username'))); ?>
			<?php echo $form->error($model,'username', array('class' => 'help-inline error')); ?>
		</div>
		<div class="control-group">
			<?php echo $form->textField($model,'email', array('placeholder' => Yii::t('core', 'Your Email'))); ?>
			<?php echo $form->error($model,'email', array('class' => 'help-inline error')); ?>
		</div>
		<div class="control-group">
			<?php echo $form->passwordField($model,'password', array('placeholder' => Yii::t('core', 'Strong Password'))); ?>
			<?php echo $form->error($model,'password', array('class' => 'help-inline error')); ?>
		</div>
		<button class="btn btn-primary" type="submit" style="width: 220px;"><?php echo Yii::t('core','Signup for Free!'); ?></button>
<?php $this->endWidget(); ?>