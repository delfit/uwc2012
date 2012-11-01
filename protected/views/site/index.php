<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name;
?>

<h1>Welcome to <i><?php echo CHtml::encode( Yii::app()->name ); ?></i></h1>

<div class="row">
	<div class="span12">
	<?php
	$this->widget( 'bootstrap.widgets.TbCarousel', array(
		'items' => array(
			array(
				'image' => 'http://i5.rozetka.ua/goods/5319/asus_u31sds_2310m_n4drap_5319537.jpg',
				'alt' => 'Ноутбук Asus U31SD (U31SD-RX130R) Silver',
				'imageOptions' => array(
					'style' => 'height: 400px; '
				),
				'label' => 'Ноутбук Asus U31SD (U31SD-RX130R) Silver',
				'caption' => 'Реализованная в U31SD технология Super Hybrid Engine при выполнении сложных задач автоматически увеличивает производительность системы вплоть до 15%...',
			),
			array(
				'image' => 'http://i2.rozetka.ua/goods/7003/hp_probook_4540s_b6n43ea_7003380.jpg',
				'alt' => 'Ноутбук HP ProBook 4540s (B6N43EA)',
				'imageOptions' => array(
					'style' => 'height: 400px; '
				),
				'label' => 'Ноутбук HP ProBook 4540s (B6N43EA)',
				'caption' => 'Стильный ноутбук HP ProBook 4540s станет вашим незаменимым помощником в работе. Он оснащен матовым дисплеем HD диагональю 39.6 см (15.6\") с LED-подсветкой...'
			),
		),
	));
	?>
	</div>
</div>

<?php
$this->widget('bootstrap.widgets.TbAlert', array(
	'block' => true,
	'fade' => true, 
	'closeText' => '×', 
	'alerts' => array( 
		'success',
		'info',
		'warning',
		'error',
		'danger'
	),
));
?>

<div class="row">
	<?php
	
	/**
	 * Отрисовывает кнопки управления категорией
	 * 
	 * @param CController $_this
	 * @param integer $categoryID
	 * @return string
	 */
	function drawActionButtons( $_this, $categoryID ) {
		return $_this->widget( 'bootstrap.widgets.TbButtonGroup', array(
			'size' => 'mini',
			'type' => 'link', 
			'htmlOptions' => array(
				// TODO вынести стили отсюда
				'style' => 'display: inline; padding-right: 10px;'
			),
			'buttons' => array(
				array( 
					'url' => Yii::app()->createUrl( 'category/update', array( 'id' => $categoryID, 'lc' => Yii::app()->language ) ), 
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
						'submit' => Yii::app()->createUrl( 'category/delete', array( 'id' => $categoryID, 'lc' => Yii::app()->language ) ),
						'confirm' => Yii::t( 'application', 'Are you sure?' ), 
						'name' => 'accept'
					), 
				),
			),
		), true );
	}

	// разбить содержимое главного меню на колонки
	$rawColumns = array();
	$columnsCount = Yii::app()->params[ 'mainPageColumnsCount' ];
	for( $i = 0; $i < count( $this->mainMenu ); $i++ ) {
		$rawColumnIndex = $i % $columnsCount;
		$rawColumns[ $rawColumnIndex ][ ] =  $this->mainMenu[ $i ];
	}
	

	// отрисовать каждую колонку
	foreach( $rawColumns as $categories ) {
		echo CHtml::openTag( 'div', array( 'class' => 'span' . floor( 12 / $columnsCount ) ) );
		
		foreach( $categories as $category ) {
			// отрисовать корневые разделы для гостя или для админа
			echo CHtml::openTag( 'h3' );
			echo ( ! Yii::app()->user->isGuest ? drawActionButtons( $this, $category[ 'id' ] ) : '' );
			echo $category[ 'label' ];
			echo CHtml::closeTag( 'h3' );
			
			echo CHtml::openTag( 'div' );

			$isListOpened = false;
			foreach( $category[ 'items' ] as $subCategory ) {
				// пропустить разделитель
				if( $subCategory == '---' ) {
					continue;
				}


				// если элемент имеет ссылку -- вывести его внутрь текущего раздела
				if( isset( $subCategory[ 'url' ] ) ) {
					if( !$isListOpened ) {
						$isListOpened = true;
						echo CHtml::openTag( 'ul' );
					}

					// отрисовать разделы 3го уровня для гостя или для админа
					echo CHtml::openTag( 'li' );
					echo ( ! Yii::app()->user->isGuest ? drawActionButtons( $this, $subCategory[ 'id' ] ) : '' );
					echo CHtml::link( $subCategory[ 'label' ], $subCategory[ 'url' ] );
					echo CHtml::closeTag( 'li' );
				}
				// иначе -- начать новый подраздел
				else {
					if( $isListOpened ) {
						$isListOpened = false;
						echo CHtml::closeTag( 'ul' );
					}

					// отрисовать разделы 2го уровня для гостя или для админа
					echo CHtml::openTag( 'h4' );
					echo ( ! Yii::app()->user->isGuest ? drawActionButtons( $this, $subCategory[ 'id' ] ) : '' );
					echo $subCategory[ 'label' ];
					echo CHtml::closeTag( 'h4' );
				}
			}

			echo CHtml::closeTag( 'div' );
		}
		
		echo CHtml::closeTag( 'div' );
	}
	?>
</div>
