<?php
if (Yii::app()->user->hasFlash('flash')) {
  $flash = Yii::app()->user->getFlash('flash');
?>
  <div class="alert alert-<?php echo $flash['status'] ?>">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <?php echo $flash['message'] ?>
  </div>
<?php } ?>