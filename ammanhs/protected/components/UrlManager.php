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
		// Replace & with and
		$string=str_replace(array(' & ', '&'), array(' and ', ' and '), $string);
		// Sequeze spaces
    	$string=preg_replace('/\s+/', ' ', $string);
    	// Raplace underscores, whitespaces and some special characters with dash
    	$string=preg_replace('/[\s_\/\.+:]+/', '-', $string);
		// Remove non letter or digits
		$string=preg_replace('/[^\pL\s0-9+-:]+/u', '', $string);
		// Remove dashes before and after + and :
		// $string=preg_replace('/[-]?([\+|:]+)[-]?/', '$1', $string);
		// Sequeze dashes
    	$string=preg_replace('/-{2,}/', '-', $string);
	    
	    return $string;
	}

}
