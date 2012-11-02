
<h2>
<?php 
	echo $this->pageTitle;
	//TODO сделать нормальное условие
	if( true ) {
		echo ' &nbsp;<span class="comparison-text">(' . Yii::t( 'product', 'Products in comparison' ) . ':)</span>';
	}

?>
</h2>

<div class="row">	
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
</div>
