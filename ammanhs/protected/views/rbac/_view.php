<div class="view">
	<b><?php echo CHtml::encode($data->getAttributeLabel('userid')); ?>:</b>
	<?php echo CHtml::encode($data->userid); ?>
	<br/>
	<b><?php echo CHtml::encode($data->getAttributeLabel('itemname')); ?>:</b>
	<?php echo CHtml::encode($data->itemname); ?>
	<br/>
	<?php echo '<b>'.CHtml::link('Edit', '/rbac/update/'.$data->id).'</b>'."  Click here to update this user"; ?>
	<br/>
	<?php echo '<b>'.CHtml::link('Delete', '/rbac/delete/'.$data->id).'</b>'."  Click here to delete this user"; ?>
	<br/>
</div>
