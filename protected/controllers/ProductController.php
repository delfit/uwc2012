<?php
/**
 * Product Controller
 *
 * @author ivan
 */
class ProductController extends Controller
{
	public function actionList() {	
		$CategoryID = null;
		if( isset( $_GET[ 'cid' ] ) && !empty( $_GET[ 'cid' ] ) ) {
			$CategoryID = (integer) $_GET[ 'cid' ];
		}
		
		if( empty( $CategoryID ) ) {
			throw new CHttpException( 404, 'Category not found' );
		}
		
		$products = Product::model()->getList( $CategoryID );
			
	
		
		$this->render( 'list', array(
			'products' => $products,
		));
	}
	
	
	public function actionView() {
		echo "actionProductView";
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
