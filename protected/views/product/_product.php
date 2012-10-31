<?php
	$fullProductName = $data->category->SingularName . ' ' . $data->brand->Name . ' ' . $data->Name;
	if( isset( $data->productHasImages[0]->FileName ) ) {
		$mainProductImageSrc = Yii::app()->request->baseUrl . '/' . Yii::app()->params[ 'imagesFolder' ] . '/' . $data->productHasImages[0]->FileName;
	}
	else {
		$mainProductImageSrc = 'http://placehold.it/300x200';
	}
	
	
	$productURL = Yii::app()->createUrl( 'product/view', array( 'id' => $data->ProductID, 'lc' => Yii::app()->language ) );
?>

<div class="row row-spacer">
	<div class="span4">
		<a href="<?php echo $productURL;?>" target="_self"><img src="<?php echo $mainProductImageSrc; ?>" alt="<?php echo $fullProductName; ?>" class="img-rounded" align="top" /></a><br />
		<a href="#" target="_blank" ><?php echo Yii::t( 'product', 'Add to comparsion'); ?></a>
	</div>
	<div class="span8">
		<a href="<?php echo $productURL;?>"><h4><?php echo $fullProductName; ?></h4></a>
		
		<?php
		$features = '';
		foreach( $data->productHasFeatures as $productHasFeature ) {
			$features .= '<b>' . $productHasFeature->feature->Name . '</b>' . ': ' . $productHasFeature->Value . '; ';
		}
		echo $features;
		?>
	</div>
</div>
