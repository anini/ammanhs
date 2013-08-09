<?php
$user_link=Yii::app()->urlManager->createUrl('user/view', array('id'=>$result->user->id));
$thread_link=Yii::app()->urlManager->createUrl('thread/view', array('id'=>$result->id));
?>
<div class="search-result">
	<div style="width: 10%;">
		<a href="<?php echo $user_link; ?>">
			<?php echo Img::embed($result->user->avatar_uri, 64, 64, false, array('class'=>'img-circle', 'data-original-title'=>$result->user->name)); ?>
		</a>
	</div>
	<div style="width: 88%;">
		<a href="<?php echo $thread_link; ?>" class="ge-ss">
			<?php echo $result->title; ?>
		</a>
		<div style="padding-top: 10px;">
			<?php echo Text::teaser($result->content, 100); ?>
		</div>
	</div>
</div>