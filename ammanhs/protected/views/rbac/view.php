<?php
$this->pageTitle='View Rbac';
$this->breadcrumbs=array(
	'Rbacs'=>array('index'),
	$model->id,
);
?>

<h1>View Rbac #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'userid',
		'itemname',
		),
	));?>