<ul class="nav pull-left" id="user-header">
	<?php if (Yii::app()->user->isGuest) { ?>
	<li class="dropdown">
		<a class="dropdown-toggle" data-toggle="dropdown" href="#signup"><span id="signup-lable"><?php echo Yii::t('core','Signup for Free!'); ?></span><span class="caret"></span></a>
		<ul class="dropdown-menu">
			<li><?php $this->renderPartial('//user/signup'); ?></li>
		</ul>
	</li>
	<li class="dropdown">
		<a class="dropdown-toggle" data-toggle="dropdown" href="#login"><?php echo Yii::t('core','Login'); ?><span class="caret"></span></a>
		<ul class="dropdown-menu">
			<li><?php $this->renderPartial('//user/login'); ?></li>
		</ul>
	</li>
	<a href="javascript:void(0);" data-src="/user/connect" id="connect-link" data-toggle="ajax-modal"></a>
    <?php } else { ?>
	<?php echo Yii::app()->user->model->avatar_a(32, 32, array('id'=>'header-avatar', 'title'=>''), array(), 'float: right;'); ?>
	<a href="/settings" class="octicons octicon-settings user-icons" data-original-title="<?php echo Yii::t('core','Settings'); ?>"></a>
	<a href="/logout" class="octicons octicon-exit user-icons" data-original-title="<?php echo Yii::t('core','Logout'); ?>"></a>
	<?php } ?>
</ul>
