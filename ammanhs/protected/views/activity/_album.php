<?php
$cs=Yii::app()->clientScript;
$cs->registerCSSFile('/css/gallery/blueimp-gallery.min.css?v=1.0');
$cs->registerScriptFile('/js/gallery/blueimp-gallery.min.js?v=1.2', CClientScript::POS_END);
?>

<hr/>

<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls">
    <div class="slides"></div>
    <h3 class="title"></h3>
    <a class="prev">‹</a>
    <a class="next">›</a>
    <a class="close">×</a>
    <a class="play-pause"></a>
    <ol class="indicator"></ol>
</div>

<div id="album" data-original-title="<?php echo Yii::t('core', 'Photos Album'); ?>">
    <?php foreach($photos as $photo){ ?>
    <a href="<?php echo Img::uri($photo->uri); ?>" <?php if($photo->caption){echo 'data-original-title="'.$photo->caption.'"';} ?> title="<?php echo ($photo->caption?$photo->caption:$activity_title); ?>" name="<?php echo ($photo->caption?$photo->caption:$activity_title); ?>">
        <?php
        $uri=explode('/album/', $photo->uri);
        $thumb=$uri[0].'/album/thumbnail/'.$uri[1];
        ?>
        <img src="<?php echo Img::uri($thumb); ?>" alt="<?php echo ($photo->caption?$photo->caption:$activity_title); ?>">
    </a> 
    <?php } ?>
</div>

<script>
document.getElementById('album').onclick=function(event){
    event=event||window.event;
    var target=event.target||event.srcElement,
        link=target.src ? target.parentNode : target,
        options={index:link, event:event},
        links=this.getElementsByTagName('a');
    blueimp.Gallery(links, options);
};
</script>