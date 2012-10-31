
<h2><?php echo $this->pageTitle; ?></h2>

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
