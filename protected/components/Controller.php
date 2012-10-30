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
		
		
		$this->mainMenu = array(
			array( 'label' => 'Компьютеры и ноутбуки', 'url' => '#', 'items' => array(
					array( 'label' => 'Ноутбуки' ),
					array( 'label' => 'Ноутбуки', 'url' => '#' ),
					array( 'label' => 'Планшеты', 'url' => '#' ),
					array( 'label' => 'Сумки для ноутбуков', 'url' => '#' ),
					'---',
					array( 'label' => 'Комплектующие' ),
					array( 'label' => 'Процессоры', 'url' => '#' ),
					array( 'label' => 'Материнские платы', 'url' => '#' ),
					array( 'label' => 'Видеокарты', 'url' => '#' ),
			)),
			array( 'label' => 'ТВ, фото- и видео', 'url' => '#', 'items' => array(
					array( 'label' => 'ТВ-техника' ),
					array( 'label' => 'ЖК-телевизоры', 'url' => '#' ),
					'---',
					array( 'label' => 'Фото и видео' ),
					array( 'label' => 'Фотоаппараты', 'url' => '#' ),
					array( 'label' => 'Видеокамеры', 'url' => '#' ),
			)),
			array( 'label' => 'ТЕст', 'url' => '#', 'items' => array(
					array( 'label' => 'ТВ-техника' ),
					array( 'label' => 'ЖК-телевизоры', 'url' => '#' ),
					'---',
					array( 'label' => 'Фото и видео' ),
					array( 'label' => 'Фотоаппараты', 'url' => '#' ),
					array( 'label' => 'Видеокамеры', 'url' => '#' ),
			)),
		);
		
		
		return true;
	}

}
