<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container">
      <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <div>
      <a class="brand" href="<?php echo Yii::app()->urlManager->createUrl('site/index'); ?>">

		<img class="flash" style="margin: -9px 0 -5px 0;" src="/images/brand_ar.png">
    </a>
      <form class="navbar-search" action="/search">
        <input name="q" <?php if(isset($_GET['q']) && (is_string($_GET['q'])||is_numeric($_GET['q']))) echo 'value="'.htmlentities($_GET['q'], ENT_QUOTES, 'UTF-8').'"'; ?> type="text" class="search-query span2" placeholder="<?php echo Yii::t('core','Search'); ?>" id="header-search" 
        onfocus="$('#main-menu').slideUp(200);setTimeout(function(){$('#header-search').removeClass('span2');$('#header-search').addClass('span4');}, 250);" onblur="$(this).removeClass('span4');$(this).addClass('span2');setTimeout(function(){$('#main-menu').slideDown(200);}, 500);"><span class='octicons octicon-search'></span>
      </form>
    
     </div>
      <div class="nav-collapse collapse">
        <ul class="nav" id="main-menu">
          <li <?php if($this->action->controller->id=='site' && $this->action->id=='index') echo 'class="active"'; ?>><a href="<?php echo Yii::app()->urlManager->createUrl('site/index'); ?>"><?php echo Yii::t('core','Home'); ?></a></li>
          <li <?php if($this->action->controller->id=='thread' && $this->action->id=='index') echo 'class="active"'; ?>><a href="<?php echo Yii::app()->urlManager->createUrl('/thread/index'); ?>"><?php echo Yii::t('core','Threads'); ?></a></li>
          <li <?php if($this->action->controller->id=='activity') echo 'class="active"'; ?>><a href="<?php echo Yii::app()->urlManager->createUrl('/activity/index'); ?>"><?php echo Yii::t('core','Activities'); ?></a></li>
          <li <?php if($this->action->controller->id=='site' && $this->action->id=='about') echo 'class="active"'; ?>><a href="<?php echo Yii::app()->urlManager->createUrl('/site/about'); ?>"><?php echo Yii::t('core','About'); ?></a></li>
        </ul>
        <?php $this->renderPartial('//layouts/_user_header'); ?>
      </div><!--/.nav-collapse -->
      <ul class="nav">
        
    </ul>
    </div>
  </div>
</div>