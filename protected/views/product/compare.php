
<h2><?php echo $this->pageTitle; ?></h2>

<table class="table table-hover">
	<?php
	
	// вывести названия товаров в заголовке таблицы
	echo CHtml::openTag( 'thead' );
	echo CHtml::openTag( 'tr' );
	echo CHtml::tag( 'th', array(), '&nbsp;' );
	foreach( $compareProducts as $compareProduct ) {
		echo CHtml::tag( 'th', array(), $compareProduct->fullProductName );
	}
	echo CHtml::closeTag( 'tr' );
	echo CHtml::closeTag( 'thead' );
	
	echo CHtml::openTag( 'tbody' );
	
	// вывести изображения каждого товара
	echo CHtml::openTag( 'tr' );
	echo CHtml::tag( 'td', array(), '&nbsp;' );
	foreach( $compareProducts as $compareProduct ) {
		echo CHtml::openTag( 'td' );
		// TODO улучшить код
		echo '<a href="' . $compareProduct->mainImageURL . '" rel="lightbox-product" class="thumbnail" title="' . $compareProduct->fullProductName . '">
			<img src="' . $compareProduct->mainImageURL . '" alt="' . $compareProduct->fullProductName . '" class="img-rounded" align="top" />
		</a>';
		echo CHtml::closeTag( 'td' );
	}
	echo CHtml::closeTag( 'tr' );
	
	// вывести названия характеристик и их значения для каждого товара
	foreach( $categoryFeatures as $key => $categoryFeature ) {
		echo CHtml::openTag( 'tr' );
		echo CHtml::tag( 'td', array( 'style' => 'font-weight: bold;' ), $categoryFeature->Name );
		foreach( $compareProducts as $compareProduct ) {
			echo CHtml::tag( 'td', array(), $compareProduct->productHasFeatures[ $key ]->Value );
		}
		echo CHtml::closeTag( 'tr' );
	}
	echo CHtml::openTag( 'tbody' );
	
	?>
</table>
