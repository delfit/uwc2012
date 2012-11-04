<?php

class BrandTest extends WebTestCase
{

	public $fixtures = array(
		'brands' => 'Brand',
		'products' => 'Product',
	);


	public function testCRUD() {
		$dummyBrandCreate = array(
			'Name' => 'Dummy Brand'
		);
		
		$dummyBrandUpdate = array(
			'Name' => 'Updated Dummy Brand'
		);
		
		
		$this->login();
		$this->open( '/brands' );
		
		
		// создать производителя
		$this->assertElementPresent( 'name=Brand[Name]' );
		$this->type( 'name=Brand[Name]', $dummyBrandCreate[ 'Name' ] );
		$this->clickAndWait( "css=button:contains('" . Yii::t( 'application', 'Add' ) . "')" );
		$this->assertTextPresent( Yii::t( 'brand', 'Brand ":brandName" created', array( ':brandName' => $dummyBrandCreate[ 'Name' ] ) ) );
		$this->assertElementPresent( "css=div.grid-view td a:contains('" . $dummyBrandCreate[ 'Name' ] . "')" );
		
		
		// попробовать создать производителя с тем же самым именем
		$this->type( 'name=Brand[Name]', $dummyBrandCreate[ 'Name' ] );
		$this->clickAndWait( "css=button:contains('" . Yii::t( 'application', 'Add' ) . "')" );
		$this->assertElementPresent( 'css=.alert-error' );
		
		
		// обновить производителя
		$this->click( "css=div.grid-view td a:contains('" . $dummyBrandCreate[ 'Name' ] . "')" );
		$this->waitForElementPresent( 'css=form.form-inline input' );
		$this->type( 'css=form.form-inline input', $dummyBrandUpdate[ 'Name' ] );
		$this->click( 'css=form.form-inline i.icon-ok' );
		$this->waitForElementPresent( "css=div.grid-view td a:contains('" . $dummyBrandUpdate[ 'Name' ] . "')" );
		$this->assertElementPresent( "css=div.grid-view td a:contains('" . $dummyBrandUpdate[ 'Name' ] . "')" );
		
		
		// удалить производителя
		$this->chooseOkOnNextConfirmation();
		$this->clickAndWait( "css=div.grid-view tr:contains('" . $dummyBrandUpdate[ 'Name' ] . "') a i.icon-trash" );
		$this->assertTextPresent( Yii::t( 'brand', 'Brand ":brandName" was deleted', array( ':brandName' => $dummyBrandUpdate[ 'Name' ] ) ) );
		$this->assertElementNotPresent( "css=div.grid-view td aa:contains('" . $dummyBrandUpdate[ 'Name' ] . "')" );
	}

}
