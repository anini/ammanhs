<div class="clear"></div>
<div id="footer">
	<hr/>
	<div id="footer-links" class="ge-ss">
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
		<!--|
		<div>
			<a target="_blank" rel="nofollow" href="http://eshtre.com/?ref=ammanhs"><?php echo Yii::t('core', 'E-Store'); ?></a>
		</div>
		-->
		<div id="follow-us-footer">
		    <div class="social-buttons-title"><?php echo Yii::t('core', 'Follow us:'); ?></div>
		    <div class="social-buttons">
		        <a class="facebook-button" target="_blank" rel="nofollow" href="http://facebook.com/ammanhackerspace"></a>
		        <a class="twitter-button" target="_blank" rel="nofollow" href="http://twitter.com/ammanhs"></a>
		        <a class="google-button" target="_blank" rel="nofollow" href="https://plus.google.com/105524057604428756913/"></a>
		    </div>
		</div>
	</div>
	<div id="sponsers">
		<a id="sponser-eshtre" target="_blank" rel="nofollow" href="http://eshtre.com/?ref=ammanhs"></a>
		<a id="sponser-jubilee" target="_blank" rel="nofollow" href="http://www.jubilee.edu.jo/"></a>
		<!--<a id="sponser-sparkfun" target="_blank" href="http://www.sparkfun.com/"></a>-->
	</div>
	<div id="footer-bg"></div>
	<div class="copyrights">
		<?php echo Yii::t('core', 'Copy Rights - Arabic'); ?>.
	</div>
	<div class="copyrights english-field">
		<?php echo Yii::t('core', 'Copy Rights - English'); ?>.
	</div>
</div>