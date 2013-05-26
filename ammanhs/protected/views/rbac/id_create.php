<?php
$this->pageTitle='Create Rbac';
$this->breadcrumbs=array(
	'Rbacs'=>array('index'),
	'Create',
);
?>

<h1>Create New AuthAssignment User - userID</h1>

<?php echo $this->renderPartial('_id_form', array('model'=>$model)); ?>
