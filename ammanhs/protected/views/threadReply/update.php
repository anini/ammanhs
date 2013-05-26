<?php
$this->breadcrumbs=array(
	'Thread Replys'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ThreadReply','url'=>array('index')),
	array('label'=>'Create ThreadReply','url'=>array('create')),
	array('label'=>'View ThreadReply','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage ThreadReply','url'=>array('admin')),
);
?>

<h1>Update ThreadReply <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>