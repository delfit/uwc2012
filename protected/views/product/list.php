
<h2>
<?php 
	echo $this->pageTitle;
	
	
	if( isset( $categoryID )  ) {
		$comparisonProductsIDs = Yii::app()->session[ 'comparison.' . $categoryID ];
		
		echo '&nbsp;';
		echo CHtml::tag( 'a', array(
			'href' => Yii::app()->createUrl( 'product/compare', array( 'cid' => $categoryID, 'lc' => Yii::app()->language ) ),
			'class' => 'comparison-text' . ( count( $comparisonProductsIDs ) == 0 ? ' hidden' : '' ),
		), Yii::t( 'product', ':count product(s) in comparison', array( ':count' => count( $comparisonProductsIDs ) ) ) );
	}

?>
</h2>

<?php
$this->widget( 'bootstrap.widgets.TbListView', array(
	'dataProvider' => $products,
	'itemView' => '_product', 
	'enablePagination' => true, 
	'ajaxUpdate' => false,
	'pager' => array(
		'class' => 'bootstrap.widgets.TbPager',
		'pageSize' => 1
	)
));
?>
