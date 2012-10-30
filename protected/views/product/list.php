<?php
//$this->pageTitle=Yii::app()->name . ' - Products';
//$this->breadcrumbs=array(
//	'Products', 'Notebook'
//);

?>

<?php
$this->widget( 'zii.widgets.CListView', array(
	'dataProvider' => $products,
	'itemView' => '_product', 
	'enablePagination' => true, 
	'ajaxUpdate'=>false
//	'pager' => array(
//		'class' => 'CLinkPager',
//		'pageSize' => 1
//	)
));
?>
