<?php
$this->breadcrumbs=array(
	'Profile'=>array('index'),
	'Settings',
);
$cs = Yii::app()->clientScript;
$cs->registerCSSFile("/css/bootstrap-fileupload.css");
$cs->registerScriptFile('/js/bootstrap-fileupload.js', CClientScript::POS_END);
$cs->registerScript("imageUpload", "$('.fileupload').fileupload({uploadtype: 'image'});", CClientScript::POS_END) ;
?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>true,
	'type'=>'horizontal',
	'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
    ),
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'email',array('class'=>'span5')); ?>

	<?php echo $form->radioButtonListRow($model,'gender',array('1'=>'Male','2'=>'Female'),array('separator'=>'')); ?>

	<?php echo $form->textFieldRow($model,'first_name',array('class'=>'span5', 'maxlength'=>64)); ?>

	<?php echo $form->textFieldRow($model,'last_name',array('class'=>'span5', 'maxlength'=>64)); ?>

	<?php echo $form->textFieldRow($model,'country',array('class'=>'span5', 'maxlength'=>64)); ?>

	<?php echo $form->textFieldRow($model,'twitter_uri',array('class'=>'span5', 'maxlength'=>64)); ?>

	<?php echo $form->textFieldRow($model,'facebook_uri',array('class'=>'span5', 'maxlength'=>128)); ?>

	<?php //echo $form->fileFieldRow($model,'avatar_uri',array('class'=>'span5')); ?>

	<!--<label class="control-label" for="User_avatar_uri">Avatar</label>-->
	<div class="fileupload fileupload-new" data-provides="fileupload" style="margin-left: 180px;">
		
		<div class="fileupload-preview thumbnail" style="width: 160px; height: 160px;">
			<?php echo $model->avatar(160, 160); ?>
		</div>
		<div>
			<span class="btn btn-file">
				<span class="fileupload-new">Select image</span>
				<span class="fileupload-exists">Change</span>
				<input name="User[avatar_uri]" id="User_avatar_uri" type="file"/>
			</span>
			<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
			<span class="help-inline error" id="User_avatar_uri_em_" style="display: none"></span>
		</div>
	</div>



	<?php echo $form->textAreaRow($model,'about',array('rows'=>6, 'cols'=>50, 'class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>