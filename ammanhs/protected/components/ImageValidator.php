<?php

// FIXME: rebase this to extends from CFileValidator
class ImageValidator extends CValidator
{
	public $sub_dir;
	public $attributeName;

    protected function validateAttribute($model, $attribute){
    	if($this->attributeName){
    		$attr_val=eval('return $model->'.$this->attributeName.';');
    	}else{
    		$attr_val=$model->id;
    	}

    	if(!$this->sub_dir){
    		$this->sub_dir=strtolower(get_class($model));
    	}

    	if(property_exists(get_class($model), '_upload_index') && $model->_upload_index>=0){
    		$att="{$attribute}[{$model->_upload_index}]";
    	}else{
    		$att=$attribute;
    	}

        $uploader=CUploadedFile::getInstance($model, $att);

        if(null!==$uploader && $uploader instanceof CUploadedFile){
        	$timestamp  =hexdec('0x'.substr(uniqid(), -8));
        	//$sub_dir    =$this->sub_dir.'/'.($timestamp%100).'/';
            $sub_dir    =$this->sub_dir.'/'.$model->id.'/';
        	$file_name  =Text::slugify($attr_val.'-'.$timestamp).'.'.$uploader->getExtensionName();
        	$images_path=Yii::app()->getBasePath().DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR;
			@mkdir($images_path.$sub_dir, 0777, true);
            $file=$images_path.$sub_dir.$file_name;
            if(!$uploader->saveAs($file)){
            	$this->addError($model, $attribute, $this->message);
            	return;
            }
			$model->$attribute=$sub_dir.$file_name;
		}
	}

    /**
     * @author  Mohammad Anini
     * @param   string $sub_directory:      Where to save the file
     * @param   int $activity_id:           ID of the activity
     * @param   string $extension:          Extension of the output file
     * @return  string Sub/directoy/file_name.ext
     */
    public static function generateFilename($sub_directory='thread', $object_id=0, $extension='jpg')
    {
        $timestamp=hexdec('0x'.substr(uniqid(),-8));
        //$sub_directory=$sub_directory.'/'.($timestamp%100).'/';
        $sub_directory=$sub_directory.'/'.$object_id.'/';
        $file_name=Text::slugify($object_id.'-'.$timestamp).'.'.$extension;
        return $sub_directory.$file_name;
    }
}