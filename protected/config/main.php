<?php
// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath' => dirname( __FILE__ ) . DIRECTORY_SEPARATOR . '..',
	
	'name' => 'UWC2012',
	
	'language' => 'ru', 
	
	// preloading 'log' component
	'preload' => array( 
		'log',
		
		php_sapi_name() !== 'cli' ? 'bootstrap' : '',
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
				'brands/<tag:.*?>' => 'brand/list',
				// REST categories
				array( 'brand/list', 'pattern' => 'brands', 'verb' => 'GET' ),
				array( 'brand/view', 'pattern' => 'brand/<id:\d+>', 'verb' => 'GET' ),
				array( 'brand/update', 'pattern' => 'brand/<id:\d+>', 'verb' => 'PUT' ),
				array( 'brand/delete', 'pattern' => 'brand/<id:\d+>', 'verb' => 'DELETE' ),
				array( 'brand/create', 'pattern' => 'brand', 'verb' => 'POST' ),
				
				
				'categories/<tag:.*?>' => 'category/list',
				// REST categories
				array( 'category/list', 'pattern' => '<lc:\w+>/categories', 'verb' => 'GET' ),
				array( 'category/view', 'pattern' => '<lc:\w+>/category/<id:\d+>', 'verb' => 'GET' ),
				array( 'category/update', 'pattern' => '<lc:\w+>/category/<id:\d+>', 'verb' => 'PUT' ),
                            
                                array( 'category/list', 'pattern' => 'categories', 'verb' => 'GET' ),
				array( 'category/view', 'pattern' => 'category/<id:\d+>', 'verb' => 'GET' ),
				array( 'category/update', 'pattern' => 'category/<id:\d+>', 'verb' => 'PUT' ),
                            
				array( 'category/delete', 'pattern' => 'category/<id:\d+>', 'verb' => 'DELETE' ),
				array( 'category/create', 'pattern' => 'category', 'verb' => 'POST' ),
				
				
				'products/<tag:.*?>' => 'product/list',
				// REST products
                                array( 'product/search', 'pattern' => '<lc:\w+>/search', 'verb' => 'GET' ),
				array( 'product/list', 'pattern' => '<lc:\w+>/products', 'verb' => 'GET' ),
				array( 'product/view', 'pattern' => '<lc:\w+>/product/<id:\d+>', 'verb' => 'GET' ),
                            
                                array( 'product/search', 'pattern' => 'search', 'verb' => 'GET' ),
				array( 'product/list', 'pattern' => 'products', 'verb' => 'GET' ),
				array( 'product/view', 'pattern' => 'product/<id:\d+>', 'verb' => 'GET' ),
                            
				array( 'product/update', 'pattern' => '<lc:\w+>/product/<id:\d+>', 'verb' => 'PUT' ),
				array( 'product/delete', 'pattern' => 'product/<id:\d+>', 'verb' => 'DELETE' ),
				array( 'product/create', 'pattern' => 'product', 'verb' => 'POST' ),
				
				'languages/<tag:.*?>' => 'language/list',
				array( 'language/list', 'pattern' => 'languages', 'verb' => 'GET' ),
				
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
		'default' => array(
			'pageSize' => 1
		),
		
		'imagesFolder' => 'images',
		
		// количество колонок на главной странице
		'mainPageColumnsCount' => 3
	),
);
