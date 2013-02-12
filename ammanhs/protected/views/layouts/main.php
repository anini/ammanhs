<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="language" content="en" />

	    <link rel="stylesheet" type="text/css" href="/css/main.css" />

		<title><?php echo CHtml::encode($this->pageTitle); ?></title>
		
		<?php Yii::app()->clientScript->registerScriptFile('/js/1.1.js', CClientScript::POS_END); ?>
	</head>

	<body>
		<?php $this->renderPartial('//layouts/_header'); ?>

		<div class="container" id="page">
			<?php if(isset($this->breadcrumbs)):?>
				<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
					'links'=>$this->breadcrumbs,
				)); ?><!-- breadcrumbs -->
			<?php endif?>

			<?php $this->renderPartial('//layouts/_flash'); ?>

			<?php echo $content; ?>

			<?php $this->renderPartial('//layouts/_footer'); ?>
		</div><!-- page -->
	</body>
</html>