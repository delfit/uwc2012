<?php
	$fullProductName = $data->category->SingularName . ' ' . $data->brand->Name . ' ' . $data->Name;
	if( isset( $data->productHasImages[0]->FileName ) ) {
		$mainProductImageSrc = Yii::app()->request->baseUrl . '/' . Yii::app()->params[ 'imagesFolder' ] . '/' . $data->productHasImages[0]->FileName;
	}
	else {
		$mainProductImageSrc = 'http://placehold.it/300x200&text=Image+is+Not+Avaliable';
	}
		
	$currentLanguageCode = Language::model()->getCurrentLanguageCode();
	
	$productURL = Yii::app()->request->baseUrl . '/' . $currentLanguageCode . '/product/' . $data->ProductID;
?>

<div class="row row-spacer">
	<div class="span4">
		<a href="<?php echo $productURL;?>" target="_self"><img src="<?php echo $mainProductImageSrc; ?>" alt="<?php echo $fullProductName; ?>" class="img-rounded" align="top" /></a><br />
		<a href="#" target="_blank" >Добавить к сравнению</a>
	</div>
	<div class="span8">
		<h4><a href="<?php echo $productURL;?>" target="_self"><?php echo $fullProductName; ?></a></h4>
		<?php

		$features = '';
		foreach( $data->productHasFeatures as $productHasFeature ) {
			$features .= '<b>' . $productHasFeature->feature->Name . '</b>' . ': ' . $productHasFeature->Value . '; ';
		}
		echo $features;
		?>
		<p>Код товара: 		<?php echo $data->ProductID;?></p>
		
	</div>
</div>
