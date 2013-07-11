<table align="center" cellpadding="0" cellspacing="0" style="direction:rtl;padding:auto;border:4px solid rgba(0, 0, 0, 0.247059);font-family:arial;font-size:12px" width="616">
	<tbody>
		<tr>
			<td style="border-bottom:5px solid rgba(0, 0, 0, 0.247059);padding:12px;background-color:rgb(229, 229, 229)" valign="top">
				<a href="http://ammanhs.com"><img src="<?php echo "http://".Yii::app()->params['static_host']."/images/brand_ar.png"; ?>" /></a>
			</td>
		</tr>
		<tr>
			<td valign="top">
				<div style="padding:12px;"><?php echo $content; ?></div>
			</td>
		</tr>
		<tr>
			<td valign="middle" style="background-color:rgb(229, 229, 229);padding:0 16px;font-size:11px;">
				<div style="height:27px;line-height:30px">
					<div style="float:right;font-family:arial">
						<a href="<?php echo $this->createAbsoluteUrl('site/about'); ?>" style="color:#2a8cc3;text-decoration:none"><?php echo Yii::t('core', 'About'); ?></a>
						<span style="color:#ccc">|</span>
						<a href="<?php echo $this->createAbsoluteUrl('site/index').'#contact'; ?>" style="color:#2a8cc3;text-decoration:none"><?php echo Yii::t('core', 'Contact Us'); ?></a>
					</div>
					<div style="float:left;font-family:arial">
						<?php echo Yii::t('core', 'Copy Rights - Arabic'); ?>
					</div>
				</div>
			</td>
		</tr>
	</tbody>
</table>