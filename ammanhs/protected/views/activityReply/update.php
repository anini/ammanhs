<?php
$this->breadcrumbs=array(
	'Activity Replys'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ActivityReply','url'=>array('index')),
	array('label'=>'Create ActivityReply','url'=>array('create')),
	array('label'=>'View ActivityReply','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage ActivityReply','url'=>array('admin')),
);
?>

<h1>Update ActivityReply <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>