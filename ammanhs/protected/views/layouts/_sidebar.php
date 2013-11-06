<?php if(Yii::app()->user->isGuest){ ?>
	<div id="join-ammanhs" class="row ge-ss">
		<div id="join-ammanhs-title" class="span3">
			<?php echo Yii::t('core', 'Join Amman Hackerspace'); ?>
			<div><?php echo Yii::t('core', 'Or login to your account', array(':on_click'=>'$("#join-ammanhs").fadeOut("fast", function(){$("#login-ammanhs").fadeIn("slow");});')); ?></div>
		</div>
		<div class="span3"><?php $this->renderPartial('//user/signup'); ?></div>
	</div>
	<div id="login-ammanhs" class="row ge-ss">
		<div id="login-ammanhs-title">
			<?php echo Yii::t('core', 'Welcome back!'); ?>
		</div>
		<div class="span3"><?php $this->renderPartial('//user/login'); ?></div>
		<div id="login-ammanhs-title"><a onclick="$('#login-ammanhs').fadeOut('fast', function(){$('#join-ammanhs').fadeIn('slow');});"><?php echo Yii::t('core', 'Create new account'); ?></a></div>
	</div>
	<hr/>
<?php } ?>
<div class="row ge-ss">
	<div id="ammahs-sidebar-guide" class="span3">
		<div><?php echo Yii::t('core', 'What to do in Amman Hackerspace?'); ?></div>
		<a class="btn btn-primary add-thread-button btn-block" href="<?php echo $this->createUrl('thread/index'); ?>"><icon class="octicons octicon-repo"></icon><?php echo Yii::t('core', 'Browse Threads'); ?></a>
		<a class="btn btn-success add-thread-button btn-block" href="<?php echo $this->createUrl('thread/create'); ?>"><icon class="octicons octicon-repo-create"></icon><?php echo Yii::t('core', 'Create a New Thread'); ?></a>
		<a class="btn btn-warning add-thread-button btn-block" href="<?php echo $this->createUrl('user/profile'); ?>"><icon class="octicons octicon-tools"></icon><?php echo Yii::t('core', 'Edit your profile'); ?></a>
		<a class="btn btn-danger add-thread-button btn-block" href="<?php echo $this->createUrl('membership/index'); ?>"><icon class="octicons octicon-credit-card"></icon><?php echo Yii::t('core', ((Yii::app()->user->model->membership)?'Edit':'Create').' Membership'); ?></a>
	</div>
</div>

<div id="follow-us">
    <?php $this->renderPartial('//layouts/_social_buttons'); ?>
</div>