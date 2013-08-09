<?php
$this->pageTitle=Yii::t('core', 'Amman Hackerspace').' - '.Yii::t('core', 'Settings');
$this->breadcrumbs=array(
	Yii::t('core', 'Profile')=>array($this->createUrl('user/view', array('id'=>Yii::app()->user->id))),
	Yii::t('core', 'Settings'),
);
$cs=Yii::app()->clientScript;
$cs->registerCSSFile("/css/fileupload.css");
$cs->registerCSSFile("/css/user.css");
$cs->registerScriptFile('/js/user.js', CClientScript::POS_END);
$cs->registerScriptFile('/js/fileupload.js', CClientScript::POS_END);
$cs->registerScript("imageUpload", "$('.fileupload').fileupload({uploadtype: 'image'});", CClientScript::POS_END) ;
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>true,
	'htmlOptions'=>array(
        'enctype'=>'multipart/form-data',
        'class'=>'form-horizontal',
        'enableClientValidation'=>true
    ),
    'clientOptions'=>array(
    	'validateOnSubmit'=>true,
    ),
)); ?>

<?php echo $form->errorSummary($model, '<button type="button" class="close" data-dismiss="alert">&times;</button>', null, array('class'=>'alert alert-error')); ?>

<div class="control-group">
	<div class="form-inline">
		<div class="row">
			<div class="span2">
				<div class="fileupload fileupload-new" data-provides="fileupload">
					<div class="fileupload-preview thumbnail" class="span2">
						<?php echo $model->avatar(160, 160, false); ?>
					</div>
					<div class="uploader-btns">
						<span class="btn btn-file">
							<span class="fileupload-new"><?php echo Yii::t('core', $model->avatar_uri?'Change the image':'Select image'); ?></span>
							<span class="fileupload-exists"><?php echo Yii::t('core', 'Change the image'); ?></span>
							<input name="User[avatar_uri]" id="User_avatar_uri" type="file"/>
						</span>
						<span class="help-inline error" id="User_avatar_uri_em_" style="display: none"></span>
					</div>
				</div>
			</div>
			<div class="span7">
				<div class="control-group">
					<?php echo $form->textField($model,'first_name', array('style'=>'max-width: 119px;', 'placeholder'=>Yii::t('core', 'First Name'))); ?>
					<?php echo $form->textField($model,'last_name', array('style'=>'max-width: 119px;', 'placeholder'=>Yii::t('core', 'Last Name'))); ?>
					
					<?php echo $form->error($model,'first_name'); ?>
					<?php echo $form->error($model,'last_name'); ?>
					<a class="btn pull-left" onclick="return open_change_password_modal();"><icon class="octicons octicon-edit">&nbsp</icon><?php echo Yii::t('core', 'Change Password'); ?></a>
				</div>
				<div class="control-group">
					<?php echo $form->textField($model,'email', array('class'=>'span3 english-field', 'placeholder'=>Yii::t('core', 'Email'))); ?>
					<span class="help-inline"><?php echo $form->error($model,'email'); ?></span>
				</div>
				<div class="control-group">
					<?php echo $form->textField($model,'country', array('class'=>'span3', 'placeholder'=>Yii::t('core', 'Country'))); ?>
					<?php echo $form->error($model,'country'); ?>
				</div>
				<?php echo CHtml::hiddenField('User[gender]', $model->gender, array('id'=>'gender')); ?>
				<div class="btn-group" data-toggle="buttons-radio">
					<button type="button" onclick="$('#gender').val(1);" class="btn <?php if($model->gender==1) echo 'active'; ?>"><?php echo Yii::t('core', 'Male'); ?></button>
					<button type="button" onclick="$('#gender').val(2);" class="btn <?php if($model->gender==2) echo 'active'; ?>"><?php echo Yii::t('core', 'Female'); ?></button>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="control-group">
	<?php echo $form->labelEx($model,'mobile', array('class'=>'control-label')); ?>
	<div class="controls">
		<?php echo $form->textField($model, 'mobile', array('class'=>'english-field')); ?>
		<?php echo $form->error($model,'mobile'); ?>
	</div>
</div>

<div class="control-group">
	<?php echo $form->labelEx($model,'website', array('class'=>'control-label')); ?>
	<div class="controls">
		<?php echo $form->textField($model, 'website', array('class'=>'english-field', 'value'=>($model->website?$model->website:'http://'))); ?>
		<?php echo $form->error($model,'website'); ?>
	</div>
</div>

<div class="control-group">
	<?php echo $form->labelEx($model,'twitter_uri', array('class'=>'control-label')); ?>
	<div class="controls">
		<?php echo $form->textField($model, 'twitter_uri', array('class'=>'english-field', 'value'=>($model->twitter_uri?$model->twitter_uri:'@'))); ?>
		<?php echo $form->error($model,'twitter_uri'); ?>
	</div>
</div>

<div class="control-group">
	<?php echo $form->labelEx($model,'facebook_uri', array('class'=>'control-label')); ?>
	<div class="controls">
		<?php echo $form->textField($model, 'facebook_uri', array('class'=>'english-field', 'value'=>($model->facebook_uri?$model->facebook_uri:'http://facebook.com/'))); ?>
		<?php echo $form->error($model,'facebook_uri'); ?>
	</div>
</div>

<div class="control-group">
	<?php echo $form->labelEx($model,'google_uri', array('class'=>'control-label')); ?>
	<div class="controls">
		<?php echo $form->textField($model, 'google_uri', array('class'=>'english-field')); ?>
		<?php echo $form->error($model, 'google_uri'); ?>
	</div>
</div>

<div class="control-group">
	<?php echo $form->labelEx($model,'about', array('class'=>'control-label')); ?>
	<div class="controls">
		<?php echo $form->textArea($model,'about', array('rows'=>5, 'class'=>'span4')); ?>
		<?php echo $form->error($model,'about'); ?>
	</div>
</div>

<div class="form-actions">
	<button class="btn btn-primary" type="submit"><?php echo Yii::t('core','Save'); ?></button>
	<a href="<?php echo $model->profileLink(); ?>"><button type="button" class="btn"><?php echo Yii::t('core','Cancel'); ?></button></a>
</div>

<?php $this->endWidget(); ?>