<?php
$user_link = Yii::app()->urlManager->createUrl('user/view', array('id' => $result->user_id));
$thread_link = Yii::app()->urlManager->createUrl('thread/view', array('id' => $result->thread_id));
?>
<div>
	<div style="display: inline-block; width: 10%; vertical-align: middle;">
	<a href="<?php echo $user_link; ?>">
	<?php echo Img::embed($result->user_avatar, 64, 64, false, array('class'=>'img-circle', 'data-original-title'=>$result->user_name)); ?></a>
	</div>
	<div style="display: inline-block; vertical-align: middle; width: 88%;">
		<a href="<?php echo $thread_link; ?>" class="ge-ss">
		<?php echo $result->title; ?>
	</a>
	</div>
	<div style="margin-right: 11%;">
		<?php echo Text::teaser($result->content, 100); ?>
	</div>
</div>