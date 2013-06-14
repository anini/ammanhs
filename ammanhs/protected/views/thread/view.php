<?php
$this->pageTitle = $model->title;
$this->breadcrumbs=array(
	Yii::t('core','Threads')=>array('index'),
	$model->title,
);

$cs=Yii::app()->clientScript;
$cs->registerMetaTag($model->title, 'twitter:title');
$cs->registerMetaTag($model->title , 'og:title');
$cs->registerMetaTag(strip_tags($model->content), 'description', null, array(), 'metadescription');
$cs->registerMetaTag(strip_tags($model->content), 'twitter:description');
$cs->registerMetaTag(strip_tags($model->content), 'og:description');
$cs->registerCSSFile('/css/thread.css');
$cs->registerScriptFile('/js/thread.js', CClientScript::POS_END);

$this->menu=array(
	array('label'=>'List Thread','url'=>array('index')),
	array('label'=>'Create Thread','url'=>array('create')),
	array('label'=>'Update Thread','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete Thread','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Thread','url'=>array('admin')),
);
?>

<div class="row" itemscope itemtype="http://schema.org/Article"  >
	<div class="span2 text-center shadow-box ge-ss" style="padding: 5px 0;">
		<?php echo $model->user->avatar_a(160, 160, array('class'=>'img-rounded')); ?>
		<h4><a href="<?php echo $model->user->profileLink(); ?>"><span itemprop="author"><?php echo $model->user->name; ?></span></a></h4>
		<div id="user-stats">
	    	<h4 class="user-stat">
	    		<span class="octicons octicon-star" data-original-title="<?php echo Yii::t('core','Stat Points'); ?>"><?php echo '<br>'.$model->user->stat_points; ?></span>
	    	</h4>
	    	<h4 class="user-stat">
	    		<span class="octicons octicon-thread" data-original-title="<?php echo Yii::t('core','Stat Threads'); ?>"><?php echo '<br>'.$model->user->stat_threads; ?></span>
	    	</h4>
	    	<h4 class="user-stat">
	    		<span class="octicons octicon-discussion" data-original-title="<?php echo Yii::t('core','Stat Replies'); ?>"><?php echo '<br>'.$model->user->stat_replies; ?></span>
	    	</h4>
	    </div>
	</div>

	<div class="span7">
		<div class="row">
			<div class="span7 shadow-box">
				<div class="row">
					<div class="span5 ">
						<h4 style="margin-right: 10px;" itemprop="name" class="ge-ss"><?php echo $model->title; ?></h4>
					</div>
					<div class="span2 text-left">
						<h4 class="muted" itemprop="dateCreated" style="margin-left: 10px;"><?php echo date('Y-m-d', $model->created_at); ?></h4>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="span7">
				<div id="thread-content"><span itemprop="articleBody"><?php echo $model->content; ?></span></div>
				<div id="thread-vote">
					<?php
					$form=$this->beginWidget('CActiveForm',array(
						'id'=>'thread-vote-form',
						'action'=>'/thread/vote',
						'htmlOptions'=>array(
							'onsubmit' => 'return vote("thread-vote-form");'
						),
					)); ?>
					<input type="hidden" name="Vote[thread_id]" value="<?php echo  $model->id; ?>"/>
					<input type="hidden" id="thread-vote-type" name="Vote[type]" value="0"/>
					<div class="arrow vote-up vote-up-off" title="Vote this <?php echo $model->type; ?> up!" onclick="$('#thread-vote-type').val(1); $('#thread-vote-form').submit();"></div>
					<div class="vote-number" itemprop="interactionCount" content="UserLikes:<?php echo $model->stat_votes; ?>"><?php echo $model->stat_votes; ?></div>
					<div class="arrow vote-down vote-down-off" title="Vote this <?php echo $model->type; ?> down!" onclick="$('#thread-vote-type').val(-1); $('#thread-vote-form').submit();"></div>
					<?php $this->endWidget(); ?>
				</div>
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
				'onsubmit' => 'return vote("thread-reply-vote-form", "reply");'
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
		<div class="shadow-box" style="padding: 5px; width: 15%; display: inline-table;vertical-align: top; margin-top: 50px;">
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
					$form=$this->beginWidget('CActiveForm',array(
						'id'=>'thread-reply-form',
						'action'=>'/threadReply/create?thread_id='.$model->id,
						'enableAjaxValidation'=>false,
						'htmlOptions'=>array(
							'onsubmit'=>'return add_thread_reply("thread-reply-form");'
						),
					)); ?>
					<?php echo $form->errorSummary($thread_reply); ?>

					<div style="float: left;">
						<button class="btn" type="submit"><?php echo Yii::t('core', 'Add your reply'); ?></button>
					</div>
					<?php echo $form->markdownEditor($thread_reply, 'content', array('placeholder'=>Yii::t('core' ,'Have something to say?!'), 'style'=>'height: 150px;'));?>
					<?php $this->endWidget(); ?>
				</div>
			</div>
		</div>
	</div>
</div>



<!--
<ul class="pager">
	<li style="float: left;"><a href="#">&larr; Prev Thread</a></li>
	<li style="float: right;"><a href="#">Next Thread &rarr;</a></li>
</ul>
-->
