<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="row">
    <div class="span9">
        <div id="content">
            <?php echo $content; ?>
        </div><!-- content -->
    </div>
    <div class="span3" style="min-height: 200px;">
        <div id="sidebar">
            <?php $this->renderPartial('//layouts/_sidebar'); ?>
        </div><!-- sidebar -->
    </div>
</div>
<?php $this->endContent(); ?>