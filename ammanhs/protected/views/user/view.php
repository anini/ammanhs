<?php
$this->breadcrumbs=array(
	$model->name,
);
Yii::app()->clientScript->registerCSSFile('/css/user.css');
$this->menu=array(
	array('label'=>'List User','url'=>array('index')),
	array('label'=>'Create User','url'=>array('create')),
	array('label'=>'Update User','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete User','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage User','url'=>array('admin')),
);
?>

<h2><?php echo $model->name; ?></h2>

<table id="user-info-table">
	<tr>
		<td>
			<div id="user-info-box">
				<?php echo $model->avatar(160, 160); ?>
			    <div id="user-stats">
			    	<h4 class="user-stat">
			    		<span class="octicons octicon-star" data-original-title="<?php echo Yii::t('core','Stat Points'); ?>"><?php echo '<br>'.$model->stat_points; ?></span>
			    	</h4>
			    	<h4 class="user-stat">
			    		<span class="octicons octicon-thread" data-original-title="<?php echo Yii::t('core','Stat Threads'); ?>"><?php echo '<br>'.$model->stat_threads; ?></span>
			    	</h4>
			    	<h4 class="user-stat">
			    		<span class="octicons octicon-discussion" data-original-title="<?php echo Yii::t('core','Stat Replies'); ?>"><?php echo '<br>'.$model->stat_replies; ?></span>
			    	</h4>
			    </div>
			</div>
		</td>
		<td width="100%">
			Activities
			<?php
			foreach ($user_feed as $feed) {
				echo $feed->points_earned;
			}
			?>
		</td>
	</tr>
</table>







<?php $this->widget('zii.widgets.CDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'username',
		'password',
		'email',
		'first_name',
		'last_name',
		'type',
		'gender',
		'about',
		'avatar_uri',
		'created_at',
		'last_login_at',
		'twitter_uri',
		'facebook_uri',
		'country',
	),
)); ?>
