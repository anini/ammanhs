<?php
$this->breadcrumbs=array(
    Yii::t('core', 'Activities')=>array('index'),
    $model->title=>$model->link,
    Yii::t('core', 'Cover Photo'),
);

$cs=Yii::app()->clientScript;
$cs->registerCSSFile("/css/fileupload.css?v=2.1");
$cs->registerScriptFile('/js/fileupload.js?v=1.1', CClientScript::POS_END);
$cs->registerScript("imageUpload", "$('.fileupload').fileupload({uploadtype: 'image'});", CClientScript::POS_END);
?>

<div class="row">
    <div class="span7">
        <h1><?php echo Yii::t('core', 'Update Cover Photo'); ?></h1>
    </div>
    <div class="span2">
        <a style="float: left" href="<?php echo $this->createUrl('activity/updateAlbum', array('id'=>$model->id)); ?>"><h4 style="line-height: 40px"><?php echo Yii::t('core', 'skip'); ?></h4></a>
    </div>
</div>
<br>

<?php $form=$this->beginWidget('CActiveForm', array(
    'htmlOptions'=>array(
        'enctype'=>'multipart/form-data',
    ),
)); ?>
    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->textField($model,'title',array('style'=>'display: none')); ?>

    <div class="control-group">
        <div class="fileupload fileupload-new" data-provides="fileupload">
            <div class="fileupload-preview thumbnail" style="width:100%">
                <?php echo $model->photo(900, 320, false); ?>
            </div>
            <div class="uploader-btns">
                <span class="btn btn-file">
                    <span class="fileupload-new"><?php echo Yii::t('core', $model->photo_uri?'Change the image':'Select image'); ?></span>
                    <span class="fileupload-exists"><?php echo Yii::t('core', 'Change the image'); ?></span>
                    <?php echo $form->fileField($model, 'photo_uri') ?>
                </span>
                <button type="submit" class="btn btn-success hide" id="submit-image">
                    <?php echo Yii::t('core', 'Upload'); ?>
                </button>
                <span class="help-inline error" id="Activity_photo_uri_em_" style="display: none"></span>
            </div>
        </div>
    </div>
<?php $this->endWidget(); ?>






