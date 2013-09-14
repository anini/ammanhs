<?php

class UrlManager extends CUrlManager
{

	public function createAbsoluteUrl($route, $params=array(), $schema='', $ampersand='&'){
		$url=$this->createUrl($route,$params,$ampersand);

		if(strpos($url,'http')===0)
			return $url;
		else
			return (($schema)?$schema:'http').'://'.Yii::app()->params['host'].$url;
	}

	public function createUrl($route, $params=array(), $ampersand='&'){
		$route=trim($route, '/');
		$url=parent::createUrl($route, $params, $ampersand);

		// Add tailing slash except for sitemaps
		if(($ext=substr($url, -4))!='.xml' && $ext!='.gif'){
			if(strpos($url, '?')===false && (substr($url, -1)!='/')) $url.="/";
			else $url=str_replace('?', '/?', $url);
		}
		$url=str_replace('//', '/', $url);
		return $url;
	}

	public static function seoUrl($string){
		// Remove spaces before and after
		$string=trim($string);
	    // Lower case everything
	    // $string=strtolower($string);
	    // Make alphaunermic
	    $string=preg_replace("/[^a-z0-9_\s-][all_arabic_letters]/", "", $string);
	    // Clean multiple dashes or whitespaces
	    $string=preg_replace("/[\s-]+/", " ", $string);
	    // Convert whitespaces and underscore to dash
	    $string=preg_replace("/[\s_]/", "-", $string);
	    return $string;
	}

}
