<?php

class ProductTest extends WebTestCase
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
		$dummyProductCreate = array(
			'CategoryID' => $this->categories[ 'notebooks' ][ 'CategoryID' ],
			'CategoryName' => $this->сategoryTranslations[ 'notebooks' ][ 'SingularName' ],
			'PluralCategoryName' => $this->сategoryTranslations[ 'notebooks' ][ 'PluralName' ],
			'BrandID' => $this->brands[ 'dell' ][ 'BrandID' ],
			'BrandName' => $this->brands[ 'dell' ][ 'Name' ],
			'Name' => 'Inspiron 14z Ultrabook',
			'Description' => 'Inspiron 14z Ultrabook толщиной всего 20,3 мм (0,8 дюйма) оснащен мощными процессорами вплоть до Intel Core 3-го поколения и обладает невероятно мобильным корпусом.',
			'features' => array(
				array(
					'Name' => $this->featureTranslations[ 'screen' ][ 'Name' ],
					'Value' => '14 [1366x768] 720p'
				)
			)
		);
		
		$dummyProductUpdate = array(
			'BrandID' => $this->brands[ 'samsung' ][ 'BrandID' ],
			'BrandName' => $this->brands[ 'samsung' ][ 'Name' ],
			'Name' => 'NP900X3C-A03RU',
			'Description' => 'Став владельцем ноутбука Samsung серии 9, Вы просто не захотите с ним расставаться!',
			'features' => array(
				array(
					'Name' => $this->featureTranslations[ 'screen' ][ 'Name' ],
					'Value' => '13,3 [1600x900]'
				)
			)
		);
		
		
		$this->login();
		$this->open( '/product/create' );
		
		
		// создать товар
		$this->assertTextPresent( Yii::t( 'product', 'New Product' ) );
		$this->assertElementPresent( 'name=Product[CategoryID]' );
		$this->select( 'name=Product[CategoryID]', 'value=' . $dummyProductCreate[ 'CategoryID' ] );
		$this->waitForElementPresent( "css=label:contains('" . $dummyProductCreate[ 'features' ][ 0 ][ 'Name' ] . "')" );
		$this->select( 'name=Product[BrandID]', 'value=' . $dummyProductCreate[ 'BrandID' ] );
		$this->type( 'name=Product[Name]', $dummyProductCreate[ 'Name' ] );
		$this->runScript( "javascript{ this.browserbot.getCurrentWindow().window.$( 'div.redactor_editor' ).text('" . $dummyProductCreate[ 'Description' ] . "'); }");
		$this->type( 'Product[Description]', $dummyProductCreate[ 'Description' ] );
		
		foreach( $dummyProductCreate[ 'features' ] as $feature ) {
			$this->type( "css=div.row:contains('" . $feature[ 'Name' ] . "') input[type=text]", $feature[ 'Value' ] );
		}
		
		$this->clickAndWait( "css=button:contains('" . Yii::t( 'application', 'Add' ) . "')" );
		$this->assertTextPresent( Yii::t( 'product', 'Product created' ) );
		
		
		// прочитать товар
		$this->clickAndWait( "css=h3 a:contains('" . $dummyProductCreate[ 'Name' ] . "')" );
		$this->assertElementPresent( "css=h3:contains('" . $dummyProductCreate[ 'CategoryName' ] . "')" );
		$this->assertElementPresent( "css=h3:contains('" . $dummyProductCreate[ 'BrandName' ] . "')" );
		$this->assertElementPresent( "css=h3:contains('" . $dummyProductCreate[ 'Name' ] . "')" );
		
		foreach( $dummyProductCreate[ 'features' ] as $feature ) {
			$this->assertElementPresent( "css=dl:contains('" . $feature[ 'Name' ] . "') dd:contains('" . $feature[ 'Value' ] . "')" );
		}
		
		$this->assertTextPresent( $dummyProductCreate[ 'Description' ] );
		
		
		// отредактировать товар
		$this->clickAndWait( "css=h3:contains('" . $dummyProductCreate[ 'Name' ] . "') a i.icon-pencil" );
		$this->assertElementPresent( 'name=Product[CategoryID]' );
		$this->select( 'name=Product[BrandID]', 'value=' . $dummyProductUpdate[ 'BrandID' ] );
		$this->type( 'name=Product[Name]', $dummyProductUpdate[ 'Name' ] );
		$this->runScript( "javascript{ this.browserbot.getCurrentWindow().window.$( 'div.redactor_editor' ).text('" . $dummyProductUpdate[ 'Description' ] . "'); }");
		$this->type( 'Product[Description]', $dummyProductUpdate[ 'Description' ] );
		
		foreach( $dummyProductUpdate[ 'features' ] as $feature ) {
			$this->type( "css=div.row:contains('" . $feature[ 'Name' ] . "') input[type=text]", $feature[ 'Value' ] );
		}
		
		$this->clickAndWait( "css=button:contains('" . Yii::t( 'application', 'Save' ) . "')" );
		$this->assertTextPresent( Yii::t( 'product', 'Product updated' ) );
		
		
		// прочитать товар
		$this->clickAndWait( "css=h3 a:contains('" . $dummyProductUpdate[ 'Name' ] . "')" );
		// катгорию менять нельзя
		$this->assertElementPresent( "css=h3:contains('" . $dummyProductCreate[ 'CategoryName' ] . "')" );
		$this->assertElementPresent( "css=h3:contains('" . $dummyProductUpdate[ 'BrandName' ] . "')" );
		$this->assertElementPresent( "css=h3:contains('" . $dummyProductUpdate[ 'Name' ] . "')" );
		
		foreach( $dummyProductUpdate[ 'features' ] as $feature ) {
			$this->assertElementPresent( "css=dl dd:contains('" . $feature[ 'Value' ] . "')" );
		}
		
		$this->assertTextPresent( $dummyProductUpdate[ 'Description' ] );
		

		// удалить товар
		$this->chooseOkOnNextConfirmation();
		$this->clickAndWait( "css=h3:contains('" . $dummyProductUpdate[ 'Name' ] . "') a i.icon-trash" );
		$fullProductName = $dummyProductCreate[ 'CategoryName' ] . ' ' . $dummyProductUpdate[ 'BrandName' ] . ' ' . $dummyProductUpdate[ 'Name' ];
		$this->assertTextPresent( Yii::t( 'product', 'Product ":productFullName" was deleted', array( ':productFullName' => $fullProductName ) ) );
		$this->assertElementNotPresent( "css=h4:contains('" . $fullProductName . "')" );
	}
	
	
	public function testCompare() {
		$this->open( 'site/index' );
		
		// перейти в категорию ноутбуков
		$this->clickAndWait( "css=li a:contains('" . $this->сategoryTranslations[ 'notebooks' ][ 'PluralName' ] . "')" );
		$this->assertElementPresent( "css=h2:contains('" . $this->сategoryTranslations[ 'notebooks' ][ 'PluralName' ] . "')" );
		
		
		// добавить к сравнению первый ноутбук
		$this->click( "css=div.row:contains('" . $this->products[ 'asus_u31sd' ][ 'Name' ] . "') a.compare-link" );
		$this->waitForElementPresent( "css=a.comparison-text:contains('" . Yii::t( 'product', ':count product(s) in comparison', array( ':count' => 1 ) ) . "')" );
		
		
		// добавить к сравнению второй ноутбук
		$this->click( "css=div.row:contains('" . $this->products[ 'hp_probook_4540s' ][ 'Name' ] . "') a.compare-link" );
		$this->waitForElementPresent( "css=a.comparison-text:contains('" . Yii::t( 'product', ':count product(s) in comparison', array( ':count' => 2 ) ) . "')" );
		
		
		// проверить страницу сравнения
		$this->clickAndWait( "css=a.comparison-text:contains('" . Yii::t( 'product', ':count product(s) in comparison', array( ':count' => 2 ) ) . "')" );
		$this->assertElementPresent( "css=th:contains('" . $this->products[ 'asus_u31sd' ][ 'Name' ] . "')" );
		$this->assertElementPresent( "css=th:contains('" . $this->products[ 'hp_probook_4540s' ][ 'Name' ] . "')" );
		
		$this->assertElementPresent( "css=tr:contains('" . $this->featureTranslations[ 'screen' ][ 'Name' ] . "') td:contains('" . $this->productHasFeatures[ 'asus_u31sd' ][ 'Value' ] . "')" );
		$this->assertElementPresent( "css=tr:contains('" . $this->featureTranslations[ 'screen' ][ 'Name' ] . "') td:contains('" . $this->productHasFeatures[ 'hp_probook_4540s' ][ 'Value' ] . "')" );
		
		
		// удалить ноутбук из сравнения
		$this->clickAndWait( "css=th:contains('" . $this->products[ 'asus_u31sd' ][ 'Name' ] . "') a i.icon-remove" );
		$fullProductName = $this->сategoryTranslations[ 'notebooks' ][ 'SingularName' ] . ' ' . $this->brands[ 'asus' ][ 'Name' ] . ' ' . $this->products[ 'asus_u31sd' ][ 'Name' ];
		$this->assertTextPresent( Yii::t( 'product', 'Product ":productName" removed from comparison', array( ':productName' => $fullProductName ) ) );
		$this->assertElementPresent( "css=th:contains('" . $this->products[ 'hp_probook_4540s' ][ 'Name' ] . "')" );
		$this->assertElementNotPresent( "css=th:contains('" . $this->products[ 'asus_u31sd' ][ 'Name' ] . "')" );
		
		
		// перейти в категорию планшетов
		$this->clickAndWait( "css=li a:contains('" . $this->сategoryTranslations[ 'tablets' ][ 'PluralName' ] . "')" );
		$this->assertElementPresent( "css=h2:contains('" . $this->сategoryTranslations[ 'tablets' ][ 'PluralName' ] . "')" );
		
		
		// добавить к сравнению первый планшет
		$this->click( "css=div.row:contains('" . $this->products[ 'samsung_galaxy_tab_2' ][ 'Name' ] . "') a.compare-link" );
		$this->waitForElementPresent( "css=a.comparison-text:contains('" . Yii::t( 'product', ':count product(s) in comparison', array( ':count' => 1 ) ) . "')" );
		
		
		// проверить страницу сравнения
		$this->clickAndWait( "css=a.comparison-text:contains('" . Yii::t( 'product', ':count product(s) in comparison', array( ':count' => 1 ) ) . "')" );
		$this->assertElementPresent( "css=th:contains('" . $this->products[ 'samsung_galaxy_tab_2' ][ 'Name' ] . "')" );
		$this->assertElementNotPresent( "css=th:contains('" . $this->products[ 'asus_u31sd' ][ 'Name' ] . "')" );
		$this->assertElementNotPresent( "css=th:contains('" . $this->products[ 'hp_probook_4540s' ][ 'Name' ] . "')" );
		
		
		// перейти обратно в категорию ноутбуков
		$this->clickAndWait( "css=li a:contains('" . $this->сategoryTranslations[ 'notebooks' ][ 'PluralName' ] . "')" );
		$this->assertElementPresent( "css=h2:contains('" . $this->сategoryTranslations[ 'notebooks' ][ 'PluralName' ] . "')" );
		
		
		// проверить страницу сравнения
		$this->clickAndWait( "css=a.comparison-text:contains('" . Yii::t( 'product', ':count product(s) in comparison', array( ':count' => 1 ) ) . "')" );
		$this->assertElementPresent( "css=th:contains('" . $this->products[ 'hp_probook_4540s' ][ 'Name' ] . "')" );
		$this->assertElementNotPresent( "css=th:contains('" . $this->products[ 'asus_u31sd' ][ 'Name' ] . "')" );
		$this->assertElementNotPresent( "css=th:contains('" . $this->products[ 'samsung_galaxy_tab_2' ][ 'Name' ] . "')" );
	}
	
	
	public function testSearch() {
		$this->open( 'site/index' );
		
		// проверить присутствие поля поиска
		$this->assertElementPresent( "css=.navbar input.search-query" );
		
		// найти товар по названию
		$this->type( 'css=.navbar form.form-search input.search-query', $this->products[ 'asus_u31sd' ][ 'Name' ] );
		$this->clickAndWait( "css=.navbar form.form-search button i.icon-search" );
		$this->assertElementPresent( "css=h4:contains('" . $this->products[ 'asus_u31sd' ][ 'Name' ] . "')" );
		$this->assertElementNotPresent( "css=h4:contains('" . $this->products[ 'samsung_galaxy_tab_2' ][ 'Name' ] . "')" );
		$this->assertElementNotPresent( "css=h4:contains('" . $this->products[ 'hp_probook_4540s' ][ 'Name' ] . "')" );
		
		// найти товар по бренду
		$this->type( 'css=.navbar form.form-search input.search-query', $this->brands[ 'samsung' ][ 'Name' ] );
		$this->clickAndWait( "css=.navbar form.form-search button i.icon-search" );
		$this->assertElementPresent( "css=h4:contains('" . $this->products[ 'samsung_galaxy_tab_2' ][ 'Name' ] . "')" );
		$this->assertElementNotPresent( "css=h4:contains('" . $this->products[ 'asus_u31sd' ][ 'Name' ] . "')" );
		$this->assertElementNotPresent( "css=h4:contains('" . $this->products[ 'hp_probook_4540s' ][ 'Name' ] . "')" );
		
		// найти товар по описанию
		$keywords = explode( ' ', $this->productTranslations[ 'hp_probook_4540s' ][ 'Description' ] );
		$this->type( 'css=.navbar form.form-search input.search-query', $keywords[ 0 ]. ' '. $keywords[ 2 ] );
		$this->clickAndWait( "css=.navbar form.form-search button i.icon-search" );
		$this->assertElementPresent( "css=h4:contains('" . $this->products[ 'hp_probook_4540s' ][ 'Name' ] . "')" );
		$this->assertElementNotPresent( "css=h4:contains('" . $this->products[ 'asus_u31sd' ][ 'Name' ] . "')" );
		$this->assertElementNotPresent( "css=h4:contains('" . $this->products[ 'samsung_galaxy_tab_2' ][ 'Name' ] . "')" );
		
		// найти товар по характеристике
		$this->type( 'css=.navbar form.form-search input.search-query', $this->productHasFeatures[ 'asus_u31sd' ][ 'Value' ] );
		$this->clickAndWait( "css=.navbar form.form-search button i.icon-search" );
		$this->assertElementPresent( "css=h4:contains('" . $this->products[ 'asus_u31sd' ][ 'Name' ] . "')" );
		$this->assertElementNotPresent( "css=h4:contains('" . $this->products[ 'hp_probook_4540s' ][ 'Name' ] . "')" );
		$this->assertElementNotPresent( "css=h4:contains('" . $this->products[ 'samsung_galaxy_tab_2' ][ 'Name' ] . "')" );
		
		// TODO сделать тест на поиск по категории
	}
}
