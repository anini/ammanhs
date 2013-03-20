<?php

class Img
{
    public static function absolutePath($img) {
        return Yii::app()->basePath."/../images/${img}";
    }

    public static function uri($img, $w=false, $h=false, $def=false, $format='.jpg') {
      $host=isset(Yii::app()->params['static_host'])?Yii::app()->params['static_host']:Yii::app()->params['host'];
      if ($def===false) $def='default-male.png';
      if (!$img) {
        return "http://$host/images/${def}";
      }
      $img_u=str_replace('%2F', '/', rawurlencode($img)); // url encoded image
      if (!is_file(self::absolutePath($img))) {
          return "http://$host/images/${def}";
      }
      if (!$w) {
        return "http://$host/images/${img_u}";
      }
      return "http://$host/images/preview/${w}x${h}/${img_u}{$format}";
    }

    public static function embed($img, $w=false, $h=false, $def=false, $attr=false, $format='.jpg') {
      if (!is_array($attr)) $attr=array();
      if (!isset($attr["alt"]) && isset($attr["title"])) $attr["alt"]=$attr["title"];
      if(!isset($attr["alt"]) && !isset($attr["title"])){
          $attr["alt"] = $attr["title"] = Yii::t( 'core' , 'image' );
      }
      if (!$w) $size="";
      else $size=" width='${w}px' height='${h}px'";
      $a=" ";
      foreach($attr as $k=>$v) $a.=" $k='".CHtml::encode($v)."'";
      return '<img src="'.Img::uri($img, $w, $h, $def, $format).'" '.$size.$a.' />';
    }

    public static function a($img, $w=false, $h=false, $def=false, $attr=false, $aattr=false, $format='.jpg') {
      if (!is_array($attr)) $attr=array();
      if (!is_array($aattr)) $aattr=array();
      if (!isset($aattr["utm"])) $aattr["utm"]=''; // default UTM to empty string
      if (!isset($aattr["href"])) $aattr["href"]=Img::uri($img, false, false, $def, $format);
      if (!isset($aattr["title"]) && isset($attr["title"])) $aattr["title"]=$attr["title"];
      if (strpos($aattr["utm"], '?')===0) $aattr["utm"]=substr($aattr["utm"], 1); // remove ? from head of UTM if any
      // add UTM to $href
      if ($aattr["utm"]) $aattr["href"]=(strpos($aattr["href"], '?')===false)?$aattr["href"].'?'.$aattr["utm"]:$aattr["href"].$aattr["utm"];
      unset($aattr["utm"]); // unset UTM so that it won't appear in <a > tag
      $a=" ";
      foreach($aattr as $k=>$v) $a.=" $k=\"".CHtml::encode($v)."\"";
      return "<a $a>".Img::embed($img, $w, $h, $def, $attr, $format)."</a>";
    }

    public static function clearPreview($img) {
      $prefix=Yii::app()->getBasePath() . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'preview' . DIRECTORY_SEPARATOR."*x*";
      foreach(glob($prefix) as $d) {
      if (!is_dir($d)) continue;
      @unlink($d.DIRECTORY_SEPARATOR.$img.".jpg");
      }

    }
}