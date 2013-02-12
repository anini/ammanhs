<?php
$this->breadcrumbs=array(
	$model->username,
);
?>

<h1><?php echo $model->name; ?></h1>
<?php echo $model->avatar_a(128, 128); ?>
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'username',
		'email',
		'first_name',
		'last_name',
		'type',
		'gender',
		'about',
		'avatar_uri',
		'created_at',
		'twitter_uri',
		'facebook_uri',
		'country',
	),
)); ?>