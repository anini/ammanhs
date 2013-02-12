<?php
$this->breadcrumbs=array(
	'Threads'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Thread','url'=>array('index')),
	array('label'=>'Create Thread','url'=>array('create')),
	array('label'=>'View Thread','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Thread','url'=>array('admin')),
);
?>

<h1>Update Thread <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>