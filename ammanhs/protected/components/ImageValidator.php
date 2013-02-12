<?php

// FIXME: rebase this to extends from CFileValidator
class ImageValidator extends CValidator
{
		public $sub_dir;
		public $attributeName;

        protected function s3upload($file) {
          // if s3 is not enabled then this is not an error
          if (!isset(Yii::app()->params['s3directory']) ||
              !Yii::app()->params['s3directory'] ||
              !is_dir(Yii::app()->params['s3directory'].'/images/')
              ) return true;
          $file=realpath($file);
          $img=strstr($file,'/images/');
          if (!$img) return false;
          $s3file=realpath(Yii::app()->params['s3directory']).$img;
          $d=dirname($s3file);
          @mkdir($d,0777,true);
          if (is_dir($d)) $r=copy($file, $s3file);
          else $r=false;
          if (!$r) @unlink($file); // FIXME:the case where $file already exists
          return $r;
        }

        protected function validateAttribute( $model , $attribute )
        {

			if( $this->attributeName ){
			     $attr_val = eval('return $model->'.$this->attributeName.';');
			} else {
			     $attr_val = $model->id;
			}

			if( !$this->sub_dir ){
			     $this->sub_dir = get_class( $model );
			}
            if (property_exists(get_class($model), '_upload_index') && $model->_upload_index>=0) $att="{$attribute}[{$model->_upload_index}]";
            else $att=$attribute;
            $uploader =  CUploadedFile::getInstance( $model, $att );

             if ( null !== $uploader && $uploader instanceof CUploadedFile ) {
				$timestamp = hexdec('0x'.substr(uniqid(),-8));
				$sub_dir   = $this->sub_dir .'/'. ( $timestamp % 100 ) .'/';
				$file_name = Text::slugify($attr_val .'-'. $timestamp) . '.' . $uploader->getExtensionName();

				$images_path = Yii::app()->getBasePath() . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR ;

				@mkdir( $images_path . $sub_dir  , 0777 , true );
                $file=$images_path . $sub_dir . $file_name;
                if (!$uploader->saveAs( $file ) || !$this->s3upload($file)) {
                    $this->addError($model, $attribute, $this->message);
                    return;
                }
				$model->$attribute = $sub_dir . $file_name;
             }
        }
}
