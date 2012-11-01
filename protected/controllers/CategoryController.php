<?php
/**
 * Description of ProductController
 *
 * @author ivan
 */
class CategoryController extends Controller
{
	public function actionList() {
		
	}
	
	public function actionView() {
		echo "actionCategoryView";
	}
	
	public function actionCreate() {
		echo "actionCategoryCreate";
	}
	
	public function actionUpdate() {
		echo "actionCategoryUpdate";
	}
	
	public function actionDelete( $id ) {
		$this->loadModel( $id )->delete();
		Yii::app()->user->setFlash( 'success', Yii::t( 'category', 'Category removed' ) );
		$this->redirect( array( 'site/index' ) );
	}
	
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel( $id ) {
		$model = Category::model()->findByPk( $id );
		if( $model === null )
			throw new CHttpException( 404, 'The requested page does not exist.' );
		return $model;
	}


	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation( $model ) {
		if( isset( $_POST[ 'ajax' ] ) && $_POST[ 'ajax' ] === 'category-form' ) {
			echo CActiveForm::validate( $model );
			Yii::app()->end();
		}
	}
}

?>
