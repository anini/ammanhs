<?php

// FIXME: rebase this to extends from CFileValidator
class ImageValidator extends CValidator
{
	public $sub_dir;
	public $attributeName;

    protected function validateAttribute($model, $attribute){
    	if($this->attributeName){
    		$attr_val = eval('return $model->'.$this->attributeName.';');
    	}else{
    		$attr_val = $model->id;
    	}

    	if(!$this->sub_dir){
    		$this->sub_dir = get_class($model);
    	}

    	if(property_exists(get_class($model), '_upload_index') && $model->_upload_index>=0){
    		$att="{$attribute}[{$model->_upload_index}]";
    	}else{
    		$att=$attribute;
    	}

        $uploader = CUploadedFile::getInstance($model, $att);

        if(null !== $uploader && $uploader instanceof CUploadedFile){
        	$timestamp   = hexdec('0x'.substr(uniqid(), -8));
        	$sub_dir     = $this->sub_dir .'/'. ( $timestamp % 100 ) .'/';
        	$file_name   = Text::slugify($attr_val .'-'. $timestamp) . '.' . $uploader->getExtensionName();
        	$images_path = Yii::app()->getBasePath() . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR;
			@mkdir($images_path . $sub_dir, 0777, true);
            $file = $images_path . $sub_dir . $file_name;
            if(!$uploader->saveAs($file)){
            	$this->addError($model, $attribute, $this->message);
            	return;
            }
			$model->$attribute = $sub_dir . $file_name;
		}
	}
}