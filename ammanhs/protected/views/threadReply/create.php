<?php
$this->breadcrumbs=array(
	'Thread Replys'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ThreadReply','url'=>array('index')),
	array('label'=>'Manage ThreadReply','url'=>array('admin')),
);
?>

<h1>Create ThreadReply</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>