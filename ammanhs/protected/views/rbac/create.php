<?php
$this->pageTitle='Create Rbac';
$this->breadcrumbs=array(
	'Rbacs'=>array('index'),
	'Create',
);
?>

<h1>Create New AuthAssignment User</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>