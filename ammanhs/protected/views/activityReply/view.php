<div class="row">
	<div class="span8 offset1">
		<div class="shadow-box reply-user">
			<?php echo $model->user->avatar_a(128, 128, array('class'=>'img-rounded')); ?>
			<div class="arrow left-arrow"></div>
		</div>
		<div class="shadow-box activity-reply">
			<div>
				<div class="reply-user-title">
					<h5><a href="<?php echo $model->user->profileLink; ?>"><?php echo $model->user->name; ?></a><span class="muted"><?php echo Time::deltaInWords($model->created_at); ?></span></h5>
				</div>
				<div class="reply-content"><div><?php echo $model->content; ?></div></div>
			</div>
		</div>
	</div>
</div>
<br>