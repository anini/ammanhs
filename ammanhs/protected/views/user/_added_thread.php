<?php $thread=Thread::model()->findByPk($feed->thread_id); ?>
<div class="user-feed">
	<h4>
		<span class="octicons octicon-repo"></span>
		أضاف موضوع <a href='<?php echo $feed->uri; ?>'><?php echo $thread->title; ?></a>
		<span class="muted"><?php echo Time::deltaInWords($feed->created_at); ?></span>
	</h4>
	<div class="caption">
		<?php echo Text::teaser($thread->content, 150); ?>
	</div>
</div>