<div class="alert <?php if($model->status==Constants::MEMBERSHIP_STATUS_APPROVED) echo 'alert-success'; ?>">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <?php echo Yii::t('core', 'Your membership request is pending, we will contact you as soon as possible.'); ?>
</div>
<div class="row">
	<div class="span4">
	<?php echo $this->renderPartial('_privileges', array('type'=>$model->type)); ?>
	</div>
	<div class="span5">
		<table class="ge-ss <?php echo $model->type.'-card'; ?>" id="membership-card">
			<tr>
				<td colspan="2">
					<?php echo Yii::t('core', 'Amman Hackerspace Memebership'); ?><hr>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo $user->getAttributeLabel('name'); ?>
				</td>
				<td>
					<?php echo $user->name; ?>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo $model->getAttributeLabel('organization'); ?>
				</td>
				<td>
					<?php echo $model->organization; ?>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo $model->getAttributeLabel('title'); ?>
				</td>
				<td>
					<?php echo $model->title; ?>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo $model->getAttributeLabel('type'); ?>
				</td>
				<td>
					<?php echo $model->type; ?>
				</td>
			</tr>
			<tr>
				<?php if($model->status==Constants::MEMBERSHIP_STATUS_APPROVED){ ?>
				<td>
					<?php echo $model->getAttributeLabel('expiry_date'); ?>
				</td>
				<td>
					<?php echo date('Y/m/d' ,$model->expiryDate); ?>
				</td>
				<?php }else{ ?>
				<td>
					<?php echo $model->getAttributeLabel('status'); ?>
				</td>
				<td>
					<?php echo Constants::membershipStatus($model->status); ?>
				</td>
				<?php } ?>
			</tr>
		</table>
		<?php if($model->status!=Constants::MEMBERSHIP_STATUS_APPROVED) { ?>
		<br>
		<a style="max-width: 400px;" class="btn btn-danger add-thread-button btn-block" onclick="open_membership_modal();"><icon class="octicons octicon-credit-card"></icon><?php echo Yii::t('core', ((Yii::app()->user->model->membership)?'Edit':'Create').' Membership'); ?></a>
		<?php } ?>
	</div>
</div>