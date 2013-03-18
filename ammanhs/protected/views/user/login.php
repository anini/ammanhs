<?php if(!isset($model))
$model = new LoginForm;
$form=$this->beginWidget('CActiveForm', array(
		'id'=>'user-login-form',
		'action'=>'/login',
		'htmlOptions'=>array(
			'class'=>'form-inline popup-form',
			'onsubmit'=>'return connect(this);'
			)
		)); ?>
		<div class="control-group">
			<?php echo $form->textField($model,'username', array('placeholder' => 'Username or email')); ?>
			<?php echo $form->error($model,'username', array('class' => 'help-inline error')); ?>
		</div>
		<div class="control-group">
			<?php echo $form->passwordField($model,'password', array('placeholder' => 'Password')); ?>
			<?php echo $form->error($model,'password', array('class' => 'help-inline error')); ?>
		</div>
		<div class="control-group" style="margin-top: -10px;">
			<label class="checkbox" for="LoginForm_rememberMe">
				<input id="ytLoginForm_rememberMe" type="hidden" value="0" name="LoginForm[rememberMe]">
				<input name="LoginForm[rememberMe]" id="LoginForm_rememberMe" value="1" type="checkbox"><?php echo Yii::t('core','Remember Me'); ?>
				<span class="help-inline error" id="LoginForm_rememberMe_em_" style="display: none"></span>
			</label>
		</div>
		<button class="btn btn-block btn-primary" type="submit"><?php echo Yii::t('core','Login'); ?></button>
<?php $this->endWidget(); ?>