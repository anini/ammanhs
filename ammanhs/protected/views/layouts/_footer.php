<div class="clear"></div>
<div id="footer">
	<hr/>
	<div id="footer-links" class="ge-ss">
		<?php /*
		<div id="improve-link">
			<a onclick="open_contact_modal();">< ?php echo Yii::t('core', 'How can we improve this page?'); ? ></a>
		</div>
		*/ ?>
		<div>
			<a href="<?php echo Yii::app()->urlManager->createUrl('/site/about'); ?>"><?php echo Yii::t('core', 'About'); ?></a>
		</div>
		|
		<div>
			<a href="<?php echo Yii::app()->urlManager->createUrl('/membership/index'); ?>"><?php echo Yii::t('core', 'Memberships'); ?></a>
		</div>
		|
		<div>
			<a onclick="open_contact_modal();"><?php echo Yii::t('core', 'Contact Us'); ?></a>
		</div>
		|
		<div>
			<a onclick="open_contact_modal('suggest-activity');"><?php echo Yii::t('core', 'Suggest an activity'); ?></a>
		</div>
		<?php /*
		<div>
			<a target="_blank" rel="nofollow" href="http://eshtre.com/?ref=ammanhs">< ?php echo Yii::t('core', 'E-Store'); ? ></a>
		</div>
		*/ ?>
	</div>
	<div id="follow-us-footer">
	    <?php $this->renderPartial('//layouts/_social_buttons'); ?>
	</div>
	<?php /*
	<div id="sponsers">
		<a id="sponser-eshtre" target="_blank" rel="nofollow" href="http://eshtre.com/?ref=ammanhs"></a>
		<a id="sponser-jubilee" target="_blank" rel="nofollow" href="http://www.jubilee.edu.jo/"></a>
		<a id="sponser-sparkfun" target="_blank" href="http://www.sparkfun.com/"></a>
	</div>
	*/ ?>
	<div id="footer-bg"></div>
	<div class="copyrights">
		<?php echo Yii::t('core', 'Copy Rights - Arabic'); ?>
	</div>
	<div class="copyrights english-field">
		<?php echo Yii::t('core', 'Copy Rights - English'); ?>
	</div>
</div>