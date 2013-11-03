<?php
$this->breadcrumbs=array(
	'Activities'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Activity', 'url'=>array('index')),
	array('label'=>'Create Activity', 'url'=>array('create')),
	array('label'=>'View Activity', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Activity', 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('core', 'Update Activity'); ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>