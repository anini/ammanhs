<?php
return array(
'components'=>array(
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
);


