
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

<h2><?php echo $this->pageTitle; ?></h2>

<table class="table table-hover">
	<?php
	
	// вывести названия товаров в заголовке таблицы
	echo CHtml::openTag( 'thead' );
	echo CHtml::openTag( 'tr' );
	echo CHtml::tag( 'th', array(), '&nbsp;' );
	foreach( $compareProducts as $compareProduct ) {
		echo CHtml::openTag( 'th', array( 'class' => 'span' . ceil( 12 / count( $compareProducts ) ) ) );
		
		// кнопка удаления из сравнения
		echo CHtml::tag( 'a', array( 
			'href' => Yii::app()->createUrl( 'product/comparisonDelete', array( 'id' => $compareProduct->ProductID, 'lc' => Yii::app()->language ) ) 
		), '<i class="icon icon-remove"></i>' );
		
		echo '&nbsp;';
		
		// название товара ссылкой
		echo CHtml::tag( 'a', array( 
			'href' => Yii::app()->createUrl( 'product/view', array( 'id' => $compareProduct->ProductID, 'lc' => Yii::app()->language ) ) 
		), $compareProduct->fullName );
		
		echo CHtml::closeTag( 'th' );
	}
	echo CHtml::closeTag( 'tr' );
	echo CHtml::closeTag( 'thead' );
	
	echo CHtml::openTag( 'tbody' );
	
	// вывести изображения каждого товара
	echo CHtml::openTag( 'tr' );
	echo CHtml::tag( 'td', array(), '&nbsp;' );
	foreach( $compareProducts as $compareProduct ) {
		echo CHtml::openTag( 'td' );
		echo CHtml::openTag( 'a', array(
			'href' => $compareProduct->mainImageURL,
			'title' => $compareProduct->fullName,
			'class' => 'thumbnail',
			'rel' => 'lightbox-product',
		));
		
		echo CHtml::tag( 'img', array(
			'src' => $compareProduct->mainImageURL,
			'alt' => $compareProduct->fullName,
			'class' => 'comparison-image img-rounded',
			'align' => 'top',
		));
		
		echo CHtml::closeTag( 'a' );
		echo CHtml::closeTag( 'td' );
	}
	echo CHtml::closeTag( 'tr' );
	
	// вывести названия характеристик и их значения для каждого товара
	foreach( $categoryFeatures as $key => $categoryFeature ) {
		echo CHtml::openTag( 'tr' );
		echo CHtml::tag( 'td', array( 'class' => 'bold' ), $categoryFeature->Name );
		foreach( $compareProducts as $compareProduct ) {
			echo CHtml::tag( 'td', array(), isset( $compareProduct->productHasFeatures[ $key ] ) ? $compareProduct->productHasFeatures[ $key ]->Value : '&nbsp;' );
		}
		echo CHtml::closeTag( 'tr' );
	}
	echo CHtml::openTag( 'tbody' );
	
	?>
</table>
