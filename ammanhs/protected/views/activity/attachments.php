<?php
$this->breadcrumbs=array(
    Yii::t('core', 'Activities')=>array('index'),
    $model->title=>$model->link,
    Yii::t('core', 'Attachments'),
);

$cs=Yii::app()->clientScript;

$cs->registerCSSFile('/css/jquery.fileupload-ui.css');

// The jQuery UI widget factory, can be omitted if jQuery UI is already included
$cs->registerScriptFile('/js/jquery.fileupload/jquery.ui.widget.js', CClientScript::POS_END);
// The Templates plugin is included to render the upload/download listings
$cs->registerScriptFile('/js/jquery.fileupload/tmpl.min.js', CClientScript::POS_END);
// The Load Image plugin is included for the preview images and image resizing functionality
$cs->registerScriptFile('/js/jquery.fileupload/load-image.min.js', CClientScript::POS_END);
// The Iframe Transport is required for browsers without support for XHR file uploads
$cs->registerScriptFile('/js/jquery.fileupload/jquery.iframe-transport.js', CClientScript::POS_END);
// The basic File Upload plugin
$cs->registerScriptFile('/js/jquery.fileupload/jquery.fileupload.js', CClientScript::POS_END);
// The File Upload processing plugin
$cs->registerScriptFile('/js/jquery.fileupload/jquery.fileupload-process.js', CClientScript::POS_END);
// The File Upload image preview & resize plugin
$cs->registerScriptFile('/js/jquery.fileupload/jquery.fileupload-image.js', CClientScript::POS_END);
// The File Upload validation plugin
$cs->registerScriptFile('/js/jquery.fileupload/jquery.fileupload-validate.js', CClientScript::POS_END);
// The File Upload user interface plugin
$cs->registerScriptFile('/js/jquery.fileupload/jquery.fileupload-ui.js', CClientScript::POS_END);
// The main application script
$cs->registerScriptFile('/js/jquery.fileupload/main.js', CClientScript::POS_END);
?>

<div class="row">
    <div class="span7">
        <h1><?php echo Yii::t('core', 'Update Attachments'); ?></h1>
    </div>
    <div class="span2">
        <a style="float: left" href="<?php echo $this->createUrl('activity/view', array('id'=>$model->uq_title)); ?>"><h4 style="line-height: 40px"><?php echo Yii::t('core', 'skip'); ?></h4></a>
    </div>
</div>
<br>

<!-- The file upload form used as target for the file upload widget -->
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'fileupload',
    'method'=>'POST',
    'action'=>'/activity/uploadFile?activity_id='.$model->id.'&folder=attachments',
    'htmlOptions'=>array(
        'enctype'=>'multipart/form-data',
    ),
)); ?>
    <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
    <div class="fileupload-buttonbar">
        <div>
            <!-- The fileinput-button span is used to style the file input field as button -->
            <span class="btn btn-success fileinput-button">
                <i class="octicons octicon-plus"></i>
                <span><?php echo Yii::t('core', 'Add files...'); ?></span>
                <input type="file" name="files[]" multiple>
            </span>
            <button type="submit" class="btn btn-primary start">
                <i class="octicons octicon-cloud-upload"></i>
                <span><?php echo Yii::t('core', 'Start upload'); ?></span>
            </button>
            <button type="reset" class="btn btn-warning cancel">
                <i class="octicons octicon-circle-slash"></i>
                <span><?php echo Yii::t('core', 'Cancel upload'); ?></span>
            </button>
            <button type="button" class="btn btn-info" onclick="return submit_ajax(document.getElementById('fileupload'), '#update-feedback', '/activity/updateAttachmentsNamesAndTypes?activity_id=<?php echo $model->id; ?>');">
                <i class="octicons octicon-tag"></i>
                <span><?php echo Yii::t('core', 'Update Names & Types'); ?></span>
            </button>
            <button type="button" class="btn btn-danger delete">
                <i class="octicons octicon-remove-close"></i>
                <span><?php echo Yii::t('core', 'Delete'); ?></span>
            </button>
            <input type="checkbox" class="toggle">
            <!-- The loading indicator is shown during file processing -->
            <span class="fileupload-loading"></span>
            <span id="update-feedback"></span>
        </div>
        <!-- The global progress information -->
        <div class="fileupload-progress fade">
            <!-- The global progress bar -->
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                <div class="bar bar-success" style="width:0%;"></div>
            </div>
            <!-- The extended global progress information -->
            <div class="progress-extended">&nbsp;</div>
        </div>
    </div>
    <!-- The table listing the files available for upload/download -->
    <table role="presentation" class="table table-striped">
    	<tbody class="files">
	        <?php
	        if($attachments){
	            foreach($attachments as $attachment){ ?>
	                <tr class="template-download fade in">
	                    <?php $uri=explode('/attachments/', $attachment->uri); ?>
	                    <td>
	                        <p class="name"><?php echo $uri[1]; ?></p>
	                    </td>
	                    <td>
	                        <input placeholder="<?php echo Yii::t('core', 'Name'); ?>" name="name[<?php echo $attachment->id; ?>]" type="text" value="<?php echo $attachment->name; ?>">
	                    </td>
	                    <td>
	                        <select name="type[<?php echo $attachment->id; ?>]" style="font-size: 12px;padding: 3px">
	                        	<?php foreach(Constants::getAttachmentsTypes() as $k=>$type){ ?>
	                        		<option value="<?php echo $k; ?>" <?php if($attachment->type==$k) echo 'selected'; ?>><?php echo $type?></option>
	                        	<?php } ?>
							</select>
	                    </td>
	                    <td>
	                        <p class="size">
	                            <?php
	                            $file_path=Yii::app()->basePath.'/../images/'.$attachment->uri;
	                            if(is_readable($file_path)){
		                            $filesize=filesize($file_path)*.0009765625;
		                            if($filesize>1024){
		                                $filesize=sprintf("%.2f", $filesize*.0009765625);
		                                $filesize.=' MB';
		                            }else{
		                                $filesize=sprintf("%.2f", $filesize);
		                                $filesize.=' KB';
		                            }
		                        }else{
		                        	$filesize='File is not readable!';
		                        }
	                            echo $filesize;
	                            ?>
	                        </p>
	                    </td>
	                    <td>
	                        <button class="btn btn-danger delete" data-type="DELETE" data-url="<?php echo $this->createUrl('activity/deleteFile', array('model_id'=>$attachment->id, 'model_name'=>'ActivityAttachment'))?>">
	                            <i class="octicons octicon-remove-close"></i>
	                            <span><?php echo Yii::t('core', 'Delete'); ?></span>
	                        </button>
	                        <input type="checkbox" name="delete" value="1" class="toggle">
	                    </td>
	                </tr>
	           <?php }
	        } ?>
	    </tbody>
	</table>

<?php $this->endWidget(); ?>


<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td>
            <p class="name">{%=file.name%}</p>
            {% if (file.error) { %}
                <div><span class="label label-danger">Error</span> {%=file.error%}</div>
            {% } %}
        </td>
        <td>
            <input placeholder="<?php echo Yii::t('core', 'Name'); ?>" name="name" type="text" value="{%=file.name.substring(0, file.name.length-4)%}">
        </td>
        <td>
            <select name="type" style="font-size: 12px;padding: 3px">
            	<?php foreach(Constants::getAttachmentsTypes() as $k=>$type){ ?>
            		<option value="<?php echo $k; ?>"><?php echo $type?></option>
            	<?php } ?>
			</select>
        </td>
        <td>
            <p class="size">{%=o.formatFileSize(file.size)%}</p>
            {% if (!o.files.error) { %}
                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="bar bar-success" style="width:0%;"></div></div>
            {% } %}
        </td>
        <td>
            {% if (!o.files.error && !i && !o.options.autoUpload) { %}
                <button class="btn btn-primary start">
                    <i class="octicons octicon-cloud-upload"></i>
                    <span><?php echo Yii::t('core', 'Upload'); ?></span>
                </button>
            {% } %}
            {% if (!i) { %}
                <button class="btn btn-warning cancel">
                    <i class="octicons octicon-circle-slash"></i>
                    <span><?php echo Yii::t('core', 'Cancel'); ?></span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        <td>
            <p class="name">
                {% if (file.url) { %}
                    <a href="{%=file.url%}" title="{%=file.filename%}" download="{%=file.filename%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
                {% } else { %}
                    <span>{%=file.name%}</span>
                {% } %}
            </p>
            {% if (file.error) { %}
                <div><span class="label label-danger">Error</span> {%=file.error%}</div>
            {% } %}
        </td>
        <td>
            <input placeholder="<?php echo Yii::t('core', 'Name'); ?>" name="name[{%=file.model_id?file.model_id:''%}]" type="text" value="{%=file.filename%}">
        </td>
        <td>
            <select name="type" style="font-size: 12px;padding: 3px">
            	<?php foreach(Constants::getAttachmentsTypes() as $k=>$type){ ?>
            		<option value="<?php echo $k; ?>" {%=file.filetype=='<?php echo $k; ?>'?'selected':''%}><?php echo $type?></option>
            	<?php } ?>
			</select>
        </td>
        <td>
            <span class="size">{%=o.formatFileSize(file.size)%}</span>
        </td>
        <td>
            {% if (file.deleteUrl) { %}
                <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                    <i class="octicons octicon-remove-close"></i>
                    <span><?php echo Yii::t('core', 'Delete'); ?></span>
                </button>
                <input type="checkbox" name="delete" value="1" class="toggle">
            {% } else { %}
                <button class="btn btn-warning cancel">
                    <i class="octicons octicon-circle-slash"></i>
                    <span><?php echo Yii::t('core', 'Cancel'); ?></span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}
</script>