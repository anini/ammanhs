<?php

class Img{

	public static function absolutePath($img){
		return Yii::app()->basePath."/../images/${img}";
	}

	public static function uri($img, $w=false, $h=false, $def=false, $format='.jpg'){
		$host=isset(Yii::app()->params['static_host'])?Yii::app()->params['static_host']:Yii::app()->params['host'];
		if($def===false) $def='default-male.jpg';
		if(!$img){
			return self::uri($def, $w, $h, false, $format);
		}
		$img_u=str_replace('%2F', '/', rawurlencode($img)); // url encoded image
		if(!is_file(self::absolutePath($img))){
			return "http://$host/images/${def}";
		}
		if(!$w){
			return "http://$host/images/${img_u}";
		}
		return "http://$host/images/preview/${w}x${h}/${img_u}{$format}";
	}

	public static function embed($img, $w=false, $h=false, $def=false, $attr=false, $format='.jpg'){
		if(!is_array($attr)) $attr=array();
		if(!isset($attr["alt"]) && isset($attr["title"])) $attr["alt"]=$attr["title"];
		if(!isset($attr["alt"]) && !isset($attr["title"]) && !isset($attr["data-original-title"])){
			$attr["alt"] = $attr["title"] = Yii::t('core', 'Image');
		}
		if(!$w) $size="";
		else $size=" width='${w}px' height='${h}px'";
		$a=" ";
		foreach($attr as $k=>$v) $a.=" $k='".CHtml::encode($v)."'";
		return '<img src="'.Img::uri($img, $w, $h, $def, $format).'" '.$size.$a.' />';
	}

	public static function a($img, $w=false, $h=false, $def=false, $attr=false, $aattr=false, $format='.jpg'){
		if(!is_array($attr)) $attr=array();
		if(!is_array($aattr)) $aattr=array();
		if(!isset($aattr["utm"])) $aattr["utm"]=''; // default UTM to empty string
		if(!isset($aattr["href"])) $aattr["href"]=Img::uri($img, false, false, $def, $format);
		if(!isset($aattr["title"]) && isset($attr["title"])) $aattr["title"]=$attr["title"];
		if(strpos($aattr["utm"], '?')===0) $aattr["utm"]=substr($aattr["utm"], 1); // remove ? from head of UTM if any
		// add UTM to $href
		if($aattr["utm"]) $aattr["href"]=(strpos($aattr["href"], '?')===false)?$aattr["href"].'?'.$aattr["utm"]:$aattr["href"].$aattr["utm"];
		$a=" ";
		foreach($aattr as $k=>$v) $a.=" $k=\"".CHtml::encode($v)."\"";
		return "<a $a>".Img::embed($img, $w, $h, $def, $attr, $format)."</a>";
	}

	public static function clearPreview($img){
		$prefix=Yii::app()->getBasePath() . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'preview' . DIRECTORY_SEPARATOR."*x*";
		foreach(glob($prefix) as $d){
			if(!is_dir($d)) continue;
			@unlink($d.DIRECTORY_SEPARATOR.$img.".jpg");
		}
	}

	/**
     * @author  Mohammad Anini
     * @param   string $source_url:		Source URL of the original image
     * @param   string $sub_directory:	Where to save the image
     * @param   int $object_id:		Unique ID of the object
     * @param   string $extension:		Extension of the output file
     * @return  string Sub/directoy/file_name.ext
     */
	public static function cloneImg($source_url, $sub_directory='thread', $object_id=0, $extension='jpg'){
        // Generating the new image file name and creating the directory        
        $new_img_uri=ImageValidator::generateFilename($sub_directory, $object_id, $extension);
        $new_img=Yii::app()->basePath.'/../images/'.$new_img_uri;
        @mkdir(dirname($new_img), 0777, true);
        
        // Cloning the original image
        list($w, $h, $type)=getimagesize($source_url);
        switch($type){
			case IMAGETYPE_GIF:
				$source=imagecreatefromgif($source_url); break;
			case IMAGETYPE_JPEG:
				$source=imagecreatefromjpeg($source_url); break;
			case IMAGETYPE_PNG:
				$source=imagecreatefrompng($source_url); break;
			default:
				die("unsupported image type for file [$source_url]");
		}

        // Creating the new image
        imagejpeg($source, $new_img, 95);

        return 'http://'.Yii::app()->params['static_host'].'/images/'.$new_img_uri;
	}

	/**
     * @author  Mohammad Anini
     * @use		Cloning all external images in a content and replace the src with the cloned one
     * @param   string $content:		Content with might containes external images
     * @param   string $sub_directory:	Where to save the cloned image
     * @param   int $object_id:			Unique ID of the object
     * @param   string $extension:		Extension of the output file
     * @return  string Sub/directoy/file_name.ext
     */
	public static function cloneAllExternalImages($content, $sub_directory='thread', $object_id=0, $extension='jpg'){
        preg_match_all('/<[\s]*img[^src]*src="([^"]*)"[^>]*>/', $content, $matches, PREG_OFFSET_CAPTURE | PREG_SET_ORDER);
		$sources=array();
		foreach($matches as $matche){
			$sources[$matche[1][0]]=1;
		}
		foreach($sources as $source=>$value){
			if(strpos($source, Yii::app()->params['static_host'].'/images/'.$sub_directory.'/'.$object_id.'/')===false){

				$content=preg_replace("!$source!", Img::cloneImg($source, $sub_directory, $object_id, $extension), $content);
			}
		}
		return $content;
	}

}