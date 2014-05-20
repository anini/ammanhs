<?php
$this->pageTitle=Yii::t('core', 'Amman Hackerspace').' - '.Yii::t('core', 'Search results fot :q', array(':q'=>$_GET['q']));
$this->breadcrumbs=array(
	Yii::t('core','Search'),
);?>
<div class="row">
	<div class="span9">
<form class="navbar-search" action="/search">
        <input name="q" type="text" class="search-query span4" placeholder="<?php echo Yii::t('core','Search'); ?>"
        ><span class='octicons octicon-search' style='margin-right: -22px;opacity: 0.5;position: absolute;margin-top: 7px'></span>
      </form>
  </div>
</div>