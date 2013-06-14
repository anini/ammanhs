<div class="row">
	<div class="span8 offset1">
		<div class="shadow-box reply-user">
			<?php echo $model->user->avatar_a(128, 128, array('class'=>'img-rounded')); ?>
			<div class="arrow left-arrow"></div>
		</div>
		<div class="shadow-box thread-reply">
			<div style="width:100%">
			<div class="reply-user-title">
				<h5 class="ge-ss"><a href="<?php echo $model->user->profileLink(); ?>"><?php echo $model->user->name; ?></a><span class="muted"><?php echo Time::deltaInWords($model->created_at); ?></span></h5>
			</div>
			<div class="reply-content"><div><?php echo $model->content; ?></div></div>
			<div class="reply-vote" id="reply-vote-<?php echo $model->id; ?>">
				<div class="arrow vote-up vote-up-off" title="Vote this reply up!" onclick="$('#thread-reply-vote-type').val(1); $('#thread-reply-vote-id').val(<?php echo $model->id; ?>); $('#thread-reply-vote-form').submit();"></div>
				<div class="vote-number"><?php echo $model->stat_votes; ?></div>
				<div class="arrow vote-down vote-down-off" title="Vote this reply down!" onclick="$('#thread-reply-vote-type').val(-1); $('#thread-reply-vote-id').val(<?php echo $model->id; ?>); $('#thread-reply-vote-form').submit();"></div>
			</div>
			</div>
		</div>
	</div>
</div>
<br>