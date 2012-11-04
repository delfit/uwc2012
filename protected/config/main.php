<?php
// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath' => dirname( __FILE__ ) . DIRECTORY_SEPARATOR . '..',
	
	'name' => 'UWC2012',
	
	'language' => 'uk', 
	
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
		
		'cache' => array(
			// TODO изменить на CFileCache
			'class' => 'system.caching.CFileCache' // CFileCache, CDummyCache
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
				array( 'site/index', 'pattern' => '<lc:\w{2,3}>/', 'verb' => 'GET' ),
				
				// login page
				array( 'site/login', 'pattern' => '<lc:\w{2,3}>/login' ),
				array( 'site/login', 'pattern' => 'login' ),
				
				array( 'site/logout', 'pattern' => '<lc:\w{2,3}>/logout' ),
				array( 'site/logout', 'pattern' => 'logout' ),
				

				// brands
				array( 'brand/list', 'pattern' => '<lc:\w+>/brands', 'verb' => 'GET' ),
				array( 'brand/list', 'pattern' => 'brands', 'verb' => 'GET' ),
				'brands/<tag:.*?>' => 'brand/list',
				
				array( 'brand/delete', 'pattern' => '<lc:\w+>/brand/delete/<id:\w+>' ),
				

				// features
				array( 'feature/list', 'pattern' => '<lc:\w+>/features', 'verb' => 'GET' ),
				array( 'feature/list', 'pattern' => 'features', 'verb' => 'GET' ),
				'features/<tag:.*?>' => 'feature/list',
				
				array( 'feature/delete', 'pattern' => '<lc:\w+>/feature/delete/<id:\w+>' ),
				
				
				// categories 
				array( 'category/create', 'pattern' => '<lc:\w+>/category' ),
				array( 'category/create', 'pattern' => 'category' ),
				
				array( 'category/update', 'pattern' => '<lc:\w+>/category/update/<id:\d+>' ),
				array( 'category/update', 'pattern' => 'category/<id:\d+>' ),
				
				array( 'category/delete', 'pattern' => '<lc:\w+>/category/delete/<id:\d+>' ),
				
				
				//  products
                array( 'product/search', 'pattern' => '<lc:\w+>/search', 'verb' => 'GET' ),
				array( 'product/search', 'pattern' => 'search', 'verb' => 'GET' ),
				
				array( 'product/list', 'pattern' => '<lc:\w+>/products/<cid:\d+>', 'verb' => 'GET' ),
				array( 'product/list', 'pattern' => 'products/<cid:\d+>', 'verb' => 'GET' ),
				'products' => 'product/list',
				
				array( 'product/view', 'pattern' => '<lc:\w+>/product/<id:\d+>', 'verb' => 'GET' ),
				array( 'product/view', 'pattern' => 'product/<id:\d+>', 'verb' => 'GET' ),
				
				array( 'product/create', 'pattern' => '<lc:\w+>/product/create/<cid:\d+>' ),
				array( 'product/create', 'pattern' => '<lc:\w+>/product/create' ),
				array( 'product/create', 'pattern' => 'product/create/<cid:\d+>' ),
				array( 'product/create', 'pattern' => 'product/create' ),
				
				array( 'product/update', 'pattern' => '<lc:\w+>/product/update/<id:\d+>' ),
				array( 'product/update', 'pattern' => 'product/update/<id:\d+>' ),

				array( 'product/delete', 'pattern' => '<lc:\w+>/product/delete/<id:\d+>' ),
				array( 'product/delete', 'pattern' => 'product/delete/<id:\d+>' ),
				
				array( 'product/compare', 'pattern' => '<lc:\w+>/product/compare/<cid:\d+>' ),
				array( 'product/compare', 'pattern' => 'product/compare/<cid:\d+>' ),
				
				
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
			'pageSize' => 2,
			'countImagesPerProduct' => 5,
			'countImagesPerCarousel' => 3
		),
		
		'imagesFolder' => 'images',
		
		// количество колонок на главной странице
		'mainPageColumnsCount' => 3
	),
);
