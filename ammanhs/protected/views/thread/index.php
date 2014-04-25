<?php
$this->pageTitle=Yii::t('core', 'Threads').' - '.Yii::t('core', 'Amman Hackerspace');
$this->breadcrumbs=array(
    Yii::t('core', 'Threads'),
);
Yii::app()->clientScript->registerScript("threads-type", "var type = '{$type}';", CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/js/thread.js?v=1.3', CClientScript::POS_END);
Yii::app()->clientScript->registerCSSFile('/css/thread.css?v=3.5');
?>

<div class="ge-ss">
    <ul class="nav nav-tabs">
        <li id="me-tab" onclick="switch_threads_tab(1)">
            <a data-toggle="tab" href="#me"><?php echo Yii::t('core', 'My Threads'); ?></a>
        </li>
        <li id="top-tab" onclick="switch_threads_tab(2)">
            <a data-toggle="tab" href="#top"><?php echo Yii::t('core', 'Top Threads'); ?></a>
        </li>
        <li id="recent-tab" onclick="switch_threads_tab(3)" class="active">
            <a data-toggle="tab" href="#recent"><?php echo Yii::t('core', 'Recent Threads'); ?></a>
        </li>
    </ul>
    <div class="tab-content">
        <div id="me-tab-label" class="tab-pane"><?php echo Yii::t('core', 'My Threads'); ?></div>
        <div id="top-tab-label" class="tab-pane"><?php echo Yii::t('core', 'Top Threads'); ?></div>
        <div id="recent-tab-label" class="tab-pane active"><?php echo Yii::t('core', 'Recent Threads'); ?></div>
    </div>
</div>

<div id="threads-container">
    <?php $this->renderPartial('_threads', array('threads'=>$threads, 'type'=>$type)); ?>
</div>