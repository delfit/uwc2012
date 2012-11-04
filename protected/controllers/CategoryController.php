<?php
/**
 * Обработка категорий
 *
 * @author ivan
 */
class CategoryController extends Controller
{
	const PERENT_CATEGORY_COUNT_LEVELS = 2;
	
	/**
	 * @return array action filters
	 */
	public function filters() {
		return array(
			'accessControl',
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
				'actions' => array( 'create', 'update', 'delete' ),
				'users' => array( 'admin' ),
			),
			array( 'deny', // deny all users
				'users' => array( '*' ),
			),
		);
	}
	
	/**
	 * Создать категорию
	 */
	public function actionCreate() {
		$currentTranslationLanguageID = isset( $_GET[ 'tlid' ] ) ? (integer) $_GET[ 'tlid' ] : Language::model()->getCurrentLanguageID();
		
		$model = new Category();
		$model->LanguageID = $currentTranslationLanguageID;
			
		if( isset( $_POST[ 'Category' ] ) && !empty( $_POST[ 'Category' ] ) ) {
			$model->attributes = $_POST[ 'Category' ];
			
			if( $model->save() ) {
				Yii::app()->user->setFlash( 'success', Yii::t( 'category', 'Category ":categoryName" created', array( ':categoryName' => $model->PluralName ) ) );
				$id = $model->getPrimaryKey();
				
				$actionParams = array(
					'id' => $id,
					'tlid' => $currentTranslationLanguageID
				);
				
				if( isset( $_POST[ 'lc' ] ) ) {
					$actionParams[ 'lc' ] = $_POST[ 'lc' ];
				}
				
				$this->redirect( 
					Yii::app()->createUrl( 
						"category/update", 
						$actionParams
				));
			}
			else{
				Yii::app()->user->setFlash( 'error', $model->getErrorsAsString() );
			}
		}
		
		$categoriesSingularList = Category::model()->getSingularList( self::PERENT_CATEGORY_COUNT_LEVELS );
		$languages = Language::model()->getAll();
		
		$title = Yii::t( 'category', 'New Category' );
		$this->pageTitle = $title;
		$this->breadcrumbs = array(
			$title
		);
		
		$this->render(
			'category', 
			array(
				'languages' => $languages,
				'categories' => $categoriesSingularList,
				'model' => $model
			)
		);
	}
	
	
	/**
	 * Редактировать категорию
	 */
	public function actionUpdate( $id ) {		
		$currentTranslationLanguageID = isset( $_GET[ 'tlid' ] ) ? (integer) $_GET[ 'tlid' ] : Language::model()->getCurrentLanguageID();
		
		Yii::app()->user->setState( 'CurrentTranslationLanguageID', $currentTranslationLanguageID );	
		$model = $this->loadModel( $id );
		Yii::app()->user->setState( 'CurrentTranslationLanguageID', null );
			
		if( isset( $_POST[ 'Category' ] ) && !empty( $_POST[ 'Category' ] ) ) {
			$model->attributes = $_POST[ 'Category' ];
			$model->LanguageID = $currentTranslationLanguageID;
			
			if( $model->save() ) {
				Yii::app()->user->setFlash( 'success', Yii::t( 'category', 'Category updated' ) );
			}
			else{
				Yii::app()->user->setFlash( 'error', $model->getErrorsAsString() );
			}
		}
		
		
		$categoriesSingularList = Category::model()->getSingularList( self::PERENT_CATEGORY_COUNT_LEVELS );
		$languages = Language::model()->getAll();
		
		$title = Yii::t( 'category', 'New Category' );
		$this->pageTitle = $title;
		$this->breadcrumbs = array(
			$title
		);
		
		$this->render(
			'category', 
			array(
				'languages' => $languages,
				'categories' => $categoriesSingularList,
				'model' => $model
			)
		);
	}
	
	
	/**
	 * Удалить категорию
	 */
	public function actionDelete() {
		$id = isset( $_GET[ 'id' ] ) ? (integer) $_GET[ 'id' ] : null;
		
		$model = $this->loadModel( $id );		
		$categoryName = $model->PluralName;
		
		if( $model->isUsed() ) {
			Yii::app()->user->setFlash( 'error', Yii::t( 'category', 'Category ":categoryName" used in products and can not be deleted', array( ':categoryName' => $categoryName ) ) );
		}
		else if( count( $model->subCategories ) > 0 ) {
			Yii::app()->user->setFlash( 'error', Yii::t( 'category', 'Category ":categoryName" has subcategories and can not be deleted', array( ':categoryName' => $categoryName ) ) );
		}
		else {
			if( $model->delete() ) {
				Yii::app()->user->setFlash( 'success', Yii::t( 'category', 'Category ":categoryName" was deleted', array( ':categoryName' => $categoryName ) ) );
			}
			else {
				Yii::app()->user->setFlash( 'error', Yii::t( 'category', 'Category ":categoryName" not deleted', array( ':categoryName' => $categoryName ) ) );
			}
		}
		
		
		$this->redirect( Yii::app()->homeUrl );
	}
	
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel( $id ) {
		$model = Category::model()->findByPk( $id );
		if( $model === null )
			throw new CHttpException( 404, Yii::t( 'application', 'The requested page does not exist.' ) );
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
