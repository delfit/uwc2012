<?php
/**
 * Product Controller
 *
 * @author ivan
 */
class ProductController extends Controller
{
	const PERENT_CATEGORY_COUNT_LEVELS = 3;
	
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
	
	
	public function actionCreate() {
		// определить язык редактирования
		if( isset( $_GET[ 'tlid' ] ) && !empty( $_GET[ 'tlid' ] ) ) {
			$currentTranslationLanguageID = (integer) $_GET[ 'tlid' ];
		}
		else {
			$currentTranslationLanguageID = Language::model()->getCurrentLanguageID();
		}
		
		$product = new Product();
		$product->LanguageID = $currentTranslationLanguageID;
		
		if( isset( $_POST[ 'Product' ] ) && !empty( $_POST[ 'Product' ] ) ) {
			$product->attributes = $_POST[ 'Product' ];
			
			if( $product->save() ) {
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
			else{
				Yii::app()->user->setFlash( 'error', $product->getError( 'ProductID' ) );
			}
		}
		
		$productFeaturesDataProvider = new CActiveDataProvider( 'ProductHasFeatures', array(
			'criteria' => array(
				'condition' => 'ProductID = :productID',
				'params' => array(
					':productID' => $product->getPrimaryKey()
				),
				'with' => array(
					'feature'
				)
			),
			'pagination' => false
		));
		
		$productImagesDataProvider = new CActiveDataProvider( 'ProductHasImages', array(
			'criteria' => array(
				'condition' => 'ProductID = :productID',
				'params' => array(
					':productID' => $product->getPrimaryKey()
				),
			),
			'pagination' => false
		));
		
		
		$brands = Brand::model()->findAll();
		$brandsDropDownList = array();
		foreach( $brands as $brand) {
			$brandsDropDownList[ $brand->BrandID ] = $brand->Name;
		}
		
				
		$categoriesSingularList = Category::model()->getSingularList( self::PERENT_CATEGORY_COUNT_LEVELS );
		$languages = Language::model()->findAll();
		
		
		$this->pageTitle = $this->pageTitle = Yii::t( 'product', 'New Product' );
		
		
		$this->render( 'edit', array(
			'product' => $product,
			'productFeaturesDataProvider' => $productFeaturesDataProvider,
			'productImagesDataProvider' => $productImagesDataProvider,
			'categories' => $categoriesSingularList,
			'brands' => $brandsDropDownList,
			'languages' => $languages
		));
	}
	
	
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
			
			if( $product->save() ) {
				Yii::app()->user->setFlash( 'success', Yii::t( 'product', 'Product updated' ) );
			}
			else{
				Yii::app()->user->setFlash( 'error', $product->getError( 'ProductID' ) );
			}
		}
		
		$productFeaturesDataProvider = new CActiveDataProvider( 'ProductHasFeatures', array(
			'criteria' => array(
				'condition' => 'ProductID = :productID',
				'params' => array(
					':productID' => $product->getPrimaryKey()
				),
				'with' => array(
					'feature'
				)
			),
			'pagination' => false
		));
		
		$productImagesDataProvider = new CActiveDataProvider( 'ProductHasImages', array(
			'criteria' => array(
				'condition' => 'ProductID = :productID',
				'params' => array(
					':productID' => $product->getPrimaryKey()
				),
			),
			'pagination' => false
		));
		
		
		$brands = Brand::model()->findAll();
		$brandsDropDownList = array();
		foreach( $brands as $brand) {
			$brandsDropDownList[ $brand->BrandID ] = $brand->Name;
		}
		
				
		$categoriesSingularList = Category::model()->getSingularList( self::PERENT_CATEGORY_COUNT_LEVELS );
		$languages = Language::model()->findAll();
		
		
		$this->pageTitle = $product->category->SingularName . ' ' . $product->brand->Name . ' ' .$product->Name;
		
		
		$this->render( 'edit', array(
			'product' => $product,
			'productFeaturesDataProvider' => $productFeaturesDataProvider,
			'productImagesDataProvider' => $productImagesDataProvider,
			'categories' => $categoriesSingularList,
			'brands' => $brandsDropDownList,
			'languages' => $languages
		));
	}
	
	
	public function actionDelete() {
		echo "actionProductDelete";
	}
}

?>
