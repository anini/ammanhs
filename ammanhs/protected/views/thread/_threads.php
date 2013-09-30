<?php
if($type=='me'&&!count($threads)){ ?>
	<br>
	<?php echo Yii::t('core', 'You have no threads!'); ?>
	&nbsp
	<a class="btn btn-success add-thread-button" href="<?php echo $this->createUrl('thread/create'); ?>"><icon class="octicons octicon-repo-create"></icon><?php echo Yii::t('core', 'Create a New Thread'); ?></a>
<?php
}else{
	foreach ($threads as $i=>$thread){
		$this->renderPartial('_view', array('thread'=>$thread));
	}
}
?>