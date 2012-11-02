<?php
/**
 * Product Controller
 *
 * @author ivan
 */
class ProductController extends Controller
{
	public function actionList() {	
		$cid = null;
		if( isset( $_GET[ 'cid' ] ) && !empty( $_GET[ 'cid' ] ) ) {
			$cid = (integer) $_GET[ 'cid' ];
		}
		
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
	
        
	public function actionSearch() {
		if( !isset( $_GET[ 'q' ] ) || empty( $_GET[ 'q' ] ) ) {
			return;
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
	 * Просмотр товара
	 * 
	 * @throws CHttpException
	 */
	public function actionView() {
		$id = null;
		if( isset( $_GET[ 'id' ] ) && !empty( $_GET[ 'id' ] ) ) {
			 $id = (integer) $_GET[ 'id' ];
		}
		
		$product = Product::model()->findByPk( $id );
		if( empty( $product ) ) {
			throw new CHttpException( 404, Yii::t( 'product', 'Product not found' ) );
		}
		
		
		$this->pageTitle = $product->category->SingularName . ' ' . $product->brand->Name . ' ' .$product->Name;
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
	 */
	public function actionCreate() {
		// определить язык редактирования
		if( isset( $_GET[ 'tlid' ] ) && !empty( $_GET[ 'tlid' ] ) ) {
			$currentTranslationLanguageID = (integer) $_GET[ 'tlid' ];
		}
		else {
			$currentTranslationLanguageID = Language::model()->getCurrentLanguageID();
		}
		
		$cid = null;
		if( isset( $_GET[ 'cid' ] ) ) {
			$cid = (integer) $_GET[ 'cid' ];
		}
		
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
						$this->redirect( 
							Yii::app()->createUrl( 
								"product/update",
								array( 
									'id' => $id,
									'lc' => $currentTranslationLanguageID
								)
						));
					}
					else {
						Yii::app()->user->setFlash( 'error', $product->getError( 'ProductID' ) );
					}
				}
			}
			else{
				Yii::app()->user->setFlash( 'error', $product->getError( 'ProductID' ) );
			}
		}
		
//		// TODO убрать
//		$productImagesDataProvider = new CActiveDataProvider( 'ProductHasImages', array(
//			'criteria' => array(
//				'condition' => 'ProductID = :productID',
//				'params' => array(
//					':productID' => $product->getPrimaryKey()
//				),
//			),
//			'pagination' => false
//		));
		
		
		$brands = Brand::model()->findAll();
		$brandsDropDownList = array();
		foreach( $brands as $brand) {
			$brandsDropDownList[ $brand->BrandID ] = $brand->Name;
		}
		
				
		// получаем категории игнорируя первый два уровня
		$categoriesSingularList = Category::model()->getSingularList( 
			Category::CATEGORY_MAX_LEVEL, 
			array(
				Category::CATEGORY_FIRST_LEVEL,
				Category::CATEGORY_SECOND_LEVEL
			) 
		);
		
		$languages = Language::model()->findAll();
		$features =  ProductHasFeatures::model()->getEmptyList( $cid );
		
		
		$this->pageTitle = Yii::t( 'product', 'New Product' );
		$this->breadcrumbs = array(
			Yii::t( 'product', 'New Product' )
		);
		
		
		$this->render( 'edit', array(
			'product' => $product,
			//'productImagesDataProvider' => $productImagesDataProvider,
			'categories' => $categoriesSingularList,
			'brands' => $brandsDropDownList,
			'languages' => $languages,
			'features' =>$features
		));
	}
	
	
	/**
	 * Обновление товара
	 * 
	 * @throws CHttpException
	 */
	public function actionUpdate() {
		$id = null;
		if( isset( $_GET[ 'id' ] ) && !empty( $_GET[ 'id' ] ) ) {
			 $id = (integer) $_GET[ 'id' ];
		}

		// определить язык редактирования
		if( isset( $_GET[ 'tlid' ] ) && !empty( $_GET[ 'tlid' ] ) ) {
			$currentTranslationLanguageID = (integer) $_GET[ 'tlid' ];
		}
		else {
			$currentTranslationLanguageID = Language::model()->getCurrentLanguageID();
		}
		
		Yii::app()->user->setState( 'CurrentTranslationLanguageID', $currentTranslationLanguageID );	
		$product = Product::model()->findByPk( $id );
		Yii::app()->user->setState( 'CurrentTranslationLanguageID', null );	
		if( empty( $product ) ) {
			throw new CHttpException( 404, Yii::t( 'product', 'Product not found' ) );
		}
		
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
				Yii::app()->user->setFlash( 'error', $product->getError( 'ProductID' ) );
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
		
		
		$brands = Brand::model()->findAll();
		$brandsDropDownList = array();
		foreach( $brands as $brand) {
			$brandsDropDownList[ $brand->BrandID ] = $brand->Name;
		}
		
		// получаем категории игнорируя первый два уровня
		$categoriesSingularList = Category::model()->getSingularList( 
			Category::CATEGORY_MAX_LEVEL, 
			array(
				Category::CATEGORY_FIRST_LEVEL,
				Category::CATEGORY_SECOND_LEVEL
			) 
		);
	
		$languages = Language::model()->findAll();
		
		// TODO 
		$features =  ProductHasFeatures::model()->getListWithValues( $product );
		
		
		// TODO возможно, вынести полное имя товара как свойство модели
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
			'brands' => $brandsDropDownList,
			'languages' => $languages,
			'features' => $features
		));
	}
	
	
	/**
	 * Удалить товар
	 * 
	 * @param integer $id  идентификатор товара
	 */
	public function actionDelete( $id ) {		
		$product = $this->loadModel( $id );
		
		$categoryID = $product->CategoryID;
		
		// удалить товар, вместе с изображениями и характеристиками
		$success = $product->delete();
		
		if( $success ) {
			Yii::app()->user->setFlash( 'success', Yii::t( 'product', 'Product deleted' ) );
		}
		else {
			Yii::app()->user->setFlash( 'error', Yii::t( 'product', 'Product not deleted' ) );
		}
		
		
		$this->redirect( Yii::app()->createUrl( 'product/list', array( 'cid' => $categoryID ) ) );
	}
	
	
	public function loadModel( $id ) {
		$model = Product::model()->findByPk( $id );
		if( $model === null )
			throw new CHttpException( 404, 'The requested page does not exist.' );
		return $model;
	}
	
	
	public function actionComparsionAdd( $id ) {
		$id = null;
		if( isset( $_GET[ 'id' ] ) && !empty( $_GET[ 'id' ] ) ) {
			 $id = (integer) $_GET[ 'id' ];
		}
		
		$product = Product::model()->findByPk( $id );
		if( empty( $product ) ) {
			throw new CHttpException( 404, Yii::t( 'product', 'Product not found' ) );
		}
		
		
		$productCategoryID = $product->category->CategoryID;
		
		// сохранить товар в сравнении в его категории
		if( !isset( Yii::app()->session[ 'comparsion.' . $productCategoryID ] ) ) {
			$categoryCompareProductsIDs = array( $id );
		}
		else {
			$categoryCompareProductsIDs = Yii::app()->session[ 'comparsion.' . $productCategoryID ];
			if( !in_array( $id, $categoryCompareProductsIDs ) ) {
				$categoryCompareProductsIDs[] = $id;
			}
		}
		
		Yii::app()->session[ 'comparsion.' . $productCategoryID ] = $categoryCompareProductsIDs;
		
		
		echo CJSON::encode( array(
			'text' => Yii::t( 'product', 'Compare' ),
			'totalText' => Yii::t( 'product', ':count product(s) in comparison', array( ':count' => count( $categoryCompareProductsIDs ) ) ),
			'href' => Yii::app()->createUrl( 'product/compare', array( 'cid' => $productCategoryID, 'lc' => Yii::app()->language ) ),
		));
		
		Yii::app()->end();
	}
	
	
	public function actionCompare() {
		$cid = null;
		if( isset( $_GET[ 'cid' ] ) && !empty( $_GET[ 'cid' ] ) ) {
			 $cid = (integer) $_GET[ 'cid' ];
		}
		
		$category = Category::model()->findByPk( $cid );
		if( empty( $category ) ) {
			throw new CHttpException( 404, Yii::t( 'category', 'Category not found' ) );
		}
		
		$categoryCompareProductsIDs = Yii::app()->session[ 'comparsion.' . $cid ];
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
}

?>
