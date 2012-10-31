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


<div class="row">
	<?php

	// разбить содержимое главного меню на колонки
	$rawColumns = array();
	$columnsCount = Yii::app()->params[ 'mainPageColumnsCount' ];
	for( $i = 0; $i < count( $this->mainMenu ); $i++ ) {
		$rawColumnIndex = $i % $columnsCount;
		$rawColumns[ $rawColumnIndex ][ ] =  $this->mainMenu[ $i ];
	}
	

	// отрисовать каждую колонку
	foreach( $rawColumns as $columns ) {
		echo CHtml::openTag( 'div', array( 'class' => 'span' . floor( 12 / $columnsCount ) ) );
		
		foreach( $columns as $column ) {
			echo CHtml::tag( 'h3', array(), $column[ 'label' ] );

			echo CHtml::openTag( 'div' );

			$isListOpened = false;
			foreach( $column[ 'items' ] as $columnItem ) {
				// пропустить разделитель
				if( $columnItem == '---' ) {
					continue;
				}


				// если элемент имеет ссылку -- вывести его внутрь текущего раздела
				if( isset( $columnItem[ 'url' ] ) ) {
					if( !$isListOpened ) {
						$isListOpened = true;
						echo CHtml::openTag( 'ul' );
					}

					echo CHtml::tag( 'li', array(), CHtml::link( $columnItem[ 'label' ], $columnItem[ 'url' ] ) );
				}
				// иначе -- начать новый подраздел
				else {
					if( $isListOpened ) {
						$isListOpened = false;
						echo CHtml::closeTag( 'ul' );
					}

					echo CHtml::tag( 'h4', array(), $columnItem[ 'label' ] );
				}
			}

			echo CHtml::closeTag( 'div' );
		}
		
		echo CHtml::closeTag( 'div' );
	}
	?>
</div>
