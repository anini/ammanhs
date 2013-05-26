<?php
$this->breadcrumbs=array(
	'Thread Replys',
);

$this->menu=array(
	array('label'=>'Create ThreadReply','url'=>array('create')),
	array('label'=>'Manage ThreadReply','url'=>array('admin')),
);
?>

<h1>Thread Replys</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
