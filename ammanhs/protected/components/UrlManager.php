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
		// Remove spaces before and after - No need now, will be done late
		// $string=trim($string);
		// Replace & with and
		$string=str_replace(array(' & ', '&'), array(' and ', ' and '), $string);
		// Sequeze spaces - No need actually, since any space will be converted into dashe, and dashes gonna be sequezed
    	// $string=preg_replace('/\s+/', ' ', $string);
    	// Raplace underscores, whitespaces and some special characters with dash
    	$string=preg_replace('/[\s_\/\.+:]+/', '-', $string);
		// Remove non letter or digits
		$string=preg_replace('/[^\pL0-9-]+/u', '', $string);
		// Remove dashes before and after + and :
		// $string=preg_replace('/[-]?([\+|:]+)[-]?/', '$1', $string);
		// Sequeze dashes
    	$string=preg_replace('/-{2,}/', '-', $string);
		// Remove dashes in trails
		$string=preg_replace('/[-]+/', ' ', $string);
		$string=trim($string);
		$string=preg_replace('/[\s]+/', '-', $string);
	    
	    return $string;
	}

	public static function getShortLink($object_class, $object_id){
		return '/'.strtolower($object_class).'/'.$object_id;
	}

}
