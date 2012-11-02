<?php

class FeatureController extends Controller
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
	 * Добавить новую характеристику
	 */
	public function actionCreate() {
		$model = new Feature;
		
		if( isset( $_GET[ 'tlid' ] ) && !empty( $_GET[ 'tlid' ] ) ) {
			$currentTranslationLanguageID = (integer) $_GET[ 'tlid' ];
		}
		else {
			$currentTranslationLanguageID = Language::model()->getCurrentLanguageID();
		}
		
		$model->LanguageID = $currentTranslationLanguageID;
		
		
		if( isset( $_POST[ 'Feature' ] ) ) {
			$model->attributes = $_POST[ 'Feature' ];
			if( !$model->save() ) {
				Yii::app()->user->setFlash( 'error', $model->getError( 'CategoryID' ) );
				$this->redirect(
					array(
						'feature/list'
					)
				);
			}
		}
		
		Yii::app()->user->setFlash( 'success', Yii::t( 'feature', 'Feature "' . $model->Name . '" created' ) );
		$this->redirect( array( 'feature/list' ) );
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
				echo $model->getError( $name );
			}
		}
	}


	/**
	 * Удалить бренд
	 * 
	 * @param integer $id  идентификатор характеристики
	 */
	public function actionDelete( $id ) {
		$success = $this->loadModel( $id )->delete();
		
		if( $success ) {
			Yii::app()->user->setFlash( 'success', Yii::t( 'feature', 'Feature deleted' ) );
		}
		else {
			Yii::app()->user->setFlash( 'error', Yii::t( 'feature', 'Category not deleted' ) );
		}
		
		$this->redirect( array( 'feature/list' ) );
	}

	/**
	 * Получить список характеристик
	 */
	public function actionList() {
		if( isset( $_GET[ 'tlid' ] ) && !empty( $_GET[ 'tlid' ] ) ) {
			$currentTranslationLanguageID = (integer) $_GET[ 'tlid' ];
		}
		else {
			$currentTranslationLanguageID = Language::model()->getCurrentLanguageID();
		}
		
		$model = new Feature( 'search' );
		$model->LanguageID = $currentTranslationLanguageID;
		$model->unsetAttributes();
		if( isset( $_GET[ 'Feature' ] ) )
			$model->attributes = $_GET[ 'Feature' ];

		$this->pageTitle = Yii::t( 'feature', 'Features' );
		$this->breadcrumbs = array(
			Yii::t( 'feature', 'Features' )
		);
		
		$languages = Language::model()->findAll();
		
		// получаем категории игнорируя первых два уровня
		$categoriesSingularList = Category::model()->getSingularList( 
			Category::CATEGORY_MAX_LEVEL, 
			array(
				Category::CATEGORY_FIRST_LEVEL,
				Category::CATEGORY_SECOND_LEVEL
			) 
		);
		
		$criteria = new CDbCriteria( array( 
			'condition' => 'CategoryID = :categoryID',
			'params' => array(
				':categoryID' => 3
			)
		) );
		
		$featuresDataProvider = new CActiveDataProvider(
			$model,
			array(
				'criteria' => $criteria
			)
		);
		
		$this->render( 'list', array(
			'categories' => $categoriesSingularList,
			'languages' => $languages,
			'model' => $model,
			'featuresDataProvider' => $featuresDataProvider
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
