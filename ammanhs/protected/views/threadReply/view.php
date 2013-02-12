<table style="width: 100%;" id="<?php echo 'threadReply-'.$model->id; ?>">
	<tr>
		<td style="vertical-align: top; padding-left: 60px;">
			<div class="reply-user">
			      <?php echo $model->user->avatar_a(96, 96); ?>			      </div>
		</td>
		<td style="width: 100%; vertical-align: top;">
			<div>
				<div class="arrow right-arrow"></div>
				<div style="
margin-bottom: 20px;
border: 1px solid rgba(0, 0, 0, 0.199219);;
-webkit-border-radius: 3px;
-moz-border-radius: 3px;
border-radius: 3px;
-webkit-box-shadow: rgba(0, 0, 0, 0.199219) 0px 0px 10px 0px;
-moz-box-shadow: inset 0 1px 1px rgba(0,0,0,0.05);
box-shadow: rgba(0, 0, 0, 0.199219) 0px 0px 10px 0px;">

<h3 class="popover-title"><?php echo $model->user->name; ?><span style="float:right;"><?php echo Time::deltaInWords($model->created_at); ?><span></h3>

<table class="popover-content">
	<tr style="width: 100%">
		<td class="reply-content">
			<p><?php echo $model->content; ?></p>
		</td>
		<td class="reply-vote">
			<div class="arrow vote-up-off" title="Vote this reply up!"></div>
			<div class="vote-number"><?php echo $model->stat_votes; ?></div>
			<div class="arrow vote-down-off" title="Vote this reply down!"></div>
		</td>
        </tr>
            </table>
					
			</div></div>
		</td>
	</tr>
</table>
