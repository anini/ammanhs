<?php
$this->pageTitle=Yii::t('core', 'Amman Hackerspace').' - '.Yii::t('core', 'Adding New Thread');
$this->breadcrumbs=array(
	Yii::t('core', 'Threads')=>array('index'),
	Yii::t('core', 'Adding New Thread'),
);

$this->menu=array(
	array('label'=>'List Thread','url'=>array('index')),
	array('label'=>'Manage Thread','url'=>array('admin')),
);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>