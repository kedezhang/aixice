<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here. 


return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'主服务',
	//设置系统默认控制器
	'defaultController'=>'Male',
	'preload'=>array('log'),
	'language'=>'zh_cn',
    'theme'=>'default',
	'timeZone'=>'Asia/Shanghai',
	'aliases' => array(
    ),
	'import'=>array(
		'application.models.*',
		'application.extensions.*'
	),
	'components'=>array(
		'cache'=>array(
	  		'class'=>'CFileCache',//文件缓存
		),
	    'db'=>array(
	        'enableParamLogging' => true,//增加这行
	        'connectionString' => 'mysql:host=sh-cynosdbmysql-grp-gdknqva6.sql.tencentcdb.com;dbname=thinkphp_demo;port=26830',
	        'emulatePrepare' => true,
	        'username' => 'root',
	        'password' => '4pJBzDX8',
	        'charset' => 'utf8',
	        'tablePrefix'=>'',
	        'enableParamLogging'=>true,
	        'class'=> 'CDbConnection' ,
	    ),
		'errorHandler'=>array(
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(//错误日志记录到error.log中  
					'class'=>'CFileLogRoute',
					'levels'=>'error',
					 'maxFileSize'=>30,//单文件最大30M 
					'logFile' => 'error.log',  
				),
			    array(//流程日志
			        'class'=>'CFileLogRoute',
			        'levels'=>'info',
			        'logFile' => 'message.log',
			        'maxFileSize'=>50,//日志大小100M
			        'maxLogFiles'=>200,//保存最大个数，Yii会按时间保留最近100个文件
			    )
			),
		)
	),
	'modules'=>array(	
	)
);