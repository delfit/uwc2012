
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
				// получить все изображения для товара
				$productPreviewImages = $product->productHasImages( array( 'limit' => Yii::app()->params[ 'default' ][ 'countImagesPerProduct' ] ) );
				
				// если изображений нет -- создать массив с одним элементом
				if( empty( $productPreviewImages ) ) {
					$productPreviewImages[] = array();
				}

				foreach( $productPreviewImages as $imageIndex => $productHasImage ) {
					// первое изображение получить из модели товара
					// если изображения отсутствует -- она вернет плашку
					if( $imageIndex == 0 ) {
						$currentImageSrc = $product->mainImageURL;
					}
					else {
						$currentImageSrc = Yii::app()->request->baseUrl . '/' . Yii::app()->params[ 'imagesFolder' ] . '/' . $productHasImage->FileName;
					}

					echo CHtml::openTag( 'li', array(
						'class' => 'span' . ( $imageIndex == 0 ? '4' : '1' ),
					));

					echo CHtml::openTag( 'a', array(
						'href' => $currentImageSrc,
						'title' => $product->fullName,
						'class' => 'thumbnail',
						'rel' => 'lightbox-product',
					));

					echo CHtml::tag( 'img', array(
						'src' => $currentImageSrc,
						'alt' => $product->fullName,
						'class' => 'img-rounded',
						'align' => 'top',
					));

					echo CHtml::closeTag( 'a' );

					echo CHtml::closeTag( 'li' );
				}
				?>
			</ul>
		</div>

		<div class="span4">
			<?php
			// отрисовать ссылку на сравнение/добавление товара к сравнению
			if( 
				Yii::app()->session[ 'comparison.' . $product->category->CategoryID ] && 
				in_array( $product->ProductID, Yii::app()->session[ 'comparison.' . $product->category->CategoryID ] ) 
			) {
				echo CHtml::tag( 'a', array(
					'href' => Yii::app()->createUrl( 'product/compare', array( 'cid' => $product->category->CategoryID, 'lc' => Yii::app()->language ) ),
				), Yii::t( 'product', 'Compare' ) );
			}
			else {
				echo CHtml::tag( 'a', array(
					'href' => Yii::app()->createUrl( 'product/comparisonAdd', array( 'id' => $product->ProductID, 'lc' => Yii::app()->language ) ),
					'class' => 'compare-link',
				), Yii::t( 'product', 'Add to comparison' ) );
			}
			?>
			
			<h4><?php echo Yii::t( 'product', 'Technical features' ); ?></h4>
			
			<p>
				<?php
				echo CHtml::openTag( 'dl' );
				foreach( $product->productHasFeatures as $productHasFeature ) {
					echo CHtml::tag( 'dt', array( 'class' => 'bold' ), $productHasFeature->feature->Name );
					echo CHtml::tag( 'dd', array(), $productHasFeature->Value );
				}
				echo CHtml::closeTag( 'dl' );
				?>
			</p>
		</div>
	</div>


	<h4><?php echo Yii::t( 'product', 'Description' ); ?></h4>
	<div class="span12" itemprop="description"><?php echo $product->Description; ?></div>
</div>
