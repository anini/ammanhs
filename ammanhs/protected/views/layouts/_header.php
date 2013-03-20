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
      <form class="navbar-search" action="">
        <input type="text" class="search-query span2" placeholder="<?php echo Yii::t('core','Search'); ?>" id="header-search" 
        onfocus="$('#main-menu').slideUp(200);$(this).removeClass('span2');$(this).addClass('span4');" onblur="$(this).removeClass('span4');$(this).addClass('span2');setTimeout(function(){$('#main-menu').slideDown(200);}, 500);"><i class='icon-search' style='margin: 2px -23px; opacity: 0.5;'></i>
      </form>
    
     </div>
      <div class="nav-collapse collapse">
        <ul class="nav" id="main-menu">
          <li class="active"><a href="<?php echo Yii::app()->urlManager->createUrl('site/index'); ?>"><?php echo Yii::t('core','Home'); ?></a></li>
          <li><a href="<?php echo Yii::app()->urlManager->createUrl('/thread/index'); ?>"><?php echo Yii::t('core','Threads'); ?></a></li>
          <li><a href="<?php echo Yii::app()->urlManager->createUrl('/site/about'); ?>"><?php echo Yii::t('core','About'); ?></a></li>
        </ul>
        <?php $this->renderPartial('//layouts/_user_header'); ?>
      </div><!--/.nav-collapse -->
      <ul class="nav">
        
    </ul>
    </div>
  </div>
</div>