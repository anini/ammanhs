<?php
$this->pageTitle='Update Rbac';
$this->breadcrumbs=array(
	'Rbacs'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);
?>

<h1>Update Rbac for <?php echo $model->user->username; ?></h1>

<?php echo $this->renderPartial('_formauth', array('model'=>$model)); ?>