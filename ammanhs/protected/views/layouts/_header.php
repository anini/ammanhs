<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
			<a href="/" class="brand">
				<img class="flash" style="margin: -9px 0 -5px 0;" src="/images/brand.png">
			</a>
			<?php $this->widget('bootstrap.widgets.TbMenu',array(
				'items'=>array(
					array('label'=>Yii::t('core','Home'), 'url'=>array('/site/index'), 'icon'=>'home'),
                	array('label'=>Yii::t('core','Threads'), 'url'=>array('/thread/index')),
                	array('label'=>Yii::t('core','About'), 'url'=>array('/site/page', 'view'=>'about')),
                	)
        		)
        	);?>
			<form class="navbar-search pull-left" action="">
				<input type="text" class="search-query span2" placeholder="<?php echo Yii::t('core','Search'); ?>" style="padding-right: 24px;"><i class='icon-search' style='margin: 2px -23px; opacity: 0.5;'></i>
			</form>
			<ul class="pull-right nav">
				<?php if (Yii::app()->user->isGuest) { ?>
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">
						<span id="signup-lable"><?php echo Yii::t('core','Signup for Free!'); ?></span>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li>
							<?php $model = new User('signup');
							$form=$this->beginWidget('CActiveForm', array(
									'id'=>'user-signup-form',
									'enableClientValidation'=>true,
									'action'=>'/user/signup',
									'clientOptions'=>array(
										'validateOnSubmit'=>true,
										),
									'htmlOptions'=>array(
										'class'=>'form-inline popup-form'
										)
									)); ?>

									<div class="control-group">
										<?php echo $form->textField($model,'username', array('placeholder' => 'Pick a Username')); ?>
										<?php echo $form->error($model,'username', array('class' => 'help-inline error')); ?>
									</div>
									<div class="control-group">
										<?php echo $form->textField($model,'email', array('placeholder' => 'Your Email')); ?>
										<?php echo $form->error($model,'email', array('class' => 'help-inline error')); ?>
									</div>
									<div class="control-group">
										<?php echo $form->passwordField($model,'password', array('placeholder' => 'Strong Password')); ?>
										<?php echo $form->error($model,'password', array('class' => 'help-inline error')); ?>
									</div>
									<button class="btn btn-primary" type="submit" name="yt0" style="width: 100%;">Signup</button>
							<?php $this->endWidget(); ?>
						</li>
					</ul>
				</li>
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo Yii::t('core','Login'); ?><span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li>
							<?php $model = new LoginForm;
							$form=$this->beginWidget('CActiveForm', array(
									'id'=>'user-login-form',
									'action'=>'/user/login',
									'enableClientValidation'=>true,
									'clientOptions'=>array(
										'validateOnSubmit'=>true,
										),
									'htmlOptions'=>array(
										'class'=>'form-inline popup-form'
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
									<button class="btn btn-primary" type="submit" name="yt0" style="width: 100%;"><?php echo Yii::t('core','Login'); ?></button>
							<?php $this->endWidget(); ?>
						</li>
					</ul>
				</li>
				<?php } else { ?>
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo  '<div style="margin: -9px 0; display: inline-block;">' .Yii::app()->user->model->avatar(32, 32, array('id'=>'header-avatar', 'title'=>'', 'data-original-title'=>'My profile')) . '</div><div style="margin: 0 7px; display: inline;">' . Yii::app()->user->model->name . '</div>'; ?><span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="/profile"><?php echo Yii::t('core','Profile'); ?></a></li>
						<li><a href="/settings"><?php echo Yii::t('core','Settings'); ?></a></li>
						<li class="divider"></li>
						<li><a href="/logout"><?php echo Yii::t('core','Logout'); ?></a></li>
					</ul>
				</li>
				<?php } ?>
			</ul>
		</div>
	</div>
</div>