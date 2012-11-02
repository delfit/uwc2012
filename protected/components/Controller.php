<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{

	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout = '//layouts/column1';

	/**
	 * @var array main menu items
	 */
	public $mainMenu = array( );
	
	/**
	 * @var array languages menu items
	 */
	public $languagesMenu = array( );
	
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu = array( );

	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs = array( );
	
	
	public function beforeRender( $view ) {
		parent::beforeRender( $view );
		
	
		$this->mainMenu = Category::model()->getList();
		
		$this->languagesMenu = Language::model()->findAll();
		
				
		return true;
	}
	
	
	public function beforeAction( $action ) {
		parent::beforeAction( $action );
		
		
		// применить язык запроса
		if( isset( $_REQUEST[ 'lc' ] ) && !empty( $_REQUEST[ 'lc' ] ) ) {
			$languageCode = $_REQUEST[ 'lc' ];
			Yii::app()->language = $languageCode;
		}
		
		
		return true;
	}

}
