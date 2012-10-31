<?php

class BrandController extends Controller
{

	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout = '//layouts/column1';


	/**
	 * @return array action filters
	 */
	public function filters() {
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}


	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules() {
		return array(
			array( 'allow', // allow all users to perform 'index' and 'view' actions
				'actions' => array( 'index' ),
				'users' => array( '*' ),
			),
			array( 'allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions' => array( 'create', 'update' ),
				'users' => array( '@' ),
			),
			array( 'allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions' => array( 'list', 'delete' ),
				'users' => array( 'admin' ),
			),
			array( 'deny', // deny all users
				'users' => array( '*' ),
			),
		);
	}

	
	/**
	 * Добавить новый бренд
	 */
	public function actionCreate() {
		$model = new Brand;
		
		if( isset( $_POST[ 'Brand' ] ) ) {
			$model->attributes = $_POST[ 'Brand' ];
			if( $model->save() ) {
				
			}
		}
		
		$this->redirect( array( 'brand/list' ) );
	}


	/**
	 * Редактировать бренд
	 */
	public function actionUpdate() {
		$id = ( integer ) $_POST[ 'pk' ];
		$name = ( string ) $_POST[ 'name' ];
		$value = ( string ) $_POST[ 'value' ];
		
		$model = $this->loadModel( $_POST[ 'pk' ] );

		if( !empty( $id ) && !empty( $name ) && !empty( $value ) ) {
			$model->{$name} = $value;
			if( ! $model->save() ) {
				echo $model->getErrors();
			}
		}
	}


	/**
	 * Удалить бренд
	 * 
	 * @param integer $id
	 */
	public function actionDelete( $id ) {
		$this->loadModel( $id )->delete();
		$this->redirect( array( 'brand/list' ) );
	}

	/**
	 * Получить список брендов
	 */
	public function actionList() {
		$model = new Brand( 'search' );
		$model->unsetAttributes();  // clear any default values
		if( isset( $_GET[ 'Brand' ] ) )
			$model->attributes = $_GET[ 'Brand' ];

		$this->render( 'admin', array(
			'model' => $model,
		) );
	}


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel( $id ) {
		$model = Brand::model()->findByPk( $id );
		if( $model === null )
			throw new CHttpException( 404, 'The requested page does not exist.' );
		return $model;
	}


	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation( $model ) {
		if( isset( $_POST[ 'ajax' ] ) && $_POST[ 'ajax' ] === 'brand-form' ) {
			echo CActiveForm::validate( $model );
			Yii::app()->end();
		}
	}

}
