<?php
$this->breadcrumbs=array(
	Yii::t('core', 'Memberships')=>array('index'),
	Yii::t('core', 'Create Membership'),
);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'user'=>$user)); ?>