<hr/>
<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'htmlOptions'=>array(
		'class'=>'form-inline',
		)
)); ?>

<div class="control-group">
	<div class="form-inline">
		<div class="row">
			<div class="span3">
				<?php echo $form->label($model,'id', array('class'=>'span1')); ?>
				<?php echo $form->textField($model,'id', array('class'=>'span2')); ?>
			</div>
			<div class="span3">
				<?php echo $form->label($model,'user_id', array('class'=>'span1')); ?>
				<?php echo $form->textField($model,'user_id', array('class'=>'span2')); ?>
			</div>
			<div class="span3">
				<?php echo $form->label($model,'publish_status', array('class'=>'span1')); ?>
				<?php echo $form->dropDownList($model, 'publish_status', array(''=>'All')+Constants::publishStatuses(), array('class'=>'span2')); ?>
			</div>
			<div class="span3">
				<?php echo $form->label($model,'created_at', array('class'=>'span1')); ?>
				<?php echo $form->textField($model,'created_at', array('class'=>'span2')); ?>
			</div>
		</div>
	</div>
</div>
<div class="control-group">
	<div class="form-inline">
		<div class="row">
			<div class="span3">
				<?php echo $form->label($model,'type', array('class'=>'span1')); ?>
				<?php echo $form->dropDownList($model, 'type', array(''=>'All')+Constants::threadTypes(), array('class'=>'span2')); ?>
			</div>
			<div class="span3">
				<?php echo $form->label($model,'title', array('class'=>'span1')); ?>
				<?php echo $form->textField($model,'title', array('class'=>'span2')); ?>
			</div>
			<div class="span3">
				<?php echo $form->label($model,'content', array('class'=>'span1')); ?>
				<?php echo $form->textField($model,'content', array('class'=>'span2')); ?>
			</div>
			<div class="span2 offset1">
				<?php echo CHtml::submitButton('Search', array('class'=>'span2 btn btn-primary btn-block')); ?>
			</div>
		</div>
	</div>
</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
<hr/>