<?php

class BrandController extends Controller
{
	/**
	 * @return array action filters
	 */
	public function filters() {
		return array(
			'accessControl',
			'postOnly + delete',
		);
	}


	/**
	 * Определяет правила доступа
	 * Используется в 'accessControl' фильтре.
	 * @return array правила доступа
	 */
	public function accessRules() {
		return array(
			array( 'allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions' => array( 'list', 'create', 'update', 'delete' ),
				'users' => array( 'admin' ),
			),
			array( 'deny', // deny all users
				'users' => array( '*' ),
			),
		);
	}

	
	/**
	 * Получить список брендов
	 */
	public function actionList() {
		$model = new Brand( 'search' );
		$model->unsetAttributes();  // clear any default values
		if( isset( $_GET[ 'Brand' ] ) )
			$model->attributes = $_GET[ 'Brand' ];

		$this->pageTitle = Yii::t( 'brand', 'Brands' );
		$this->breadcrumbs = array(
			Yii::t( 'brand', 'Brands' )
		);
		
		$this->render( 'list', array(
			'model' => $model,
		) );
	}

	
	/**
	 * Добавить новый бренд
	 */
	public function actionCreate() {
		$model = new Brand;

		if( isset( $_POST[ 'Brand' ] ) ) {
			$model->attributes = $_POST[ 'Brand' ];
			if( $model->save() ) {
				Yii::app()->user->setFlash( 'success', Yii::t( 'brand', 'Brand ":brandName" created', array( ':brandName' => $model->Name ) ) );
			}
			else {
				Yii::app()->user->setFlash( 'error', $model->getError( 'Name' ) );
			}
		}
		
		$requestActionParams = $this->getActionParams();
		if( isset( $_POST[ 'lc' ] ) ) {
			$requestActionParams[ 'lc' ] = $_POST[ 'lc' ];
		}
		
		
		$this->redirect( Yii::app()->createUrl( 'brand/list', $requestActionParams ) );
	}


	/**
	 * Редактировать бренд
	 */
	public function actionUpdate() {
		$id = isset( $_POST[ 'pk' ] ) ? ( integer ) $_POST[ 'pk' ] : null;
		$name = isset( $_POST[ 'name' ] ) ? ( string ) $_POST[ 'name' ] : null;
		$value = isset( $_POST[ 'value' ] ) ? ( string ) $_POST[ 'value' ] : null;
				
		$model = $this->loadModel( $_POST[ 'pk' ] );

		if( !empty( $id ) && !empty( $name ) && !empty( $value ) ) {
			$model->{$name} = $value;
			if( ! $model->save() ) {
				echo $model->getError( $name );
			}
		}
	}


	/**
	 * Удалить бренд
	 * 
	 * @param integer $id
	 */
	public function actionDelete() {
		$id = isset( $_GET[ 'id' ] ) ? (integer) $_GET[ 'id' ] : null;

		$model = $this->loadModel( $id );
		$brandName = $model->Name;
		
		if( $model->isUsed() ) {
			Yii::app()->user->setFlash( 'error', Yii::t( 'brand', 'Brand ":brandName" used in products and can not be deleted', array( ':brandName' => $brandName ) ) );
		}
		else {			
			$model->delete();
			Yii::app()->user->setFlash( 'success', Yii::t( 'brand', 'Brand ":brandName" was deleted', array( ':brandName' => $brandName ) ) );
		}
		
		
		$requestActionParams = $this->getActionParams();
		if( key_exists( 'id', $requestActionParams ) ) {
			unset( $requestActionParams[ 'id' ] );
		}		
		$this->redirect( Yii::app()->createUrl( 'brand/list', $requestActionParams ) );
	}


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel( $id ) {
		$model = Brand::model()->findByPk( $id );
		if( $model === null )
			throw new CHttpException( 404, Yii::t( 'application', 'The requested page does not exist.' ) );
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
