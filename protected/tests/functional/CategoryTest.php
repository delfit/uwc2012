<?php

class CategoryTest extends WebTestCase
{

	public $fixtures = array(
		'categories' => 'Category',
		'сategoryTranslations' => 'CategoryTranslation',
	);


	public function testCRUD() {
		$dummyCategoryCreate = array(
			'SingularName' => 'Фотоаппараты',
			'PluralName' => 'Фотоаппараты',
		);
		
		$dummyCategoryUpdate = array(
			'SingularName' => 'Видеокамеры',
			'PluralName' => 'Видеокамеры',
		);
		
		
		$this->login();
		$this->openPage( '/category/create' );
		
		
		// создать категорию
		$this->assertTextPresent( Yii::t( 'category', 'New Category' ) );
		$this->assertElementPresent( 'name=Category[ParentCategoryID]' );
		$this->select( 'name=Category[ParentCategoryID]', 'value=' . $this->categories[ 'tvPhotoAndVideo' ][ 'CategoryID' ] );
		$this->type( 'name=Category[PluralName]', $dummyCategoryCreate[ 'SingularName' ] );
		$this->type( 'name=Category[SingularName]', $dummyCategoryCreate[ 'PluralName' ] );
		$this->clickAndWait( "css=button:contains('" . Yii::t( 'application', 'Add' ) . "')" );
		$this->assertTextPresent( Yii::t( 'category', 'Category ":categoryName" created', array( ':categoryName' => $dummyCategoryCreate[ 'PluralName' ] ) ) );
		$this->assertElementPresent( "css=option:contains('" . $this->сategoryTranslations[ 'tvPhotoAndVideo' ][ 'PluralName' ] . ' ' . $dummyCategoryCreate[ 'PluralName' ] . "')" );
		$this->assertElementPresent( "css=.navbar li.nav-header:contains('" . $dummyCategoryCreate[ 'PluralName' ] . "')" );
		
		
		// обновить категорию
		$this->assertElementPresent( "css=button:contains('" . Yii::t( 'application', 'Save' ) . "')" );
		$this->type( 'name=Category[PluralName]', $dummyCategoryUpdate[ 'SingularName' ] );
		$this->type( 'name=Category[SingularName]', $dummyCategoryUpdate[ 'PluralName' ] );
		$this->clickAndWait( "css=button:contains('" . Yii::t( 'application', 'Save' ) . "')" );
		$this->assertTextPresent( Yii::t( 'category', 'Category updated' ) );
		$this->assertElementPresent( "css=option:contains('" . $this->сategoryTranslations[ 'tvPhotoAndVideo' ][ 'PluralName' ] . ' ' . $dummyCategoryUpdate[ 'PluralName' ] . "')" );
		$this->assertElementPresent( "css=.navbar li.nav-header:contains('" . $dummyCategoryUpdate[ 'PluralName' ] . "')" );
		$this->assertElementNotPresent( "css=option:contains('" . $this->сategoryTranslations[ 'tvPhotoAndVideo' ][ 'PluralName' ] . ' ' . $dummyCategoryCreate[ 'PluralName' ] . "')" );
		$this->assertElementNotPresent( "css=.navbar li.nav-header:contains('" . $dummyCategoryCreate[ 'PluralName' ] . "')" );
		
		
		// удалить категорию
		$this->openHomePage();
		$this->waitForElementPresent( "css=h4:contains('" . $dummyCategoryUpdate[ 'PluralName' ] . "')" );
		$this->assertElementPresent( "css=h4:contains('" . $dummyCategoryUpdate[ 'PluralName' ] . "')" );
		$this->chooseOkOnNextConfirmation();
		$this->clickAndWait( "css=h4:contains('" . $dummyCategoryUpdate[ 'PluralName' ] . "') i.icon-trash" );
		$this->assertTextPresent( Yii::t( 'category', 'Category ":categoryName" was deleted', array( ':categoryName' => $dummyCategoryUpdate[ 'PluralName' ] ) ) );
		$this->assertElementNotPresent( "css=h4:contains('" . $dummyCategoryUpdate[ 'PluralName' ] . "')" );
		$this->assertElementNotPresent( "css=.navbar li.nav-header:contains('" . $dummyCategoryCreate[ 'PluralName' ] . "')" );
	}

}
