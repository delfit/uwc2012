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
			throw new CHttpException( 404, 'Category not found' );
		}
		
		$products = Product::model()->getList( $cid );
			
	
		
		$this->render( 'list', array(
			'products' => $products,
		));
	}
        
        public function actionSearch() {
   
           $query = '';
           if( !isset( $_GET[ 'q' ] ) || empty( $_GET[ 'q' ] ) ) {
               return;
           }
           
           $query = $_GET[ 'q' ];
           
           $cid = null;
           if( isset( $_GET[ 'cid' ] ) && !empty( $_GET[ 'cid' ] ) ) {
                $cid = (integer) $_GET[ 'cid' ];
           }
                   
           $products = Product::model()->searchList( $query, $cid );
           
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
