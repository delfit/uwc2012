<?php

class SiteController extends Controller
{


	/**
	 * Declares class-based actions.
	 */
	public function actions() {
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha' => array(
				'class' => 'CCaptchaAction',
				'backColor' => 0xFFFFFF,
			),
		);
	}


	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex() {
		$products = Product::model()->getCarouselProducts();
				
		$this->render( 
			'index', 
			array( 
				'products' => $products
			)
		);
	}


	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError() {
		if( $error = Yii::app()->errorHandler->error ) {
			if( Yii::app()->request->isAjaxRequest )
				echo $error[ 'message' ];
			else
				$this->render( 'error', $error );
		}
	}


	/**
	 * Displays the login page
	 */
	public function actionLogin() {
		$model = new LoginForm;

		// if it is ajax validation request
		if( isset( $_POST[ 'ajax' ] ) && $_POST[ 'ajax' ] === 'login-form' ) {
			echo CActiveForm::validate( $model );
			Yii::app()->end();
		}

		// collect user input data
		if( isset( $_POST[ 'LoginForm' ] ) ) {
			$model->attributes = $_POST[ 'LoginForm' ];
			// validate user input and redirect to the previous page if valid
			if( $model->validate() && $model->login() )
				Yii::app()->user->setFlash( 'success', Yii::t( 'application', 'Logined successful' ) );
				$this->redirect( Yii::app()->homeUrl );
		}
		// display the login form
		$this->render( 'login', array( 'model' => $model ) );
	}


	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout() {
		Yii::app()->user->logout();
		$this->redirect( Yii::app()->homeUrl );
	}
}