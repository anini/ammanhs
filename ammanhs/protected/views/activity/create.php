<?php
$this->breadcrumbs=array(
	Yii::t('core', 'Activities')=>array('index'),
	Yii::t('core', 'Create Activity'),
);

$this->menu=array(
	array('label'=>'List Activity', 'url'=>array('index')),
	array('label'=>'Manage Activity', 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('core', 'Create Activity'); ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>