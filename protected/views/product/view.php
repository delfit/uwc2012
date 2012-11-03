
<div class="product" itemscope itemtype="http://data-vocabulary.org/Product">
	<div class="span12">
		<h3>
			<?php
			// отрисовать кнопки управления товаром
			if( ! Yii::app()->user->isGuest ) {
				echo DHtml::actionButtons( 
					Yii::app()->createUrl( 'product/update', array( 'id' => $product->ProductID, 'lc' => Yii::app()->language ) ), 
					Yii::app()->createUrl( 'product/delete', array( 'id' => $product->ProductID, 'lc' => Yii::app()->language ) )
				);
			}

			echo CHtml::tag( 'a', array( 
				'href' => Yii::app()->createUrl( 'product/view', array( 'id' => $product->ProductID, 'lc' => Yii::app()->language ) ),
			), $product->fullName );
			?>
		</h3>
		
		<span class="hidden" itemprop="category"><?php echo $product->category->PluralName; ?></span>
		<span class="hidden" itemprop="brand"><?php echo $product->brand->Name; ?></span>
		<span class="hidden" itemprop="name"><?php echo $product->Name; ?></span>
		

		<div class="span4">
			<ul class="thumbnails">
				<?php
					// TODO улучшить код
					$productPreviewImages = $product->productHasImages( array( 'limit' => Yii::app()->params[ 'default' ][ 'countImagesPerProduct' ] ) );
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
							<a href="' . $currentImageSrc . '" rel="lightbox-product" class="thumbnail" title="' . $product->fullName . '">
								<img src="' . $currentImageSrc . '" alt="' . $product->fullName . '" class="img-rounded" itemprop="image" align="top" />
							</a>
						</li>';

						echo $currentElement;
					}
				?>
			</ul>
		</div>

		<div class="span4">
			<h4><?php echo Yii::t( 'product', 'Technical features' ); ?></h4>
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


	<h4><?php echo Yii::t( 'product', 'Description' ); ?></h4>
	<div class="span12" itemprop="description"><?php echo $product->Description; ?></div>
</div>
