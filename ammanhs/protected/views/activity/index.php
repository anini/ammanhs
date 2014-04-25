<?php
$this->breadcrumbs=array(
	Yii::t('core', 'Activities'),
);
$this->pageTitle=Yii::t('core', 'Activities').' - '.Yii::t('core', 'Amman Hackerspace');

$cs=Yii::app()->clientScript;
$cs->registerMetaTag(Yii::t('core', 'Activities').' - '.Yii::t('core', 'Amman Hackerspace'), 'twitter:title');
$cs->registerMetaTag(Yii::t('core', 'Activities').' - '.Yii::t('core', 'Amman Hackerspace') , 'og:title');
//$cs->registerMetaTag(strip_tags($model->content), 'description', null, array(), 'metadescription');
//$cs->registerMetaTag(strip_tags($model->content), 'twitter:description');
//$cs->registerMetaTag(strip_tags($model->content), 'og:description');
$cs->registerCSSFile('/css/activity.css?v=1.1');

$this->menu=array(
	array('label'=>'Create Activity', 'url'=>array('create')),
	array('label'=>'Manage Activity', 'url'=>array('admin')),
);
?>
<hr/>
<?php
foreach ($activities as $activity){
	$this->renderPartial('_view', array('model'=>$activity));
}
?>
