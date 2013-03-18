<div class="row">
	<div class="span8 offset1">
		<div class="user-info-box" style="padding: 5px; width: 15%; display: inline-table;vertical-align: top;">
			<?php echo $model->user->avatar_a(128, 128, array('class'=>'img-rounded')); ?>
			<div class="arrow left-arrow"></div>
		</div>
		<div style="width: 80%; display: inline-table;vertical-align: top;">
			<div class="user-info-box" style="padding: 1px;margin-right: 15px;">
				<table width="100%">
					<tr>
						<td colspan="2" class="reply-user-title">
							<h4 style="margin-right: 10px;"><a href="<?php echo $model->user->profileLink(); ?>"><?php echo $model->user->name; ?></a><span class="muted"><?php echo date('Y-m-d', $model->created_at); ?></span></h4>
						</td>
					</tr>
					<tr>
						<td class="reply-content"><?php echo $model->content; ?></td>
						<td id="thread-vote">
							<div class="arrow vote-up vote-up-off" title="Vote this reply up!" onclick="$('#thread-reply-vote-type').val(1); $('#thread-reply-vote-id').val(<?php echo $model->id; ?>); $('#thread-reply-vote-form').submit();"></div>
							<div class="vote-number"><?php echo $model->stat_votes; ?></div>
							<div class="arrow vote-down vote-down-off" title="Vote this reply down!" onclick="$('#thread-reply-vote-type').val(-1); $('#thread-reply-vote-id').val(<?php echo $model->id; ?>); $('#thread-reply-vote-form').submit();"></div>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>

	<br>