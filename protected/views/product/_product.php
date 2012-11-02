<?php
	$fullProductName = $data->category->SingularName . ' ' . $data->brand->Name . ' ' . $data->Name;
	if( isset( $data->productHasImages[0]->FileName ) ) {
		$mainProductImageSrc = Yii::app()->request->baseUrl . '/' . Yii::app()->params[ 'imagesFolder' ] . '/' . $data->productHasImages[0]->FileName;
	}
	else {
		// TODO уточнить размеры картинок
		$mainProductImageSrc = 'http://placehold.it/300x200&text=Image+is+Not+Avaliable';
	}
	
	
	$productURL = Yii::app()->createUrl( 'product/view', array( 'id' => $data->ProductID, 'lc' => Yii::app()->language ) );
?>

<div class="row row-spacer">
	<div class="span4">
		<a href="<?php echo $productURL;?>" target="_self"><img src="<?php echo $mainProductImageSrc; ?>" alt="<?php echo $fullProductName; ?>" class="img-rounded" align="top" /></a><br />
		<?php
		if( true ) {
			echo CHtml::tag( 'a', array(
				'href' => Yii::app()->createUrl( 'product/comparsionAdd', array( 'id' => $data->ProductID, 'lc' => Yii::app()->language ) ),
				'class' => 'compare-link'
			), Yii::t( 'product', 'Add to comparsion' ) );
		}
		?>
	</div>
	
	<div class="span8">
		<h4>
			<?php
			// отрисовать кнопки управления товаром
			if( ! Yii::app()->user->isGuest ) {
				echo DHtml::actionButtons( 
					Yii::app()->createUrl( 'product/update', array( 'id' => $data->ProductID, 'lc' => Yii::app()->language ) ), 
					Yii::app()->createUrl( 'product/delete', array( 'id' => $data->ProductID, 'lc' => Yii::app()->language ) )
				);
			}
			?>
			<a href="<?php echo $productURL;?>"><?php echo $fullProductName; ?></a>
		</h4>
		
		
		<?php
		$features = '';
		foreach( $data->productHasFeatures as $productHasFeature ) {
			$features .= '<b>' . $productHasFeature->feature->Name . '</b>' . ': ' . $productHasFeature->Value . '; ';
		}
		echo $features;
		?>
		
		<p class="product-code">
			<?php echo Yii::t( 'product', 'Product code' );?>: <span><?php echo $data->ProductID;?></span>
		</p>
	</div>
</div>
