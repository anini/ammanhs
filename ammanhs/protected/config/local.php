<?php
return array(
'components'=>array(
		/*'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/jeeran-ii.db',
			'tablePrefix' => 'tbl_',
			//  'schemaCachingDuration' => 3600,
			 //'enableProfiling' => true,
		),
		// uncomment the following to use a MySQL database
		*/
		'db'=>array(
			'class' => 'CDbConnection',
			'tablePrefix' => 'tbl_',
			'connectionString' => 'mysql:host=localhost;dbname=ammanhs',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
			// 'schemaCachingDuration' => 3600,
			'enableProfiling' => true,
		),
		
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array( 'class' => 'CProfileLogRoute' ,),
				// uncomment the following to show log messages on web pages
				array(
					'class'=>'CWebLogRoute',
				),
				)
		), 
		'cache'=>array(
			'class'=>'CFileCache',
			//'class'=>'CMemCache',
			/*
			// override default config
			'servers'=>array(
			array('host'=>'server1', 'port'=>11211, 'weight'=>60,),
			array('host'=>'server2', 'port'=>11211, 'weight'=>40,),
			)
			*/
			//'class'=>'application.extensions.redis.CRedisCache',
			//'class'=>'application.extensions.redis.PerNodeRedisCache',
		),
		/*
    'readonlydb'=>array(
            'class'=>'CDbConnection',
            'tablePrefix' => 'tbl_',
            'connectionString' => 'mysql:host=localhost;dbname=Nov_29_2012',
            'emulatePrepare' => true,
            'username' => 'readonly',
            'password' => 'readonly',
            'charset' => 'utf8',
            'schemaCachingDuration' => 300,
            'enableProfiling' => false,
            'queryCacheID'=>'commoncache',
//            'schemaCacheID'=>'commoncache',
       ),
       
    'clientScript' => array(
              'class' => 'ext.minify.EClientScript',
              'combineScriptFiles' => true, // By default this is set to false, set this to true if you'd like to combine the script files
              'combineCssFiles' => true, // By default this is set to false, set this to true if you'd like to combine the css files
              'optimizeCssFiles' => true,  // @since: 1.1
              'optimizeScriptFiles' => true,   // @since: 1.1
            ),
/*
		'nodecache'=>array(
			'class'=>'CFileCache',
		),
		'commoncache'=>array(
			'class'=>'CFileCache',
		),
		'redis'=>array(
			'class'=>'CFileCache', // FIXME: just to remove it from main
		),
*/
/*
		'session' => array(
			'class' => 'SelectiveCacheHttpSession',
			'cacheID' => 'cache',
		)

        'commoncache'=>array(
            'class'=>'application.extensions.redis.CRedisCache',
            'servers'=>array('host'=>'127.0.0.1', 'port'=>6379, 'read_write_timeout' => 0),
            'keyPrefix'=>'jii:',
        ),
        'redis'=>array(
            'class'=>'application.extensions.redis.CRedisCache',
            'servers'=>array('host'=>'127.0.0.1', 'port'=>6379, 'read_write_timeout' => 0),
            'keyPrefix'=>'jii:',
        )
*/
/*
	// custom session engine
	'session' => array(
		'class' => 'system.web.CDbHttpSession',
		'connectionID' => 'db',
		),
*/
),
'params'=>array(
		// below some configration for s3
		'host'=>'local.ammanhs.com',
		'adminEmail'=>'mohd.anini@gmail.com',
)
);


