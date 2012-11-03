<?php

class SiteTest extends WebTestCase
{

	public function testIndex() {
		$this->open( '' );
		
		$this->assertTextPresent( 'UWC2012' );
	}
	

	public function testLoginLogout() {
		$this->open('');
		
		// проверить, что пользователь не вошел
		$this->assertElementPresent( "css=.navbar a:contains('" . Yii::t( 'application', 'Login' ) . "')" );
		$this->assertElementNotPresent( "css=.navbar a:contains('" . Yii::t( 'application', 'Logout' ) . "')" );
		
		// проверить, что пользователь вошел
		$this->login();
		$this->assertElementNotPresent( "css=.navbar a:contains('" . Yii::t( 'application', 'Login' ) . "')" );
		$this->assertElementPresent( "css=.navbar a:contains('" . Yii::t( 'application', 'Logout' ) . "')" );
		
		// проверить, что пользователь вышел
		$this->clickAndWait( "css=.navbar a:contains('" . Yii::t( 'application', 'Logout' ) . "')" );
		$this->assertElementPresent( "css=.navbar a:contains('" . Yii::t( 'application', 'Login' ) . "')" );
		$this->assertElementNotPresent( "css=.navbar a:contains('" . Yii::t( 'application', 'Logout' ) . "')" );
	}
}
