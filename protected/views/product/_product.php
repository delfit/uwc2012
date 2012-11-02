<?php
	$productURL = Yii::app()->createUrl( 'product/view', array( 'id' => $data->ProductID, 'lc' => Yii::app()->language ) );
?>

<div class="row row-spacer" itemscope itemtype="http://data-vocabulary.org/Product">
	<div class="span4">
		<a href="<?php echo $productURL;?>" target="_self">
			<img src="<?php echo $data->mainImageURL; ?>" alt="<?php echo $data->fullName; ?>" class="img-rounded" itemprop="image" align="top" />
		</a>
		<br />
		
		<?php
		// отрисовать ссылку на сравнение/добавление товара к сравнению
		if( 
			Yii::app()->session[ 'comparsion.' . $data->category->CategoryID ] && 
			in_array( $data->ProductID, Yii::app()->session[ 'comparsion.' . $data->category->CategoryID ] ) 
		) {
			echo CHtml::tag( 'a', array(
				'href' => Yii::app()->createUrl( 'product/compare', array( 'cid' => $data->category->CategoryID, 'lc' => Yii::app()->language ) ),
			), Yii::t( 'product', 'Compare' ) );
		}
		else {
			echo CHtml::tag( 'a', array(
				'href' => Yii::app()->createUrl( 'product/comparsionAdd', array( 'id' => $data->ProductID, 'lc' => Yii::app()->language ) ),
				'class' => 'compare-link',
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
			<a href="<?php echo $productURL;?>"><?php echo $data->fullName; ?></a>
		</h4>
		
		<span class="hidden" itemprop="category"><?php echo $data->category->PluralName; ?></span>
		<span class="hidden" itemprop="brand"><?php echo $data->brand->Name; ?></span>
		<span class="hidden" itemprop="name"><?php echo $data->Name; ?></span>
		
		
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
