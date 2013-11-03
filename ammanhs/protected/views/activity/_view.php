<div class="row activity-view">
	<div class="span3 activity-photo">
		<?php echo $model->photo_a(360, 128); ?>
	</div>
	<div class="span6 activity-details">
		<h3 class="row">
		<div class="span4">
				<a href="<?php echo $this->createUrl('activity/view', array('id'=>$model->uq_title)); ?>"><?php echo $model->title; ?></a>
			</div>
			<div class="span2 activity-stats">
				<div class="create-date muted">
					<span><?php echo date('Y/m/d', $model->date); ?></span>
				</div>
				<div class="stat-photos">
		    		<span class="octicons octicon-device-camera" data-original-title="<?php echo $model->stat_photos.' '.(Yii::t('core', ((abs(substr($model->stat_photos, -2))<11 && abs(substr($model->stat_photos, -2))>2)?'photos':'photo'))); ?>"><span><?php echo $model->stat_photos; ?></span></span>
		    	</div>
		    	<div>
		    		<span class="octicons octicon-file-zip" data-original-title="<?php echo $model->stat_attachments.' '.(Yii::t('core', ((abs(substr($model->stat_attachments, -2))<11 && abs(substr($model->stat_attachments, -2))>2)?'attachments':'attachment'))); ?>"><span><?php echo $model->stat_attachments; ?></span></span>
		    	</div>
			</div>
		</h3>
		<div class="row">
			<div class="span6">
				<?php echo Text::teaser($model->content, 100); ?><a href="<?php echo $this->createUrl('activity/view', array('id'=>$model->uq_title)); ?>"><?php echo Yii::t('core', 'continue reading'); ?></a>
			</div>
		</div>
	</div>
</div>
<hr/>