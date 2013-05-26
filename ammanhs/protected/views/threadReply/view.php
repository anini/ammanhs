<div class="row">
	<div class="span8 offset1">
		<div class="shadow-box" style="padding: 5px; width: 15%; display: inline-table;vertical-align: top;">
			<?php echo $model->user->avatar_a(128, 128, array('class'=>'img-rounded')); ?>
			<div class="arrow left-arrow"></div>
		</div>
		<div style="width: 80%; display: inline-table;vertical-align: top;">
			<div class="shadow-box" style="padding: 1px;margin-right: 15px;">
				<table width="100%">
					<tr>
						<td colspan="2" class="reply-user-title">
							<h5 style="margin: 5px 0; margin-right: 10px;" class="ge-ss"><a href="<?php echo $model->user->profileLink(); ?>"><?php echo $model->user->name; ?></a><span class="muted"><?php echo Time::deltaInWords($model->created_at); ?></span></h5>
						</td>
					</tr>
					<tr>
						<td class="reply-content"><?php echo $model->content; ?></td>
						<td class="reply-vote" id="reply-vote-<?php echo $model->id; ?>">
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