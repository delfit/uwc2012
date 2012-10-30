<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProductController
 *
 * @author ivan
 */
class ProductController extends Controller
{
	public function actionList() {
		$filters = array(
			'page' => isset( $_GET[ 'page' ] ) ? $_GET[ 'page' ] : 1,
			'limit' => Yii::app()->params[ 'default' ][ 'limit' ]
		);
		
		$CategoryID = null;
		if( isset( $_GET[ 'cid' ] ) && !empty( $_GET[ 'cid' ] ) ) {
			$CategoryID = (integer) $_GET[ 'cid' ];
		}
		
		if( empty( $CategoryID ) ) {
			Yii::app()->end();
		}
		
		$products = Product::model()->getList( $CategoryID, $filters );
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
