<hr/>

<table id="attachments-table" class="table table-striped" data-original-title="<?php echo Yii::t('core', 'Attachments'); ?>">
	<tbody>
	    <?php
	    foreach($attachments as $attachment){ ?>
	        <tr>
	            <td class="name-td">
	                <span><?php echo $attachment->name; ?></span>
	            </td>
	            <td class="type-td">
	            	<i class="octicons <?php echo Constants::attachmentTypeIcon($attachment->type); ?>"></i>
	            	<span><?php echo Constants::attachmentType($attachment->type); ?></span>
	            </td>
	            <td class="size-td">
	                <span>
	                    <?php
	                    $file_path=Yii::app()->basePath.'/../images/'.$attachment->uri;
	                    if(is_readable($file_path)){
	                        $filesize=filesize($file_path)*.0009765625;
	                        if($filesize>1024){
	                            $filesize=sprintf("%.2f", $filesize*.0009765625);
	                            $filesize.=' '.Yii::t('core', 'Megabyte');
	                        }else{
	                            $filesize=sprintf("%.2f", $filesize);
	                            $filesize.=' '.Yii::t('core', 'Kilobyte');;
	                        }
	                    }else{
	                    	$filesize='File is not readable!';
	                    }
	                    echo $filesize;
	                    ?>
	                </span>
	            </td>
	            <td class="buttons-td">
	            	<?php
	            	if($attachment->name){
	            		$uri=explode('.', $attachment->uri);
	            		$extension=$uri[1];
	            		$download_name=$attachment->name.'.'.$extension;
	            	}else{
	            		$download_name='';
	            	}
	            	?>
	            	<a target="_blank" href="<?php echo '/images/'.$attachment->uri; ?>">
	                	<button class="btn btn-warning">
		                    <i class="octicons octicon-eye"></i>
		                    <span><?php echo Yii::t('core', 'Preview'); ?></span>
		                </button>
		            </a>
		            <a download="<?php echo $download_name; ?>" href="<?php echo '/images/'.$attachment->uri; ?>">
		                <button class="btn btn-success">
		                    <i class="octicons octicon-cloud-download"></i>
		                    <span><?php echo Yii::t('core', 'Download'); ?></span>
		                </button>
		            </a>
	            </td>
	        </tr>
	   <?php } ?>
	</tbody>
</table>