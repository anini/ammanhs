<?php
$this->pageTitle = $model->title;
$this->breadcrumbs=array(
	Yii::t('core','Threads')=>array('index'),
	$model->title,
);
Yii::app()->clientScript->registerCSSFile('/css/thread.css');
Yii::app()->clientScript->registerScriptFile('/js/thread.js', CClientScript::POS_END);
$this->menu=array(
	array('label'=>'List Thread','url'=>array('index')),
	array('label'=>'Create Thread','url'=>array('create')),
	array('label'=>'Update Thread','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete Thread','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Thread','url'=>array('admin')),
);
?>

<div class="row">
	<div class="span2 text-center user-info-box" style="padding: 5px 0;">
		<?php echo $model->user->avatar_a(160, 160, array('class'=>'img-rounded')); ?>
		<h4><?php echo $model->user->name; ?></h4>
		<div>User Info</div>
	</div>

	<div class="span7">
		<div class="row">
			<div class="span7 user-info-box">
				<div class="row">
					<div class="span5 ">
						<h4 style="margin-right: 10px;"><?php echo $model->title; ?></h4>
					</div>
					<div class="span2 text-left">
						<h4 class="muted" style="margin-left: 10px;"><?php echo date('Y-m-d', $model->created_at); ?></h4>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="span7" style="position:relative;">
				<table width="100%">
					<tr>
						<td><?php echo $model->content; ?></td>
						<td id="thread-vote">
							<?php
							$form=$this->beginWidget('CActiveForm',array(
								'id'=>'thread-vote-form',
								'action'=>'/thread/vote',
								'htmlOptions'=>array(
									'onsubmit' => 'return vote(this);'
								),
							)); ?>
							<input type="hidden" name="Vote[thread_id]" value="<?php echo  $model->id; ?>"/>
							<input type="hidden" id="thread-vote-type" name="Vote[type]" value="0"/>
							<div class="arrow vote-up vote-up-off" title="Vote this <?php echo $model->type; ?> up!" onclick="$('#thread-vote-type').val(1); $('#thread-vote-form').submit();"></div>
							<div class="vote-number"><?php echo $model->stat_votes; ?></div>
							<div class="arrow vote-down vote-down-off" title="Vote this <?php echo $model->type; ?> down!" onclick="$('#thread-vote-type').val(-1); $('#thread-vote-form').submit();"></div>
							<?php $this->endWidget(); ?>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>
<hr/>




<div id="thread-replies">
	<?php if($model->stat_replies) { ?>
		<?php
		$form=$this->beginWidget('CActiveForm',array(
			'id'=>'thread-reply-vote-form',
			'action'=>'/threadReply/vote',
			'htmlOptions'=>array(
				'onsubmit' => 'return vote(this, "reply");'
			),
		)); ?>
		<input type="hidden" id="thread-reply-vote-id" name="Vote[thread_reply_id]" value="0"/>
		<input type="hidden" id="thread-reply-vote-type" name="Vote[type]" value="0"/>
		<?php $this->endWidget(); ?>
		<?php
		foreach ($model->replies as $reply) {
			$this->renderPartial('../threadReply/view', array('model' => $reply));
		}
		?>
	<?php } ?>
</div>


<div class="row">
	<div class="span8 offset1">
		<div class="user-info-box" style="padding: 5px; width: 15%; display: inline-table;vertical-align: top; margin-top: 50px;">
			<?php if (Yii::app()->user->isGuest) { ?>
				<div><img src="/images/default-male.jpg" width="128px" height="128px" title="Test User" alt="Test User"></div>
			<?php } else { 
				echo Yii::app()->user->model->avatar(128, 128);
			}?>
			<div class="arrow left-arrow"></div>
		</div>
		<div style="width: 80%; display: inline-table;vertical-align: top;">
			<div style="padding: 1px;margin-right: 15px;">
				<div style="width: 100%;">
					<?php
					$form=$this->beginWidget('zii.widgets.CActiveForm',array(
						'id'=>'thread-reply-form',
						'action'=>'/threadReply/create?thread_id='.$model->id,
						'enableAjaxValidation'=>false,
						'htmlOptions'=>array(
							'onsubmit' => 'return add_thread_reply(this);'
						),
					)); ?>
					<?php echo $form->errorSummary($thread_reply); ?>

					<div style="float: left;">
						<button class="btn" type="submit"><b><?php echo Yii::t('core','Add your reply'); ?></b></button>
					</div>
					<?php echo $form->markdownEditor($thread_reply, 'content', array('placeholder'=>'Have something to say?!', 'style'=>'height: 150px;'));?>
					<?php $this->endWidget(); ?>
				</div>
			</div>
		</div>
	</div>
</div>




<ul class="pager">
	<li style="float: left;"><a href="#">&larr; Prev Thread</a></li>
	<li style="float: right;"><a href="#">Next Thread &rarr;</a></li>
</ul>