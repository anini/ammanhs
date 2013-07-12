<?php
$this->pageTitle=Yii::t('core', 'Amman Hackerspace').' - '.Yii::t('core', 'Search results fot :q', array(':q'=>$_GET['q']));
$this->breadcrumbs=array(
	Yii::t('core','Search'),
);
$cs=Yii::app()->clientScript;
$cs->registerCSSFile("/css/search.css");
?>
<div class="row">
	<div class="span9">
		<form class="navbar-search" action="/search">
			<input name="q" <?php if(isset($_GET['q'])) echo 'value="'.$_GET['q'].'"'; ?> type="text" class="search-query span4" placeholder="<?php echo Yii::t('core','Search'); ?>"
			><span class="octicons octicon-search search-icon"></span>
		</form>
	</div>
</div>
<?php
if($num_of_results){
	echo '<h5 class="muted bold">'.$num_of_results.' نتائج من '.$num_of_results.' نتيجة '."(عدد الثواني: $time)</h5>";
	foreach ($results as $key=>$result){
		$this->renderPartial('_db_search_result', array('result'=>$result));
		if($key<$num_of_results-1) echo '<hr>';
		else echo '<br>';
	}	
}else{ ?>
	<div id="no-results" class="ge-ss">
		<br>
		<?php echo Yii::t('core', 'There\'s no results for the query ":q"!', array(':q'=>$q)); ?>
		<br><br>
		<?php echo Yii::t('core', 'What about asking about ":q" throguh a thread?', array(':q'=>$q)); ?>
		<a class="btn btn-success add-thread-button" href="<?php echo $this->createUrl('thread/create', array('title'=>$q)); ?>"><icon class="octicons octicon-add"></icon><?php echo Yii::t('core', 'Create a New Thread'); ?></a>
	</div>
<?php } ?>