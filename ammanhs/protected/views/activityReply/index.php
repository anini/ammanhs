<?php
$this->breadcrumbs=array(
	'Activity Replys',
);

$this->menu=array(
	array('label'=>'Create ActivityReply','url'=>array('create')),
	array('label'=>'Manage ActivityReply','url'=>array('admin')),
);
?>

<h1>Activity Replys</h1>

<?php $this->widget('zii.widgets.CListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
