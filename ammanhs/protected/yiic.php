<?php

defined('YII DEBUG') or define('YII DEBUG',true);
$yii = dirname(__FILE__).'/../../yii/framework/yii.php';
require_once($yii);

$config = CMap::mergeArray(
	  require(dirname(__FILE__).'/config/main.php')
	, require(dirname(__FILE__).'/config/console.php')
);


unset($config['theme']);
unset($config['defaultController']);

// reset request to be same as host param from local.php
$config['components']['request']['hostInfo']='http://'.$config['params']['host'];

$yiic = dirname(__FILE__).'/../../yii/framework/yiic.php';
require_once($yiic);