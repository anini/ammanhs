<?php
$this->pageTitle=$model->title.' - '.Yii::t('core', 'Amman Hackerspace');
$this->breadcrumbs=array(
	Yii::t('core', 'Activities')=>array('index'),
	$model->title,
);

$cs=Yii::app()->clientScript;
$cs->registerMetaTag($model->title, 'twitter:title');
$cs->registerMetaTag($model->title , 'og:title');
$cs->registerMetaTag(strip_tags($model->content), 'description', null, array(), 'metadescription');
$cs->registerMetaTag(strip_tags($model->content), 'twitter:description');
$cs->registerMetaTag(strip_tags($model->content), 'og:description');
$cs->registerCSSFile('/css/activity.css?v=1.0');
$cs->registerScriptFile('/js/activity.js?v=1.0', CClientScript::POS_END);

$this->menu=array(
	array('label'=>'List Activity', 'url'=>array('index')),
	array('label'=>'Create Activity', 'url'=>array('create')),
	array('label'=>'Update Activity', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Activity', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Activity', 'url'=>array('admin')),
);
?>
<div id="activity-view">
	<div itemscope itemtype="http://schema.org/Article">

		<div id="cover-photo" class="shadow-box">
		<?php echo $model->photo(900, 320); ?>
		</div>
		<h2 itemprop="name"><?php echo $model->title; ?></h2>
		<hr id="title-hr"/>
		<h5 id="hidden-date" itemprop="dateCreated"><?php echo date('Y-m-d', $model->date); ?></h5>
		<h5 class="muted"><?php echo Time::dateInArabic($model->date); ?></h5>

		<div>
			<span itemprop="articleBody" id="activity-body"><?php echo $model->content; ?></span>
		</div>

	</div>
	<?php if($activity_attachments) $this->renderPartial('_attachments', array('attachments'=>$activity_attachments)); ?>

	<?php if($activity_photos) $this->renderPartial('_album', array('photos'=>$activity_photos, 'activity_title'=>$model->title)); ?>
	<hr/>
</div>

<div id="activity-replies">
	<?php if($activity_replies){ ?>
		<?php
		foreach($activity_replies as $reply){
			$this->renderPartial('_reply', array('model'=>$reply));
		}
		?>
	<?php } ?>
</div>

<div class="row">
	<div class="span8 offset1">
		<div class="shadow-box reply-user new-reply-user">
			<?php if(Yii::app()->user->isGuest){ ?>
				<div><img src="/images/default-male.jpg" width="128px" height="128px" title="Test User" alt="Test User"></div>
			<?php }else{
				echo Yii::app()->user->model->avatar(128, 128);
			} ?>
			<div class="arrow left-arrow"></div>
		</div>
		<div class="activity-reply">
			<div>
				<?php
				$form=$this->beginWidget('CActiveForm',array(
					'id'=>'activity-reply-form',
					'action'=>'/activity/reply?activity_id='.$model->id,
					'enableAjaxValidation'=>false,
					'htmlOptions'=>array(
						'onsubmit'=>'return add_activity_reply("activity-reply-form");'
					),
				)); ?>
				<?php echo $form->errorSummary($activity_reply); ?>

				<div id="add-activity-reply-button">
					<button class="btn" type="submit"><?php echo Yii::t('core', 'Add your reply'); ?></button>
				</div>
				<?php echo $form->markdownEditor($activity_reply, 'content', array('placeholder'=>Yii::t('core' ,'Have something to say?!'), 'style'=>'height: 150px;'));?>
				<?php $this->endWidget(); ?>
			</div>
		</div>
	</div>
</div>