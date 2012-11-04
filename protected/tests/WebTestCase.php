<?php

/**
 * Change the following URL based on your server configuration
 * Make sure the URL ends with a slash so that we can use relative URLs in test cases
 */
define( 'TEST_BASE_URL', 'http://test.uwc2012.delfit.loc/' );


/**
 * The base class for functional test cases.
 * In this class, we set the base URL for the test application.
 * We also provide some common methods to be used by concrete test classes.
 */
class WebTestCase extends CWebTestCase
{

	/**
	 * Sets up before each test method runs.
	 * This mainly sets the base URL for the test application.
	 */
	protected function setUp() {
		parent::setUp();
		$this->setBrowserUrl( TEST_BASE_URL );
	}
	
	
	/**
	 * Выполняет вход на сайт
	 * 
	 */
	protected function login() {
		// перейти на главную
		$this->openHomePage();
		$this->clickAndWait( "css=.navbar a:contains('" . Yii::t( 'application', 'Login' ) . "')" );
		
		$this->assertElementPresent( 'name=LoginForm[username]' );
		$this->type( 'name=LoginForm[username]', 'admin' );
		$this->type( 'name=LoginForm[password]', 'admin' );
		$this->clickAndWait( "//input[@value='" . Yii::t( 'application', 'Login' ) . "']" );
		$this->assertTextPresent( Yii::t( 'application', 'Logined successful' ) );
	}
	
	
	/**
	 * Перейти на главную страницу 
	 * 
	 */
	protected function openHomePage() {
		$this->openPage( '' );
		$this->open( Yii::app()->language );
	}
	
	
	protected function openPage( $url ) {
		$this->open( Yii::app()->language . $url );
	}

}
