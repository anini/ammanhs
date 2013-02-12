<?php
$this->pageTitle = $model->title;
$this->breadcrumbs=array(
	'Threads'=>array('index'),
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

<table id="user-info-table">
	<tr>
		<td>
			<div class="user-info-box">
				<?php echo $model->user->avatar_a(128, 128); ?>
			    <div id="user-name"><?php echo $model->user->name; ?></div>
			    <div>User Info</div>
			</div>
		</td>
		<td width="100%">
			<div>
				<div id="thread-title">
					<b style=""><?php echo $model->title; ?></b>
					<span><?php echo date('Y-m-d', $model->created_at); ?></span>
				</div>
				<table>
					<tr width="100%">
						<td id="thread-content">
							<p><?php echo $model->content; ?></p>
						</td>
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
						<td id="thread-vote">
							<div class="arrow vote-up vote-up-off" title="Vote this <?php echo $model->type; ?> up!" onclick="$('#thread-vote-type').val(1); $('#thread-vote-form').submit();"></div>
							<div class="vote-number"><?php echo $model->stat_votes; ?></div>
							<div class="arrow vote-down vote-down-off" title="Vote this <?php echo $model->type; ?> down!" onclick="$('#thread-vote-type').val(-1); $('#thread-vote-form').submit();"></div>
						</td>
						<?php $this->endWidget(); ?>
					</tr>
				</table>
			</div>
		</td>
	</tr>
</table>

<div id="thread-replies">
	<?php
	foreach ($model->replies as $reply) {
		$this->renderPartial('../threadReply/view', array('model' => $reply));
	}
	?>
</div>

<div id="new-thread">
	<table width="100%">
		<tr>
			<td style="padding-left: 60px;">
				<div class="reply-user">
					<?php if (Yii::app()->user->isGuest) { ?>
						<div style="width:96px;height:96px"><img src="/images/default-male.jpg" width="96px" height="96px" title="Test User" alt="Test User"></div>
					<?php } else { 
						echo Yii::app()->user->model->avatar(96, 96);
					}?>
				</div>
			</td>
			<td style="width: 100%;">
				<div>
					<?php
					$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
						'id'=>'thread-reply-form',
						'action'=>'/threadReply/create?thread_id='.$model->id,
						'enableAjaxValidation'=>false,
						'htmlOptions'=>array(
							'onsubmit' => 'return add_thread_reply(this);'
						),
					)); ?>
					<?php echo $form->errorSummary($thread_reply); ?>

					<div style="float: right;">
						<?php $this->widget('bootstrap.widgets.TbButton', array(
							'buttonType'=>'submit',
							'htmlOptions'=>array('style'=>'font-weight: bold;'),
							'label'=> 'Reply',
						)); ?>
					</div>
					<?php echo $form->markdownEditorRow($thread_reply, 'content', array('height'=>'100px', 'placeholder'=>'Have something to say?!'));?>
					<?php $this->endWidget(); ?>
				</div>
			</td>
		</tr>
	</table>
</div>

<ul class="pager">
	<li style="float: left;"><a href="#">&larr; Prev Thread</a></li>
	<li style="float: right;"><a href="#">Next Thread &rarr;</a></li>
</ul>