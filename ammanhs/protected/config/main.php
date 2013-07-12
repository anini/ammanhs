<?php

setlocale(LC_ALL, 'en_US.UTF-8');

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return CMap::mergeArray(
 array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Amman Hackerspace - فضاء المتمكنين | عمّان',
	
	'language'=>'ar',
  	'sourceLanguage'=>'00',
	
	// preloading 'log' component
	'preload'=>array(
		'log',
	),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.components.widgets.*',
		'application.lib.*',
		//'application.extensions.solr.*',
		//'application.extensions.redis.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123',
		 	// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		
	),

	// application components
	'components'=>array(
		'user'=>array(
			'class' => 'WebUser',
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),

		'clientScript'=>array(
			'class'=>'application.components.minify.EClientScript',
			'combineScriptFiles'=>false, // By default this is set to false, set this to true if you'd like to combine the script files
			'combineCssFiles'=>false, // By default this is set to false, set this to true if you'd like to combine the css files
			'optimizeCssFiles'=>true,  // @since: 1.1
			'optimizeScriptFiles'=>true,   // @since: 1.1
		),

		// uncomment the following to enable URLs in path-format		
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'rules'=>array(
				''=>'site/index',
				'/sitemap.xml'=>'site/sitemap',
				'contact'=>'site/contact',
				'about'=>'site/about',
				'login'=>'user/login',
				'logout'=>'user/logout',
				'signup'=>'user/signup',
				'connect'=>'user/connect',
				'settings'=>'user/profile',
				'search'=>'search/search',
				//'user/<id:\w+>'=>'user/view',
				'gii'=>'gii',
				'<controller:\w+>'=>'<controller>/index',
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),

		'cache'=>array(
			'class'=>'CFileCache',
			//'class'=>'PerNodeRedisCache',
			//'class'=>'CRedisCache',
		),

		'commoncache'=>array(
			'class'=>'CFileCache',
			//'class'=>'CRedisCache',
		),

		//'redis'=>array(
		//	'class'=>'CRedisCache',
			// if you dont set up the servers options it will use the default values
			/*
			'servers'=>array(
				array('host'=>'127.0.0.1', 'port'=>6379, ),
			),
			*/
		//),

		'request'=>array(
			'enableCsrfValidation'=>true,
			'csrfTokenName'=>'ammanhs_csrf',
			'enableCookieValidation'=>true,
		),

		// store session on Database
		'session'=>array(
			'class'=>'SelectiveCacheHttpSession',
			'cacheID'=>'commoncache',
			'timeout' => 86400, // one day
			'sessionName' => 'AmmanHS',
			//'autoStart'=> false,
			'cookieParams'=>array('domain'=>'.ammanhs.com'),
		),

		'authManager'=>array(
			//'class'=>'CachingDbAuthManager',
			'class'=>'CDbAuthManager',
			'connectionID'=>'db',
			//'cacheID'=>'commoncache',
		),

		'AmmanHSSearch'=>array(
			'class'=>'CSolrComponent',
			'host'=>'localhost',
			'port'=>8983,
			'indexPath'=>'/solr/ammanhs'
		),
		
		/*
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/ammanhs.db',
		),
		*/

		// uncomment the following to use a MySQL database
		'db'=>array(
			'class'=>'CDbConnection',
			'tablePrefix'=>'tbl_',
			'connectionString'=>'mysql:host=localhost;dbname=ammanhs',
			'emulatePrepare'=>true,
			'username'=>'root',
			'password'=>'',
			'charset'=>'utf8',
			//'schemaCachingDuration'=>3600,
			'enableProfiling'=>true,
		),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
            'errorAction'=>'site/error',
        ),

		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'admin_email'=>'anini@ammanhs.com',
		'support_email'=>'info@ammanhs.com',
		'host'=>'ammanhs.com',
		'static_host'=>'ammanhs.com',
	),
	),
	require(dirname(__FILE__).'/local.php')
);