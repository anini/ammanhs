<?php
$this->pageTitle=Yii::t('core', 'Amman Hackerspace').' - '.Yii::t('core', 'Memberships');
$this->breadcrumbs=array(
	Yii::t('core', 'Memberships'),
);
Yii::app()->clientScript->registerScriptFile('/js/membership.js', CClientScript::POS_END);
Yii::app()->clientScript->registerCSSFile('/css/membership.css');

if(!Yii::app()->user->isGuest && $membership=Yii::app()->user->model->membership){
	$this->renderPartial('_view', array('model'=>$membership, 'user'=>$membership->user));
}else{
	$this->renderPartial('_offers');
}
?>