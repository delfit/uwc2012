
<h2>
<?php 
	echo $this->pageTitle;
	//TODO сделать нормальное условие
	if( true ) {
		echo '&nbsp;<span class="comparison-text">(' . Yii::t( 'product', 'Products in comparison' ) . ':)</span>';
	}

?>
</h2>

<div class="row">
	<div class="span2 pull-right comparison">
		<p><?php echo Yii::t( 'application', 'Comparison list' ); ?></p>
		<ul>
			<li>1</li>
			<li>2</li>
			<li>3</li>
			<li>4</li>
		</ul>
		<a href=""><?php echo Yii::t( 'application', 'Compare' ); ?> &rarr;</a>
	</div>
	
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
