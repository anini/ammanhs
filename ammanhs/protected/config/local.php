<?php
return array(
'components'=>array(
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
		'params'=>array(
		// this is used in contact page
		'admin_email'=>'anini@ammanhs.com',
		'host'=>'ammanhs.com',
		'static_host'=>'local.ammanhs.com',
	),
	),
);