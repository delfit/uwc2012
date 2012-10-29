<?php
// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath' => dirname( __FILE__ ) . DIRECTORY_SEPARATOR . '..',
	
	'name' => 'UWC 2012',
	
	// preloading 'log' component
	'preload' => array( 
		'bootstrap', 
		'log'
	),
	
	// autoloading model and component classes
	'import' => array(
		'application.models.*',
		'application.components.*',
	),
	
	'modules' => array(
		'gii' => array(
			'class' => 'system.gii.GiiModule',
			'password' => 'uwc2012',
			 // If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters' => array('127.0.0.1', '::1'),
			
			'generatorPaths' => array(
				'bootstrap.gii'
			),
		),
	),
	
	// application components
	'components' => array(
		'bootstrap' => array(
			'class' => 'ext.bootstrap.components.Bootstrap',
			'responsiveCss' => true,
		),
		
		'db' => array(
			'connectionString' => 'mysql:host=localhost;dbname=uwc2012',
			'emulatePrepare' => true,
			'username' => 'uwc2012',
			'password' => 'uwc2012',
			'charset' => 'utf8',
		),
		 
		'errorHandler' => array(
			// use 'site/error' action to display errors
			'errorAction' => 'site/error',
		),
		
		'log' => array(
			'class' => 'CLogRouter',
			'routes' => array(
				array(
					'class' => 'CFileLogRoute',
					'levels' => 'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
		
		'urlManager' => array(
			'urlFormat' => 'path',
			
			'rules' => array(
				'posts/<tag:.*?>' => 'product/list',
				// REST patterns
				array( 'product/list', 'pattern' => '/<model:\w+>', 'verb' => 'GET' ),
				array( 'product/view', 'pattern' => '/<model:\w+>/<id:\d+>', 'verb' => 'GET' ),
				array( 'product/update', 'pattern' => '/<model:\w+>/<id:\d+>', 'verb' => 'PUT' ),
				array( 'product/delete', 'pattern' => '/<model:\w+>/<id:\d+>', 'verb' => 'DELETE' ),
				array( 'product/create', 'pattern' => '/<model:\w+>', 'verb' => 'POST' ),
				// Other controllers
				'<controller:\w+>/<action:\w+>' => '<controller>/<action>',
			),

			// hide index.php in URLs
			'showScriptName' => false,
		),
	 

		
		'user' => array(
			// enable cookie-based authentication
			'allowAutoLogin' => true,
		),
	),
	
	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params' => array(
		// this is used in contact page
		'adminEmail' => 'webmaster@example.com',
	),
);