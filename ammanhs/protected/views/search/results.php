<?php
$this->pageTitle=Yii::t('core', 'Amman Hackerspace').' - '.Yii::t('core', 'Search results fot :q', array(':q'=>$_GET['q']));
$this->breadcrumbs=array(
	Yii::t('core','Search'),
);?>
<div class="row">
	<div class="span9">
<form class="navbar-search" action="/search">
        <input name="q" <?php if(isset($_GET['q'])) echo 'value="'.$_GET['q'].'"'; ?> type="text" class="search-query span4" placeholder="<?php echo Yii::t('core','Search'); ?>"
        ><span class='octicons octicon-search' style='margin-right: -22px;opacity: 0.5;position: absolute;margin-top: 7px'></span>
      </form>
  </div>
  </div>
<?php
$count = COUNT($results);
if($count){
	echo '<h5 class="muted bold">'.$count . ' نتائج من ' . $num_of_results . ' نتيجة ' . "(عدد الثواني: $time)</h5>";
	foreach ($results as $key=>$result) {
		$this->renderPartial('_result', array('result'=>$result));
		if($key<$count-1) echo "<hr>";
		else echo "<br>";
	}	
}else{
	echo Yii::t('core', 'There\'s no results!');
}

?>

<div class="pagination pagination-centered">
	<?php $this->widget('Pager', array('pages' => $pages)) ?>
</div>