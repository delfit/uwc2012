<?php
	$fullProductName = $product->category->SingularName . ' ' . $product->brand->Name . ' ' . $product->Name;
	if( isset( $product->productHasImages[0]->FileName ) ) {
		$mainProductImageSrc = Yii::app()->request->baseUrl . '/' . Yii::app()->params[ 'imagesFolder' ] . '/' . $product->productHasImages[0]->FileName;
	}
	else {
		$mainProductImageSrc = 'http://placehold.it/300x200';
	}
	
	
	$productURL = Yii::app()->createUrl( 'product/view', array( 'id' => $product->ProductID, 'lc' => Yii::app()->language ) );
?>
<div class="span12">
	<?php echo CHtml::tag( 'h3', array(), $fullProductName ); ?>
	<div class="span4">
		<ul class="thumbnails">
			<?php
				// TODO улучшить код
				foreach( $product->productHasImages as $imageIndex => $productHasImage ) {
					$currentElement = '<li class="span';
					$currentImageSrc = Yii::app()->request->baseUrl . '/' . Yii::app()->params[ 'imagesFolder' ] . '/' . $productHasImage->FileName;

					if ( $imageIndex == 0 ) {
						$currentElement .=  '4';
					}
					else {
						$currentElement .=  '1';
					}
					$currentElement .= '">
						<a href="' . $currentImageSrc . '" rel="lightbox-product" class="thumbnail" title="' . $fullProductName . '">
							<img src="' . $currentImageSrc . '" alt="' . $fullProductName . '" class="img-rounded" align="top" />
						</a>
					</li>';
					echo $currentElement;
				}
			?>
		</ul>
	</div>
	<div class="span4">
		<h4>Технические характеристики</h4>
	<?php
		// TODO улучшить код
		$features = '<dl>';
		foreach( $product->productHasFeatures as $productHasFeature ) {
			$features .= '<dt><b>' . $productHasFeature->feature->Name . ':</b></dt>' . ' <dd>' . $productHasFeature->Value . '</dd> ';
		}
		$features .= '</dl>';
		echo $features;
	?>
	</div>
</div>

<div class="tabbable span10">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#tab1" data-toggle="tab"><b>Описание</b></a></li>
    <li><a href="#tab2" data-toggle="tab"><b>Отзывы</b></a></li>
  </ul>
  <div class="tab-content">
    <div class="tab-pane active description-text" id="tab1">
      <?php echo $product->Description; ?>
    </div>
    <div class="tab-pane" id="tab2">
      <p>Howdy, I'm in Section 2.</p>
    </div>
  </div>
</div>
