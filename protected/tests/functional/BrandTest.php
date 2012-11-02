<?php

class BrandTest extends WebTestCase
{

	public $fixtures = array(
		'brands' => 'Brand',
		'products' => 'Product',
	);
	
	
	private function login() {
		$this->open( '/site/login' );
		$this->assertElementPresent( 'name=LoginForm[username]' );
		$this->type( 'name=LoginForm[username]', 'admin' );
		$this->type( 'name=LoginForm[password]', 'admin' );
		$this->clickAndWait( "//input[@value='Login']" );
		$this->assertTextPresent( Yii::t( 'application', 'Logined successful' ) );
	}


	public function testCRUD() {
		$dummyBrand = array(
			'Name' => 'Dummy Brand'
		);
		
		
		$this->login();
		$this->open( '/brands' );
		
		// создать производителя
		$this->assertElementPresent( 'name=Brand[Name]' );
		$this->type( 'name=Brand[Name]', $dummyBrand[ 'Name' ] );
		$this->clickAndWait( "css=button:contains('" . Yii::t( 'brand', 'Add' ) . "') " );
		$this->assertTextPresent( Yii::t( 'brand', 'Brand ":brandName" created', array( ':brandName' => $dummyBrand[ 'Name' ] ) ) );
		$this->assertElementPresent( "css=a:contains('" . $dummyBrand[ 'Name' ] . "')" );
		
		// попробовать создать производителя с тем же самым именем
		$this->type( 'name=Brand[Name]', $dummyBrand[ 'Name' ] );
		$this->clickAndWait( "css=button:contains('" . Yii::t( 'brand', 'Add' ) . "')" );
		$this->assertElementPresent( 'css=.alert-error' );
		
		// удалить производитель
		$this->chooseOkOnNextConfirmation();
		$this->clickAndWait( "css=tr:contains('" . $dummyBrand[ 'Name' ] . "') i.icon-trash" );
		$this->assertTextPresent( Yii::t( 'brand', 'Brand ":brandName" was deleted', array( ':brandName' => $dummyBrand[ 'Name' ] ) ) );
		$this->assertElementNotPresent( "css=a:contains('" . $dummyBrand[ 'Name' ] . "')" );
	}

}
