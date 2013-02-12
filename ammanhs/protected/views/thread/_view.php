<table id="thread-<?php echo $thread->id; ?>" class="thread-summary">
	<tr>
		<td class="summary">
			<div class="<?php echo $thread->type; ?>-thread-icon"></div>
			<div class="thread-title">
				<a href="<?php echo Yii::app()->urlManager->createUrl('thread/view', array('id' => $thread->id)); ?>"><?php echo $thread->title; ?></a>
			</div>
			<div class="thread-tags"></div>
			<div class="thread-info">
				<div class="thread-author">
					By <a href="<?php echo Yii::app()->urlManager->createUrl('user/show', array('id' => $thread->user->id)); ?>"><?php echo $thread->user->name; ?></a>
				</div>
				<div class="thread-date">
					<?php echo Time::deltaInWords($thread->created_at); ?>
				</div>
			</div>
		</td>
		<td class="thread-stat-replies">
			<?php echo $thread->stat_replies . '<br/>' . (($thread->stat_replies==1)?'Reply':'Replies'); ?>
		</td>
		<td class="thread-stat-votes">
			<?php echo $thread->stat_votes . '<br/>' . (($thread->stat_votes==1)?'Vote':'Votes'); ?>
		</td>
		<td class="thread-stat-views">
			<?php echo $thread->stat_views . '<br/>' . (($thread->stat_views==1)?'View':'Views'); ?>
		</td>		
	</tr>
</table>