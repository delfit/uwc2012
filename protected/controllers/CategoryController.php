<?php
/**
 * Description of ProductController
 *
 * @author ivan
 */
class CategoryController extends Controller
{
	const PERENT_CATEGORY_COUNT_LEVELS = 2;
	
	public function actionList() {
		
	}
	
	public function actionView() {
		echo "actionCategoryView";
	}
	
	
	/**
	 * Создать категорию
	 */
	public function actionCreate() {
		if( isset( $_GET[ 'tlid' ] ) && !empty( $_GET[ 'tlid' ] ) ) {
			$currentTranslationLanguageID = (integer) $_GET[ 'tlid' ];
		}
		else {
			$currentTranslationLanguageID = Language::model()->getCurrentLanguageID();
		}
		
		$model = new Category();
		$model->LanguageID = $currentTranslationLanguageID;
			
		if( isset( $_POST[ 'Category' ] ) && !empty( $_POST[ 'Category' ] ) ) {
			$model->attributes = $_POST[ 'Category' ];
			
			if( $model->save() ) {
				Yii::app()->user->setFlash( 'success', Yii::t( 'category', 'Category ":categoryName" created', array( ':categoryName' => $model->PluralName ) ) );
				$id = $model->getPrimaryKey();
				$this->redirect( 
					Yii::app()->createUrl( 
						"category/update", 
						array( 
							'id' => $id,
							'lc' => $currentTranslationLanguageID
						)
				));
			}
			else{
				Yii::app()->user->setFlash( 'error', $model->getErrors() );
			}
		}
		
		$categoriesSingularList = Category::model()->getSingularList( self::PERENT_CATEGORY_COUNT_LEVELS );
		$languages = Language::model()->findAll();
		
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
		if( isset( $_GET[ 'tlid' ] ) && !empty( $_GET[ 'tlid' ] ) ) {
			$currentTranslationLanguageID = (integer) $_GET[ 'tlid' ];
		}
		else {
			$currentTranslationLanguageID = Language::model()->getCurrentLanguageID();
		}
		
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
				Yii::app()->user->setFlash( 'error', $model->getErrors() );
			}
		}
		
		
		$categoriesSingularList = Category::model()->getSingularList( self::PERENT_CATEGORY_COUNT_LEVELS );
		$languages = Language::model()->findAll();
		
		$this->render(
			'category', 
			array(
				'languages' => $languages,
				'categories' => $categoriesSingularList,
				'model' => $model
			)
		);
	}
	
	
	public function actionDelete( $id ) {
		$model = $this->loadModel( $id );
		$categoryName = $model->PluralName;
		$model->delete();
		
		Yii::app()->user->setFlash( 'success', Yii::t( 'category', 'Category ":categoryName" was deleted', array( ':categoryName' => $categoryName ) ) );
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
