<?php
$this->pageTitle=Yii::t('core', 'The page you requested is not available');
$this->breadcrumbs=array(
	Yii::t('core', 'Non-existent Page'),
);
?>
<div id="error-404" class="row ge-ss">
	<div class="span7">
		<h2><icon class='octicons octicon-alert'></icon><?php echo Yii::t('core', 'The page you requested is not available'); ?></h2>
		<?php echo Yii::t('core', 'You can get back to the main page, or you can search threads:'); ?>
		<form class="navbar-search" action="/search">
	        <input name="q" type="text" class="search-query span4" placeholder="<?php echo Yii::t('core','Search'); ?>"
	        ><span class="octicons octicon-search search-icon"></span>
	    </form>
	</div>
	<div class="span5">
		<img src="/images/404.png" />
	</div>
</div>