<?php
$this->breadcrumbs=array(
	'Threads',
);
Yii::app()->clientScript->registerScriptFile('/js/thread.js', CClientScript::POS_END);
Yii::app()->clientScript->registerCSSFile('/css/thread.css');
?>

<?php $this->widget('bootstrap.widgets.TbTabs', array(
    'type'=>'tabs',
    'tabs'=>array(
        array('label'=>'My Threads', 'content'=>'My Threads', 'htmlOptions'=>array('onclick'=>'function(){alert("banana");}')),
        array('label'=>'Top Threads', 'content'=>'Top Threads'),
        array('label'=>'Recent Threads', 'content'=>'Recent Threads', 'active'=>true),
        ),
    'events'=>array('shown'=>'js:switch_threads_tab'),
    'htmlOptions'=>array('onclick'=>'slide_up_threads_container();'),
)); ?>

<div id="threads-container">
    <?php $this->renderPartial('_threads', array('threads'=>$threads)); ?>
</div>