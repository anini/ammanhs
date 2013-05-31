<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ar" lang="ar" dir="rtl">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="language" content="ar" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="author" content="ammanhs.com">

		<script src="/js/jquery-1.9.1.min.js" type="text/javascript"></script>

		<?php $cs = Yii::app()->clientScript; ?>
		<?php $cs->registerCSSFile("/css/main.css"); ?>
		<?php $cs->registerCSSFile("/css/octicons.css"); ?>
		<?php $cs->registerCSSFile("/css/bootstrap/bootstrap.min.css"); ?>
		<?php $cs->registerCSSFile("/css/bootstrap/bootstrap-responsive.min.css"); ?>
		<?php $cs->registerCSSFile("/css/bootstrap/bootstrap-modal.min.css"); ?>
		
		<?php $cs->scriptMap = array(
			'jquery.js' => false,
			'jquery.min.js' => false,
			'jquery.yiilistview.js' => '/js/jquery.yiilistview.min.js',
			); ?>
		<?php $cs->registerScriptFile('/js/1.1.js', CClientScript::POS_END); ?>
		<?php $cs->registerScriptFile('/js/bootstrap/bootstrap.min.js', CClientScript::POS_END); ?>
		<?php $cs->registerScriptFile('/js/bootstrap/bootstrap-modal.min.js', CClientScript::POS_END); ?>
		<?php $cs->registerScriptFile('/js/bootstrap/bootstrap-modalmanager.min.js', CClientScript::POS_END); ?>
		<?php $cs->registerScriptFile('/js/bootstrap/common.js', CClientScript::POS_END); ?>

		<?php $this->dynamicPartial('//layouts/_global_variables');?>

		<title><?php echo CHtml::encode($this->pageTitle); ?></title>

	</head>

	<body>
		<div id="header">
		<?php $this->renderPartial('//layouts/_header'); ?>
		</div>
		<div class="container" id="page">
			<?php if(isset($this->breadcrumbs)):?>
				<?php $this->widget('zii.widgets.CBreadcrumbs', array(
					'links'=>$this->breadcrumbs,
				)); ?><!-- breadcrumbs -->
			<?php endif?>

			<?php $this->renderPartial('//layouts/_flash'); ?>

			<?php echo $content; ?>

			<?php $this->renderPartial('//layouts/_footer'); ?>
		</div><!-- page -->
	</body>
</html>