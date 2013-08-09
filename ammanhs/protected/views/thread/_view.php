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
					<?php echo Yii::t('core', 'By'); ?> <a href="<?php echo Yii::app()->urlManager->createUrl('user/view', array('id' => $thread->user->id)); ?>"><?php echo $thread->user->name; ?></a>
				</div>
				<div class="thread-date">
					<?php echo Time::deltaInWords($thread->created_at); ?>
				</div>
			</div>
		</td>
		<td class="thread-stat-replies">
			<?php echo $thread->stat_replies . '<br/>' . Yii::t('core', ((abs($thread->stat_replies)<11 && abs($thread->stat_replies)>2)?'Replies':'Reply')); ?>
		</td>
		<td class="thread-stat-votes">
			<?php echo $thread->stat_votes . '<br/>' . Yii::t('core', ((abs($thread->stat_votes)<11 && abs($thread->stat_votes)>2)?'Votes':'Vote')); ?>
		</td>
		<td class="thread-stat-views">
			<?php echo $thread->stat_views . '<br/>' . Yii::t('core', ((abs($thread->stat_views)<11 && abs($thread->stat_views)>2)?'Views':'View')) ?>
		</td>		
	</tr>
</table>