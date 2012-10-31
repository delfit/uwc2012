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
			$product->category->PluralName,
			$product->brand->Name,
			$product->Name
		);
		
		
		$this->render( 'view', array(
			'product' => $product
		));
	}
	
	
	public function actionCreate() {
		echo "actionProductCreate";
	}
	
	
	public function actionUpdate() {
		echo "actionProductUpdate";
	}
	
	
	public function actionDelete() {
		echo "actionProductDelete";
	}
}

?>
