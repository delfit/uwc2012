<?php

class FeaturesTest extends WebTestCase
{

	public $fixtures = array(
		'brands' => 'Brand',
		'categories' => 'Category',
		'сategoryTranslations' => 'CategoryTranslation',
		'features' => 'Feature',
		'featureTranslations' => 'FeatureTranslation',
		'products' => 'Product',
		'productHasFeatures' => 'ProductHasFeatures',
		'productHasImages' => 'ProductHasImages',
		'productTranslations' => 'ProductTranslation',
	);


	public function testCRUD() {
		$dummyFeatureCreate = array(
			'Name' => 'Dummy Feature',
			'Description' => 'Dummy Feature Description',
		);
		
		$dummyFeatureUpdate = array(
			'Name' => 'Updated Dummy Feature',
			'Description' => 'Updated Dummy Feature Description',
		);
		
		
		$this->login();
		$this->open( '/features' );
		
		
		// создать характеристику
		$this->assertTextPresent( Yii::t( 'feature', 'New Feature' ) );
		$this->assertElementPresent( 'name=Feature[CategoryID]' );
		$this->select( 'name=Feature[CategoryID]', 'value=' . $this->categories[ 'notebooks' ][ 'CategoryID' ] );
		$this->waitForElementPresent( "css=div.grid-view td a:contains('" . $this->featureTranslations[ 'screen' ][ 'Name' ] . "')" );
		$this->type( 'name=Feature[Name]', $dummyFeatureCreate[ 'Name' ] );
		$this->type( 'name=Feature[Description]', $dummyFeatureCreate[ 'Description' ] );
		$this->clickAndWait( "css=button:contains('" . Yii::t( 'application', 'Add' ) . "')" );
		$this->assertTextPresent( Yii::t( 'feature', 'Feature ":featureName" created', array( ':featureName' => $dummyFeatureCreate[ 'Name' ] ) ) );
		sleep(5);
		$this->assertElementPresent( "css=div.grid-view td a:contains('" . $dummyFeatureCreate[ 'Name' ] . "')" );
		
		
		// проверить наличие новой характеристики в редакторе товара
		$this->clickAndWait( "css=.navbar ul li a:contains('" . $this->сategoryTranslations[ 'notebooks' ][ 'PluralName' ] . "')" );
		$this->clickAndWait( "css=h4:contains('" . $this->products[ 'asus_u31sd' ][ 'Name' ] . "') a i.icon-pencil" );
		$this->assertElementPresent( "css=label:contains('" . $dummyFeatureCreate[ 'Name' ] . "')" );
		
		
		// обновить характеристику
		$this->open( '/features' );
		$this->select( 'name=Feature[CategoryID]', 'value=' . $this->categories[ 'notebooks' ][ 'CategoryID' ] );
		$this->waitForElementPresent( "css=div.grid-view td a:contains('" . $dummyFeatureCreate[ 'Name' ] . "')" );
		
		$this->click( "css=div.grid-view td a:contains('" . $dummyFeatureCreate[ 'Name' ] . "')" );
		$this->waitForElementPresent( 'css=form.form-inline input' );
		$this->type( 'css=form.form-inline input', $dummyFeatureUpdate[ 'Name' ] );
		$this->click( 'css=form.form-inline i.icon-ok' );
		$this->waitForElementPresent( "css=div.grid-view td a:contains('" . $dummyFeatureUpdate[ 'Name' ] . "')" );
		$this->assertElementPresent( "css=div.grid-view td a:contains('" . $dummyFeatureUpdate[ 'Name' ] . "')" );
		
		
		// проверить наличие обновленной характеристики в редакторе товара
		$this->clickAndWait( "css=.navbar ul li a:contains('" . $this->сategoryTranslations[ 'notebooks' ][ 'PluralName' ] . "')" );
		$this->clickAndWait( "css=h4:contains('" . $this->products[ 'asus_u31sd' ][ 'Name' ] . "') a i.icon-pencil" );
		$this->assertElementPresent( "css=label:contains('" . $dummyFeatureUpdate[ 'Name' ] . "')" );
		
		
		// удалить характеристику
		$this->open( '/features' );
		$this->select( 'name=Feature[CategoryID]', 'value=' . $this->categories[ 'notebooks' ][ 'CategoryID' ] );
		$this->waitForElementPresent( "css=div.grid-view td a:contains('" . $dummyFeatureUpdate[ 'Name' ] . "')" );
		
		$this->chooseOkOnNextConfirmation();
		$this->clickAndWait( "css=div.grid-view tr:contains('" . $dummyFeatureUpdate[ 'Name' ] . "') i.icon-trash" );
		$this->assertTextPresent( Yii::t( 'feature', 'Feature ":featureName" was deleted', array( ':featureName' => $dummyFeatureUpdate[ 'Name' ] ) ) );
		$this->assertElementNotPresent( "css=div.grid-view td a:contains('" . $dummyFeatureUpdate[ 'Name' ] . "')" );
	}
	
	
	public function testRemoveFeatureInUse() {
		$this->login();
		$this->open( '/features' );
		
		// попробовать удалить используемую характеристику
		$this->select( 'name=Feature[CategoryID]', 'value=' . $this->categories[ 'notebooks' ][ 'CategoryID' ] );
		$this->waitForElementPresent( "css=div.grid-view td a:contains('" . $this->featureTranslations[ 'screen' ][ 'Name' ] . "')" );
		
		$this->chooseOkOnNextConfirmation();
		$this->clickAndWait( "css=div.grid-view tr:contains('" . $this->featureTranslations[ 'screen' ][ 'Name' ] . "') a i.icon-trash" );
		$this->assertTextPresent( Yii::t( 'feature', 'Feature ":featureName" used in products and can not be delated', array( ':featureName' => $this->featureTranslations[ 'screen' ][ 'Name' ] ) ) );
		$this->assertElementPresent( "css=div.grid-view td a:contains('" . $this->featureTranslations[ 'screen' ][ 'Name' ] . "')" );
	}

}
