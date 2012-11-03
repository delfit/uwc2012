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
		
		'session' => array (
			'autoStart' => true,
		),
			
		'urlManager' => array(
			'urlFormat' => 'path',
			
			'rules' => array(
				// index page
				'<tag:.*?>', 'pattern' => 'site/index',
				array( 'site/index', 'pattern' => '<lc:\w{2,3}>/', 'verb' => 'GET' ),
				array( 'site/index', 'pattern' => '<lc:\w{2,3}>/site/index', 'verb' => 'GET' ),
				
				'brands/<tag:.*?>' => 'brand/list',
				// brands
				array( 'brand/list', 'pattern' => 'brands', 'verb' => 'GET' ),
				array( 'brand/list', 'pattern' => '<lc:\w+>/brands', 'verb' => 'GET' ),
				array( 'brand/delete', 'pattern' => '<lc:\w+>/brand/delete/<id:\w+>' ),
				
				'features/<tag:.*?>' => 'feature/list',
				// features
				array( 'feature/list', 'pattern' => 'features', 'verb' => 'GET' ),
				array( 'feature/list', 'pattern' => '<lc:\w+>/features', 'verb' => 'GET' ),
				array( 'feature/delete', 'pattern' => '<lc:\w+>/feature/delete/<id:\w+>' ),
				
				
				// categories   
				array( 'feature/delete', 'pattern' => '<lc:\w+>/category/delete/<id:\d+>' ),
				
				'products/<tag:.*?>' => 'product/list',
				//  products
                array( 'product/search', 'pattern' => '<lc:\w+>/search', 'verb' => 'GET' ),
				array( 'product/list', 'pattern' => '<lc:\w+>/products', 'verb' => 'GET' ),
				array( 'product/view', 'pattern' => '<lc:\w+>/product/<id:\d+>', 'verb' => 'GET' ),
                            
                array( 'product/search', 'pattern' => 'search', 'verb' => 'GET' ),
				array( 'product/list', 'pattern' => 'products', 'verb' => 'GET' ),
				array( 'product/view', 'pattern' => 'product/<id:\d+>', 'verb' => 'GET' ),
				
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
			'pageSize' => 10,
			'countImagesPerProduct' => 5
		),
		
		'imagesFolder' => 'images',
		
		// количество колонок на главной странице
		'mainPageColumnsCount' => 3
	),
);
