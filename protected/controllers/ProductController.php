<?php

class ProductController extends Controller
{
	/**
	 * @return array action filters
	 */
	public function filters() {
		return array(
			'accessControl +create,update,delete',
		);
	}
	
	
	/**
	 * Определяет правила доступа
	 * Используется в 'accessControl' фильтре.
	 * 
	 * @return array правила доступа
	 */
	public function accessRules() {
		return array(
			array( 'allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions' => array( 'create', 'update', 'delete' ),
				'users' => array( 'admin' ),
			),
			array( 'deny', // deny all users
				'users' => array( '*' ),
			),
		);
	}
	
	
	/**
	 * Поиск по товарам
	 * 
	 */
	public function actionSearch() {
		if( !isset( $_GET[ 'q' ] ) || empty( $_GET[ 'q' ] ) ) {
			$this->redirect( Yii::app()->homeUrl );
		}
		
		$query = htmlspecialchars( $_GET[ 'q' ] );

		$cid = null;
		if( isset( $_GET[ 'cid' ] ) && !empty( $_GET[ 'cid' ] ) ) {
			$cid = (integer) $_GET[ 'cid' ];
		}

		$products = Product::model()->searchList( $query, $cid );
		
		
		$this->pageTitle = Yii::t( 'application', 'Searсh results for' ) . ' «' . $query . '»';
		$this->breadcrumbs = array(
			Yii::t( 'application', 'Searсh' )
		);
		
		
		$this->render( 'list', array(
			'products' => $products,
			'searchQuery' => $query
		));
	}
	
	
	/**
	 * Список товаров
	 * 
	 * @throws CHttpException
	 */
	public function actionList() {
		$cid = isset( $_GET[ 'cid' ] ) ? (integer) $_GET[ 'cid' ] : null;

		if( empty( $cid ) ) {
			throw new CHttpException( 404, Yii::t( 'product', 'Category not defined' ) );
		}
		
		$category = Category::model()->findByPk( $cid );
		if( empty( $category ) ) {
			throw new CHttpException( 404, Yii::t( 'product', 'Category not found' ) );
		}
		
		$products = Product::model()->getList( $cid );
		
		
		$this->pageTitle = $category->PluralName;
		$this->breadcrumbs = array(
			$category->parentCategory->parentCategory->PluralName,
			$category->parentCategory->PluralName,
			$category->PluralName
		);
		
		
		$this->render( 'list', array(
			'products' => $products,
			'categoryID' => $cid,
		));
	}
     
	
	/**
	 * Просмотр товара
	 * 
	 */
	public function actionView() {
		$id = isset( $_GET[ 'id' ] ) ? (integer) $_GET[ 'id' ] : null;
		
		$product = $this->loadModel( $id );
		
		
		$this->pageTitle = $product->fullName;
		$this->breadcrumbs = array(
			$product->category->parentCategory->PluralName,
			$product->category->PluralName => Yii::app()->createUrl( 'product/list', array( 'cid' => $product->category->CategoryID, 'lc' => Yii::app()->language ) ),
			$product->brand->Name,
			$product->Name
		);
		
		
		$this->render( 'view', array(
			'product' => $product
		));
	}
	
	
	/**
	 * Создание товара
	 * 
	 */
	public function actionCreate() {
		// определить язык редактирования
		$currentTranslationLanguageID = isset( $_GET[ 'tlid' ] ) ? (integer) $_GET[ 'tlid' ] : Language::model()->getCurrentLanguageID();		
		$cid = isset( $_GET[ 'cid' ] ) ? (integer) $_GET[ 'cid' ] : null;
		
		$product = new Product();
		$product->LanguageID = $currentTranslationLanguageID;
		$product->CategoryID = $cid;
		
		if( isset( $_POST[ 'Product' ] ) && !empty( $_POST[ 'Product' ] ) ) {
			$product->attributes = $_POST[ 'Product' ];
	
			if( $product->save( true ) ) {
				// добавить изображение к товару
				if( isset( $_FILES[ 'Product' ][ 'name' ][ 'Image' ] ) ) {
					$product->Image = $_FILES[ 'Product' ][ 'name' ][ 'Image' ];
					$product->saveImage();
				}
								
				if( isset( $_POST[ 'FeatureIDs' ] ) && isset( $_POST[ 'FeatureValues' ] ) ) {
					$success = $product->updateFeatures( $_POST[ 'FeatureIDs' ], $_POST[ 'FeatureValues' ] );
					if( $success ) {
						Yii::app()->user->setFlash( 'success', Yii::t( 'product', 'Product created' ) );
						
						$id = $product->getPrimaryKey();
						
						$actionParams = array(
							'tlid' => $currentTranslationLanguageID,
							'id' => $id
						);
						
						if( isset( $_POST[ 'lc' ] ) ) { 
							$actionParams[ 'lc' ] = $_POST[ 'lc' ];							
						}
						
						$this->redirect( Yii::app()->createUrl( 'product/update', $actionParams ) );
					}
					else {
						Yii::app()->user->setFlash( 'error', $product->getErrorsAsString() );
					}
				}
			}
			else{
				// обработка ошибок валидации происходит в модели
				// дополнительную обработку можно написать здесь
			}
		}
	
		
		// список брендов
		$brandsSingularList = Brand::model()->getSingularList();	
				
		// получаем категории игнорируя первый два уровня
		$categoriesSingularList = Category::model()->getSingularList( 
			Category::CATEGORY_MAX_LEVEL, 
			array(
				Category::CATEGORY_FIRST_LEVEL,
				Category::CATEGORY_SECOND_LEVEL
			) 
		);
		
		$languages = Language::model()->getAll();
		$features =  ProductHasFeatures::model()->getEmptyList( $cid );
		
		
		$this->pageTitle = Yii::t( 'product', 'New Product' );
		$this->breadcrumbs = array(
			$this->pageTitle
		);
		
		
		$this->render( 'edit', array(
			'product' => $product,
			'categories' => $categoriesSingularList,
			'brands' => $brandsSingularList,
			'languages' => $languages,
			'features' =>$features
		));
	}
	
	
	/**
	 * Обновление товара
	 * 
	 */
	public function actionUpdate() {
		// определить язык редактирования
		$currentTranslationLanguageID = isset( $_GET[ 'tlid' ] ) && !empty( $_GET[ 'tlid' ] ) ? (integer) $_GET[ 'tlid' ] : Language::model()->getCurrentLanguageID();
		$id = isset( $_GET[ 'id' ] ) ? (integer) $_GET[ 'id' ] : null;
		
		// получить модель без автоматического перевода атрибутов
		Yii::app()->user->setState( 'CurrentTranslationLanguageID', $currentTranslationLanguageID );	
		$product = $this->loadModel( $id );
		Yii::app()->user->setState( 'CurrentTranslationLanguageID', null );	
		
		if( isset( $_POST[ 'Product' ] ) && !empty( $_POST[ 'Product' ] ) ) {		
			$product->attributes = $_POST[ 'Product' ];
			$product->LanguageID = $currentTranslationLanguageID;
								
			if( $product->save( true ) ) {
				// обновить список изображений товара
				if( isset( $_POST[ 'ProductHasImagesID' ] ) ) {
					$product->updateImages( $_POST[ 'ProductHasImagesID' ] );
				}
				
				// добавить изображение к товару
				if( isset( $_FILES[ 'Product' ][ 'name' ][ 'Image' ] ) ) {
					$product->Image = $_FILES[ 'Product' ][ 'name' ][ 'Image' ];
					$product->saveImage();
				}
				
				if( isset( $_POST[ 'FeatureIDs' ] ) && isset( $_POST[ 'FeatureValues' ] ) ) {
					$success = $product->updateFeatures( $_POST[ 'FeatureIDs' ], $_POST[ 'FeatureValues' ] );
					if( $success ) {
						Yii::app()->user->setFlash( 'success', Yii::t( 'product', 'Product updated' ) );
					}
					else {
						Yii::app()->user->setFlash( 'error', $product->getError( 'ProductID' ) );
					}
				}
			}
			else{
				// обработка ошибок валидации происходит в модели
				// дополнительную обработку можно написать здесь
			}
		}
		
		$productImagesDataProvider = new CActiveDataProvider( 'ProductHasImages', array(
			'criteria' => array(
				'condition' => 'ProductID = :productID',
				'params' => array(
					':productID' => $product->getPrimaryKey()
				),
				'order' => 't.Index ASC'
			),
			'pagination' => false
		));
		
		
		// список брендов
		$brandsSingularList = Brand::model()->getSingularList();	
		
		// получаем категории игнорируя первые два уровня
		$categoriesSingularList = Category::model()->getSingularList( 
			Category::CATEGORY_MAX_LEVEL, 
			array(
				Category::CATEGORY_FIRST_LEVEL,
				Category::CATEGORY_SECOND_LEVEL
			) 
		);
	
		$languages = Language::model()->getAll();
		
		$features =  ProductHasFeatures::model()->getListWithValues( $product );
		
		
		$this->pageTitle = $product->fullName;
		$this->breadcrumbs = array(
			$product->category->parentCategory->PluralName,
			$product->category->PluralName => Yii::app()->createUrl( 'product/list', array( 'cid' => $product->category->CategoryID, 'lc' => Yii::app()->language ) ),
			$product->brand->Name,
			$product->Name
		);
		
		
		$this->render( 'edit', array(
			'product' => $product,
			'productImagesDataProvider' => $productImagesDataProvider,
			'categories' => $categoriesSingularList,
			'brands' => $brandsSingularList,
			'languages' => $languages,
			'features' => $features
		));
	}
	
	
	/**
	 * Удалить товар
	 * 
	 */
	public function actionDelete() {
		$id = isset( $_GET[ 'id' ] ) ? (integer) $_GET[ 'id' ] : null;
		
		$product = $this->loadModel( $id );
		
		$categoryID = $product->CategoryID;
		$productFullName = $product->fullName;
		
		// удалить товар, вместе с изображениями и характеристиками
		$success = $product->delete();
		
		if( $success ) {
			Yii::app()->user->setFlash( 'success', Yii::t( 'product', 'Product ":productFullName" was deleted', array( ':productFullName' => $productFullName ) ) );
		}
		else {
			Yii::app()->user->setFlash( 'error', Yii::t( 'product', 'Product ":productFullName" was not deleted', array( ':productFullName' => $productFullName ) ) );
		}
		
		
		// перенаправить на страницу с такими же параметрами, как и были
		$requestActionParams = $this->getActionParams();
		if( key_exists( 'id', $requestActionParams ) ) {
			unset( $requestActionParams[ 'id' ] );
		}
		if( key_exists( 'cid', $requestActionParams ) ) {
			unset( $requestActionParams[ 'cid' ] );
		}		
		
		$requestActionParams[ 'cid' ] = $categoryID;
		
		$this->redirect( Yii::app()->createUrl( 'product/list', $requestActionParams ) );
	}
	
	
	/**
	 * Добавить товар в список сравнения для категории
	 * 
	 */
	public function actionComparisonAdd() {
		$id = null;
		if( isset( $_GET[ 'id' ] ) && !empty( $_GET[ 'id' ] ) ) {
			 $id = (integer) $_GET[ 'id' ];
		}
		
		$product = $this->loadModel( $id );
		$productCategoryID = $product->category->CategoryID;
		
		// сохранить товар в сравнении в его категории
		if( !isset( Yii::app()->session[ 'comparison.' . $productCategoryID ] ) ) {
			$categoryCompareProductsIDs = array( $id );
		}
		else {
			$categoryCompareProductsIDs = Yii::app()->session[ 'comparison.' . $productCategoryID ];
			if( !in_array( $id, $categoryCompareProductsIDs ) ) {
				$categoryCompareProductsIDs[] = $id;
			}
		}
		
		Yii::app()->session[ 'comparison.' . $productCategoryID ] = $categoryCompareProductsIDs;
		
		
		echo CJSON::encode( array(
			'text' => Yii::t( 'product', 'Compare' ),
			'totalText' => Yii::t( 'product', ':count product(s) in comparison', array( ':count' => count( $categoryCompareProductsIDs ) ) ),
			'href' => Yii::app()->createUrl( 'product/compare', array( 'cid' => $productCategoryID, 'lc' => Yii::app()->language ) ),
		));
		
		Yii::app()->end();
	}
	
	
	/**
	 * Удалить товар из списка сравнения для категории
	 * 
	 */
	public function actionComparisonDelete() {
		$id = null;
		if( isset( $_GET[ 'id' ] ) && !empty( $_GET[ 'id' ] ) ) {
			 $id = (integer) $_GET[ 'id' ];
		}
		
		$product = $this->loadModel( $id );
		$productCategoryID = $product->category->CategoryID;
		
		// удалить товар из сравнения в его категории
		if( isset( Yii::app()->session[ 'comparison.' . $productCategoryID ] ) ) {
			$categoryCompareProductsIDs = Yii::app()->session[ 'comparison.' . $productCategoryID ];
			if( ( $key = array_search( $id, $categoryCompareProductsIDs ) ) !== false ) {
				unset( $categoryCompareProductsIDs[ $key ] );
			}
		}
		
		
		Yii::app()->session[ 'comparison.' . $productCategoryID ] = $categoryCompareProductsIDs;
		
		
		Yii::app()->user->setFlash( 'success', Yii::t( 'product', 'Product ":productName" removed from comparison', array( ':productName' => $product->fullName ) ) );
		
		
		$this->redirect( Yii::app()->createUrl( 'product/compare', array( 'cid' => $productCategoryID, 'lc' => Yii::app()->language ) ) );
	}
	
	
	/**
	 * Сравнить добавленные в список сравнения для категории товары
	 * 
	 */
	public function actionCompare() {
		$cid = null;
		if( isset( $_GET[ 'cid' ] ) && !empty( $_GET[ 'cid' ] ) ) {
			 $cid = (integer) $_GET[ 'cid' ];
		}
		
		$category = Category::model()->findByPk( $cid );
		if( empty( $category ) ) {
			throw new CHttpException( 404, Yii::t( 'category', 'Category not found' ) );
		}
		
		$categoryCompareProductsIDs = Yii::app()->session[ 'comparison.' . $cid ];
		if( !$categoryCompareProductsIDs || count( $categoryCompareProductsIDs ) == 0 ) {
			throw new CHttpException( 406, Yii::t( 'product', 'Comparison list is empty' ) );
		}
		
		
		$categoryFeatures = $category->features;
		
		$compareProducts = array();
		foreach( $categoryCompareProductsIDs as $categoryCompareProductID ) {
			$product = Product::model()->findByPk( $categoryCompareProductID );
			
			if( empty( $product ) ) {
				continue;
			}
			
			
			$compareProducts[] = $product;
		}
		
		
		$this->pageTitle = Yii::t( 'product', ':categoryName : comparison', array( ':categoryName' => $category->PluralName ) );
		$this->breadcrumbs = array(
			$product->category->parentCategory->PluralName,
			$product->category->PluralName => Yii::app()->createUrl( 'product/list', array( 'cid' => $product->category->CategoryID, 'lc' => Yii::app()->language ) ),
			Yii::t( 'product', 'Comparison' )
		);
		
		
		$this->render( 'compare', array(
			'categoryFeatures' => $categoryFeatures,
			'compareProducts' => $compareProducts,
		));
	}
	
	
	/**
	 * Экспорт товаров в CSV с поддержкой огромного количества товаров
	 * 
	 */
	public function actionExport() {
		$fileName = 'products_' . Yii::app()->language . '.csv';
		
		// заголовки для загрузки файла в формате csv
		header( 'Content-Type: text/csv; charset=utf-8' );
		header( 'Content-Disposition: attachment; filename=' . $fileName );
		
		// создать указатель файла на выходной поток
		$output = fopen( 'php://output', 'w' );
		
		// записать заголовки
		fputcsv( 
			$output, 
			array( 
				Yii::t( 'product', 'ProductID' ), 
				Yii::t( 'product', 'Category' ), 
				Yii::t( 'product', 'Brand' ), 
				Yii::t( 'product', 'Name' )
			),
			';'
		);
		
		// записать данные
		// ... определить количество товаров
		$totalCount = Product::model()->count();
		
		// ... товары обрабатываются страницами
		$countProductsPerPage = 25;
		for( $pageIndex = 0; $pageIndex < ( ceil( $totalCount / $countProductsPerPage ) ); $pageIndex++ ) {
			// получить страницу товаров для експорта
			$exportProducts = Product::model()->getExportProducts( array( 
				'limit' => $countProductsPerPage,
				'offset' => ( $pageIndex * $countProductsPerPage )
			) );
			
			foreach( $exportProducts as $exportProduct ) {
				fputcsv( $output, $exportProduct, ';' );
			}
		}

		
		// закрыть поток
		fclose( $output );
	}
	
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * 
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel( $id ) {
		$model = Product::model()->findByPk( $id );
		if( $model === null ) {
			throw new CHttpException( 404, Yii::t( 'application', 'The requested page does not exist.' ) );
		}
		
		
		return $model;
	}
}

?>
