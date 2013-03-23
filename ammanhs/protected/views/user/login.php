<?php if(!isset($login_form))
	$login_form = new LoginForm;
$form=$this->beginWidget('CActiveForm', array(
		'id'=>'user-login-form',
		'action'=>'/login',
		'htmlOptions'=>array(
			'class'=>'form-inline popup-form',
			'style'=>'float: right;',
			'onsubmit'=>'return connect(this'.((isset($callback_func))?',"'.$callback_func.'"':'').((isset($attr))?',"'.$attr.'"':'').');'
			)
		)); ?>
		<div class="control-group">
			<?php echo $form->textField($login_form,'username', array('placeholder' => 'Username or email')); ?>
			<?php echo $form->error($login_form,'username', array('class' => 'help-inline error')); ?>
		</div>
		<div class="control-group">
			<?php echo $form->passwordField($login_form,'password', array('placeholder' => 'Password')); ?>
			<?php echo $form->error($login_form,'password', array('class' => 'help-inline error')); ?>
		</div>
		<div class="control-group" style="margin-top: -10px;">
			<label class="checkbox" for="LoginForm_rememberMe">
				<input id="ytLoginForm_rememberMe" type="hidden" value="0" name="LoginForm[rememberMe]">
				<input name="LoginForm[rememberMe]" id="LoginForm_rememberMe" value="1" type="checkbox"><?php echo Yii::t('core','Remember Me'); ?>
				<span class="help-inline error" id="LoginForm_rememberMe_em_" style="display: none"></span>
			</label>
		</div>
		<button class="btn btn-primary" type="submit" style="width: 220px;"><?php echo Yii::t('core','Login'); ?></button>
<?php $this->endWidget(); ?>