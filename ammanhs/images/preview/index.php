<?php
/***
 *
 * PHP image preview/ thumbnails maker
 * Muayyad Saleh Alsadi <alsadi@gmail.com>
 * this file is in public domain
 * 
 * the latest version can be obtained from 
 * http://git.ojuba.org/cgit/php_img_preview/snapshot/php_img_preview-master.tar.bz2
 ***/

include_once(dirname(__FILE__)."/settings.php");
if(Conf::$orig[0]!='/') Conf::$orig=dirname(__FILE__).'/'.Conf::$orig.'/';

function error($msg, $code=404){
	header('Content-Type: text/plain; charset=UTF-8', TRUE, $code);
	die($msg);
}

function load_image($fn){
	$w=null; $h=null; $type=null; $img=null;
	list($w, $h, $type)=getimagesize($fn);
	switch ($type){
		case IMAGETYPE_GIF: $img=imagecreatefromgif($fn); break;
		case IMAGETYPE_JPEG: $img=imagecreatefromjpeg($fn); break;
		case IMAGETYPE_PNG: $img=imagecreatefrompng($fn); break;
		default:
			error("unsupported image type for file [$fn]");
	}
	return array($w, $h, $type, $img);
}

function save_image_file($file_type, $src, $dst, $preset, $w, $h){
	if($file_type!='png' && $file_type!='jpeg') return error('unsupported file type');
	if($w>Conf::$max_width || $h>Conf::$max_height) return error('too big');
	if(isset(Conf::$sizes) && (!isset(Conf::$sizes[$preset]) || !Conf::$sizes[$preset])) error("not allowed size");
	$wms=Conf::$sizes[$preset];
	@mkdir(dirname($dst), 0777, true);
	if(!is_dir(dirname($dst))) error('could not create directory');
	list($w_src, $h_src, $type, $img_src)=load_image($src);
	$img_dst=imagecreatetruecolor($w, $h);  //  resample
	$bgcolor=imagecolorallocate($img_dst, 255, 255, 255);
	imagefilledrectangle($img_dst, 0, 0, $w-1, $h-1, $bgcolor);
	$w0=$w; $h0=$h; // keep original width and height before scalling
	$w0_src=$w_src; $h0_src=$h_src; // keep original source width and height before cropping
	switch(Conf::$aspect_handling){
		case 0:
			imagecopyresampled($img_dst, $img_src, floor(($w0-$w)/2), floor(($h0-$h)/2), 0, 0, $w, $h, $w_src, $h_src);
			break;
		case 1:
			$ratio=$w_src/$h_src;
			if($w/$h>$ratio) $w=floor($h*$ratio); else $h=floor($w/$ratio);
			imagecopyresampled($img_dst, $img_src, floor(($w0-$w)/2), floor(($h0-$h)/2), 0, 0, $w, $h, $w_src, $h_src);
			break;
		case 2:
			$ratio=$w/$h;
			if($w_src/$h_src>$ratio) $w_src=floor($h_src*$ratio); else $h_src=floor($w_src/$ratio);
			imagecopyresampled($img_dst, $img_src, 0, 0, floor(($w0_src-$w_src)/2), floor(($h0_src-$h_src)/2), $w, $h, $w_src, $h_src);
			break;
		default:
			error('unsupported aspect handling key.');
	}
	if(is_array($wms)){
		foreach($wms as $wm){
			if(is_array($wm)){
				if($wm[0]=="filter"){
					$ua=$wm; //array_merge(array(&$img_dst), array_slice($wm,1));
					$ua[0]=&$img_dst;
					call_user_func_array('imagefilter', $ua);
				}else{
					list($w_wm, $h_wm, $wm_type, $wm_img)=load_image(Conf::$orig.$wm[0]);
					$px=(sizeof($wm)>=4)?$wm[3]:0;
					$py=(sizeof($wm)>=5)?$wm[4]:0;
					imagecopy($img_dst, $wm_img, $px+($w0-$w_wm-2*$px)*$wm[1], $py+($h0-$h_wm+-2*$py)*$wm[2], 0, 0, $w_wm, $h_wm);
				}
			}else{ // tile
				list($w_wm, $h_wm, $wm_type, $wm_img)=load_image(Conf::$orig.$wm);
				imagesettile($img_dst, $wm_img);
				imagefilledrectangle($img_dst, 0, 0, $w0-1, $h0-1, IMG_COLOR_TILED);
			}
		}
	}
	// save new image
	if(!call_user_func("image$file_type",$img_dst, $dst, Conf::$qaulity[$file_type])) error("could not save image");
	imagedestroy($img_src);
	imagedestroy($img_dst);
}

function lock_aquire($lock_fn, $t=LOCK_EX){
	$fh=fopen($lock_fn, 'w+');
	flock($fh, $t);
	return $fh;
}

function lock_release($l, $lock_fn){
	flock($l, LOCK_UN);
	fclose($l);
	@unlink($lock_fn);
	return 0;
}

$fn=false;
$p=strrpos($_SERVER['SCRIPT_NAME'], '/');
if($p!=false){
	$fn=substr($_SERVER['REQUEST_URI'], $p+1);
}
if(!$fn) error('missing file name');
$fn=urldecode ($fn);
if(strstr($fn, '..')) error('double dots not allowed');

$locks_d=dirname(__FILE__).'/locks/';
@mkdir(dirname($locks_d), 0777, true);
if(!is_dir(dirname($locks_d))) die("could not create directory [$lock_d]\n");
$lock_fn=$locks_d.md5($fn);
$abs_dst=realpath(dirname(__FILE__)).'/'.$fn;
$a=array();
if(!preg_match('/^(([0-9]+)x([0-9]+)(?:_\w+)?)\/(.*(?:\.(png|jpe?g|gif)))\.(png|jpg)/i',$fn,$a)) error('wrong file name syntax');
$preset=$a[1];
$w=$a[2];
$h=$a[3];
$e1=strtolower($a[5]);
$e2=$a[6];
if($e2=='png' && $e1!='png' && $e1!='gif') error('wrong file name syntax');
$src=Conf::$orig.'/'.$a[4];
if(!file_exists($src)) error('original file does not exists!');

$l=lock_aquire($lock_fn);

if(!file_exists($abs_dst)){
	save_image_file(($e2=='png')?'png':'jpeg', $src, $abs_dst."~", $preset, $w, $h);
	rename($abs_dst."~", $abs_dst);
	if(Conf::$copy_to && is_dir(Conf::$copy_to) && $bucketName){
		$d=realpath(dirname(__FILE__));
		$dup_dst=Conf::$copy_to.substr($abs_dst, strlen($d));
		$dup_dst0='images/preview'.substr($abs_dst, strlen($d));
		@mkdir(dirname($dup_dst), 0777, true);
		if(!is_dir(dirname($dup_dst))) error('could not create copy directory');
	}
}

if($e2=='png') header('Content-Type: image/png', TRUE, 200);
else header('Content-Type: image/jpeg', TRUE, 200);

print file_get_contents($abs_dst);
lock_release($l, $lock_fn);