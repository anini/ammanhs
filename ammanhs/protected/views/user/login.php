<?php
$input_class=(isset($input_class))?$input_class:'span3';
if(!isset($login_form)) $login_form=new LoginForm;
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-login-form',
	'action'=>'/login',
	'htmlOptions'=>array(
		'class'=>'form-inline',
		'onsubmit'=>'return connect(this,'.((isset($callback_func))?'"'.$callback_func.'"':'false').','.((isset($attr))?'"'.$attr.'"':'false').','.((isset($redirect))?'"'.$redirect.'"':'false').');'
		)
	)); ?>
	<?php echo CHtml::hiddenField('input_class', $input_class); ?>
	<div class="control-group">
		<?php echo $form->textField($login_form,'username', array('class'=>$input_class, 'placeholder'=>Yii::t('core', 'Username or email'))); ?>
		<?php echo $form->error($login_form,'username', array('class'=>'help-inline error')); ?>
	</div>
	<div class="control-group">
		<?php echo $form->passwordField($login_form,'password', array('class'=>$input_class, 'placeholder'=>Yii::t('core', 'Password'))); ?>
		<?php echo $form->error($login_form,'password', array('class'=>'help-inline error')); ?>
	</div>
	<div class="control-group ge-ss">
		<label class="checkbox" for="LoginForm_rememberMe">
			<input id="ytLoginForm_rememberMe" type="hidden" value="0" name="LoginForm[rememberMe]">
			<input name="LoginForm[rememberMe]" id="LoginForm_rememberMe" value="1" type="checkbox"><?php echo Yii::t('core','Remember Me'); ?>
			<span class="help-inline error" id="LoginForm_rememberMe_em_" style="display: none"></span>
		</label>
	</div>
	<div class="control-group">
		<button class="btn btn-primary btn-block" type="submit"><?php echo Yii::t('core','Login'); ?></button>
	</div>
<?php $this->endWidget(); ?>