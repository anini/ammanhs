<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	// NOTE: we should not set different names because keyPrefix will change based on it
    //'name'=>'My Console Application',

    'commandMap'=>array(
        'migrate'=>array(
            'class'=>'system.cli.commands.MigrateCommand',
            'templateFile'=>'application.migrations.template',
        ),
    ),

	// application components
	'components'=>array(
        'request' => array(
            'class'=>'CHttpRequest',
            'hostInfo' => 'http://ammanhs.com',
            'baseUrl' => '',
            'scriptUrl' => '',
        ),
       'controller' => array(
            'class'=>'FakeController',
        ),
       /*
        'authManager'=>array(
            'class'=>'CachingDbAuthManager',
            'connectionID'=>'db',
            'cacheID'=>'commoncache',
        ),
        */
	),
);