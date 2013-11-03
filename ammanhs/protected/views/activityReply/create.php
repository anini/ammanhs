<?php
$this->breadcrumbs=array(
	'Activity Replys'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ActivityReply','url'=>array('index')),
	array('label'=>'Manage ActivityReply','url'=>array('admin')),
);
?>

<h1>Create ActivityReply</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>