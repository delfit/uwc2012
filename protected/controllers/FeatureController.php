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
	 * Получить список характеристик
	 */
	public function actionList() {
		$currentTranslationLanguageID = isset( $_GET[ 'tlid' ] ) ? (integer) $_GET[ 'tlid' ] : Language::model()->getCurrentLanguageID();
		$cid = isset( $_GET[ 'cid' ] ) ? (integer) $_GET[ 'cid' ] : null;
		
		$model = new Feature( 'search' );
		$model->unsetAttributes();
		
		$model->LanguageID = $currentTranslationLanguageID;		
		$model->CategoryID = $cid;
		
		if( isset( $_GET[ 'Feature' ] ) ) {
			$model->attributes = $_GET[ 'Feature' ];
		}

		$this->pageTitle = Yii::t( 'feature', 'Features' );
		$this->breadcrumbs = array(
			Yii::t( 'feature', 'Features' )
		);
		
		$languages = Language::model()->getAll();
		
		// получаем категории игнорируя первых два уровня
		$categoriesSingularList = Category::model()->getSingularList( 
			Category::CATEGORY_MAX_LEVEL, 
			array(
				Category::CATEGORY_FIRST_LEVEL,
				Category::CATEGORY_SECOND_LEVEL
			) 
		);		
		
		// список характеристик категории с переводом на указанном языке
		Yii::app()->user->setState( 'CurrentTranslationLanguageID', $currentTranslationLanguageID );	
		$featuresDataProvider = new CActiveDataProvider(
			$model,
			array(
				'criteria' => array( 
					'condition' => 'CategoryID = :categoryID',
					'params' => array(
						':categoryID' => $cid
					)
				)
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
	 * Добавить новую характеристику товаров определенной категории
	 */
	public function actionCreate() {
		$model = new Feature;
			
		if( isset( $_POST[ 'Feature' ] ) ) {
			$model->attributes = $_POST[ 'Feature' ];
			if( $model->save() ) {
				Yii::app()->user->setFlash( 'success', Yii::t( 'feature', 'Feature "' . $model->Name . '" created' ) );
			}
			else {
				Yii::app()->user->setFlash( 'error', $model->getError( 'CategoryID' ) );
				$this->redirect( Yii::app()->createUrl( 'feature/list', array( 'lc' => Yii::app()->language ) ) );
			}
		}
		
		// TODO упростить if
		$actionParams = array();
		if( isset( $_POST[ 'lc' ] ) ) {
			$actionParams[ 'lc' ] = $_POST[ 'lc' ];
		}
		
		if( isset( $_POST[ 'tlid' ] ) ) {
			$actionParams[ 'tlid' ] = $_POST[ 'tlid' ];
		}
		
		if( isset( $_POST[ 'cid' ] ) ) {
			$actionParams[ 'cid' ] = $_POST[ 'cid' ];
		}
		
		
		$this->redirect( Yii::app()->createUrl( 'feature/list', $actionParams ) );
	}


	/**
	 * Редактировать характеристику
	 */
	public function actionUpdate() {
		$currentTranslationLanguageID = isset( $_GET[ 'tlid' ] ) ? (integer) $_GET[ 'tlid' ] : Language::model()->getCurrentLanguageID();
		
		$id = isset( $_POST[ 'pk' ] ) ? ( integer ) $_POST[ 'pk' ] : null;
		$name = isset( $_POST[ 'name' ] ) ? ( string ) $_POST[ 'name' ] : null;
		$value = isset( $_POST[ 'value' ] ) ? ( string ) $_POST[ 'value' ] : null;
		
		$model = $this->loadModel( $_POST[ 'pk' ] );
		$model->LanguageID = $currentTranslationLanguageID;

		if( !empty( $id ) && !empty( $name ) && !empty( $value ) ) {
			$model->{$name} = $value;
			if( ! $model->save() ) {
				echo $model->getError( $name );
			}
		}
	}


	/**
	 * Удалить характеристику
	 * 
	 * @param integer $id  идентификатор характеристики
	 */
	public function actionDelete() {
		$id = isset( $_GET[ 'id' ] ) ? (integer) $_GET[ 'id' ] : null;
		
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
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel( $id ) {
		$model = Feature::model()->findByPk( $id );
		if( $model === null )
			throw new CHttpException( 404, Yii::t( 'application', 'The requested page does not exist.' ) );
		return $model;
	}


	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation( $model ) {
		if( isset( $_POST[ 'ajax' ] ) && $_POST[ 'ajax' ] === 'feature-form' ) {
			echo CActiveForm::validate( $model );
			Yii::app()->end();
		}
	}

}
