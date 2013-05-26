<?php
$this->pageTitle='Rbac Admin';
$this->breadcrumbs=array(
	'Rbacs'=>array('index'),
	'Manage',
	);

Yii::app()->clientScript->registerScript('search', "
	$('.search-button').click(function(){
		$('.search-form').toggle();
		return false;
	});
	$('.search-form form').submit(function(){
		$.fn.yiiGridView.update('rbac-grid', {
			data: $(this).serialize()
		});
		return false;
	});
");
?>

<h1>Manage Rbacs</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<b><?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?></b>
<br/>
<b><?php echo CHtml::link('New AuthAssignment User - Username', '/rbac/create'); ?> </b>
<br/>
<b><?php echo CHtml::link('New AuthAssignment User - User ID', '/rbac/id_create'); ?> </b>
<br/>

<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
		'model'=>$model,
	)); ?>
</div><!-- search-form -->

<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'rbac-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
       	'columns'=>array(
       		'userid',
       		array(
       			'name'=>'username',
       			'value'=>'$data->user->username',
       		),
       		array(
       			'name'=>'itemname',
       			'value'=>'$data->itemname',
       			'filter'=>Rbac::roles(),
       		),
            array(
            	'class'=>'CButtonColumn',
            ),
        ),
    ));
?>
