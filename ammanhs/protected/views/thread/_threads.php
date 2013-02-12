<?php foreach ($threads as $i => $thread) {
	$this->renderPartial('_view', array('thread'=>$thread));
} ?>