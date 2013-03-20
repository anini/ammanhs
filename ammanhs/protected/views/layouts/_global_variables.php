<script type="text/javascript">
/*<![CDATA[*/
var route = <?php echo json_encode($this->route) ?>;
var user_is_guest = <?php echo (int) Yii::app()->user->isGuest ?>;
var uid = <?php echo !Yii::app()->user->isGuest ? Yii::app()->user->id  : 0 ?>;
/*]]>*/
</script>