<?php
/* @var $this SiteController */
$this->pageTitle=Yii::app()->name;
$cs=Yii::app()->clientScript;
$cs->registerCSSFile("/css/home.css");
?>

<div class="hero-unit ge-ss" id="welcome-box">
  <h1><?php echo Yii::t('core', 'Amman Hackerspace'); ?></h1>
  <h2><?php echo Yii::t('core', 'slogan'); ?></h2>
  <br/>
  <p>
    <a class="btn btn-primary btn-large" href="<?php echo $this->createUrl('site/about'); ?>"><?php echo Yii::t('core', 'About'); ?>؟</a>
  </p>
  <img alt="" class="gear" id="gear-1" src="/images/gears/gear-1.png">
  <img alt="" class="gear" id="gear-2" src="/images/gears/gear-2.png">
  <img alt="" class="gear" id="gear-3" src="/images/gears/gear-3.png">
  <img alt="" class="gear" id="gear-4" src="/images/gears/gear-3.png">
</div>