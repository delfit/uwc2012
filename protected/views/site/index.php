<?php
/* @var $this SiteController */

$this->pageTitle = Yii::t( 'application', Yii::app()->name );
?>

<h1> 
	<?php echo Yii::t( 'application', 'Welcome to' ) ?> <i><?php echo CHtml::encode( $this->pageTitle ); ?> </i>
</h1>

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

<div class="thumbnail">

	<?php
	$items = array();
	foreach( $products as $product ) {
		$items[] = array(
			'image' => $product->getMainImageURL(),
			'alt' => $product->getFullName(),
			'imageOptions' => array(
				'style' => '
					min-height: 400px;
					max-height: 400px;
					margin-left: auto;
					margin-right: auto;
				',
			),
			'label' => $product->getFullName(),
			'caption' => $product->getFeatures()
		);
	}
	
	$this->widget( 'bootstrap.widgets.TbCarousel', array(
		'items' => $items
	));
	
	?>
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
			if( ! Yii::app()->user->isGuest ) {
				echo DHtml::actionButtons( 
					Yii::app()->createUrl( 'category/update', array( 'id' => $category[ 'id' ], 'lc' => Yii::app()->language ) ), 
					Yii::app()->createUrl( 'category/delete', array( 'id' => $category[ 'id' ], 'lc' => Yii::app()->language ) )
				);
			}
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
					if( ! Yii::app()->user->isGuest ) {
						echo DHtml::actionButtons( 
							Yii::app()->createUrl( 'category/update', array( 'id' => $subCategory[ 'id' ], 'lc' => Yii::app()->language ) ), 
							Yii::app()->createUrl( 'category/delete', array( 'id' => $subCategory[ 'id' ], 'lc' => Yii::app()->language ) )
						);
					}
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
					if( ! Yii::app()->user->isGuest ) {
						echo DHtml::actionButtons( 
							Yii::app()->createUrl( 'category/update', array( 'id' => $subCategory[ 'id' ], 'lc' => Yii::app()->language ) ), 
							Yii::app()->createUrl( 'category/delete', array( 'id' => $subCategory[ 'id' ], 'lc' => Yii::app()->language ) )
						);
					}
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
