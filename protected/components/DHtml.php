<?php
/**
 * Статический класс для отрисовки HTML
 *
 */
class DHtml
{
	/**
	 * Отрисовывает кнопки управления -- обновить и удалить
	 * 
	 * @param string $updateUrl
	 * @param string $deleteUrl
	 * @return string
	 */
	public static function actionButtons( $updateUrl, $deleteUrl ) {
		return Yii::app()->getController()->widget( 'bootstrap.widgets.TbButtonGroup', array(
			'size' => 'mini',
			'type' => 'link', 
			'htmlOptions' => array(
				'class' => 'action-buttons'
			),
			'buttons' => array(
				array( 
					'url' => $updateUrl, 
					'icon' => 'pencil white', 
					'type' => 'primary',
					'htmlOptions' => array(
						'title' => Yii::t( 'application', 'Edit' )
					), 
				),
				array( 
					'url' => '#', 
					'icon' => 'trash white', 
					'type' => 'danger',
					'htmlOptions' => array(
						'title' => Yii::t( 'application', 'Delete' ),
						'submit' => $deleteUrl,
						'confirm' => Yii::t( 'application', 'Are you sure?' ), 
						'name' => 'accept'
					), 
				),
			),
		), true );
	}
	
	
	/**
	 * Добавить скрытое поле с текущим языком
	 * 
	 * @return string
	 */
	public static function actionLanguageCode() {
		return CHtml::hiddenField( 'lc', Yii::app()->language );
	}
}
