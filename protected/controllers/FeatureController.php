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
			
		if( isset( $_POST[ 'Feature' ] ) ) {
			$model->attributes = $_POST[ 'Feature' ];
			if( !$model->save() ) {
				Yii::app()->user->setFlash( 'error', $model->getError( 'CategoryID' ) );
				$this->redirect( Yii::app()->createUrl( 'feature/list', array( 'lc' => Yii::app()->language ) ) );
			}
		}
		
		Yii::app()->user->setFlash( 'success', Yii::t( 'feature', 'Feature "' . $model->Name . '" created' ) );
		
		$requestActionParams = $this->getActionParams();
		if( key_exists( 'id', $requestActionParams ) ) {
			unset( $requestActionParams[ 'id' ] );
		}		
		$this->redirect( Yii::app()->createUrl( 'feature/list', $requestActionParams ) );
	}


	/**
	 * Редактировать бренд
	 */
	public function actionUpdate() {
		if( isset( $_GET[ 'tlid' ] ) && !empty( $_GET[ 'tlid' ] ) ) {
			$currentTranslationLanguageID = (integer) $_GET[ 'tlid' ];
		}
		else {
			$currentTranslationLanguageID = Language::model()->getCurrentLanguageID();
		}
		
		$id = ( integer ) $_POST[ 'pk' ];
		$name = ( string ) $_POST[ 'name' ];
		$value = ( string ) $_POST[ 'value' ];
		
		$model = $this->loadModel( $_POST[ 'pk' ] );
		$model->LanguageID = $currentTranslationLanguageID;

		if( !empty( $id ) && !empty( $name ) && !empty( $value ) ) {
			$model->{$name} = $value;
			if( ! $model->save() ) {
				echo $model->getError( $name );
			}
		}
		
		
//		$requestActionParams = $this->getActionParams();
//		if( key_exists( 'id', $requestActionParams ) ) {
//			unset( $requestActionParams[ 'id' ] );
//		}		
//		$this->redirect( Yii::app()->createUrl( 'feature/list', $requestActionParams ) );
	}


	/**
	 * Удалить характеристику
	 * 
	 * @param integer $id  идентификатор характеристики
	 */
	public function actionDelete() {
		$id = null;
		if( isset( $_GET[ 'id' ] ) ) {
			$id = (integer) $_GET[ 'id' ];
		}
		
		$feature = $this->loadModel( $id );
		
		if( $feature->IsUsed() ) {
			Yii::app()->user->setFlash( 'success', Yii::t( 'feature', 'Feature used in products and can not be delated' ) );
		}
		else {
			$success = $feature->delete();
			if( $success ) {
				Yii::app()->user->setFlash( 'success', Yii::t( 'feature', 'Feature deleted' ) );
			}
			else {
				Yii::app()->user->setFlash( 'error', Yii::t( 'feature', 'Feature not deleted' ) );
			}
		}
		
		$requestActionParams = $this->getActionParams();
		if( key_exists( 'id', $requestActionParams ) ) {
			unset( $requestActionParams[ 'id' ] );
		}		
		$this->redirect( Yii::app()->createUrl( 'feature/list', $requestActionParams ) );
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
		
		$cid = null;
		if( isset( $_GET[ 'cid' ] ) ) {
			$cid = (integer) $_GET[ 'cid' ];
		}
		
		$model = new Feature( 'search' );
		$model->LanguageID = $currentTranslationLanguageID;
		$model->unsetAttributes();
		$model->CategoryID = $cid;
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
				':categoryID' => $cid
			)
		) );
		
		
		Yii::app()->user->setState( 'CurrentTranslationLanguageID', $currentTranslationLanguageID );	
		$featuresDataProvider = new CActiveDataProvider(
			$model,
			array(
				'criteria' => $criteria
			)
		);
		$featuresDataProvider->getData();
		Yii::app()->user->setState( 'CurrentTranslationLanguageID', null );	
		
		
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
		$model = Feature::model()->findByPk( $id );
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
