<h2><?php echo $this->pageTitle; ?></h2>

<?php
$this->widget('bootstrap.widgets.TbAlert', array(
	'block' => true,
	'fade' => true, 
	'closeText' => '×', 
	'alerts' => array( 
		'success',
		'info',
		'warning',
		'error',
		'danger'
	),
));
?>

<?php echo $this->renderPartial( '_form', array( 'model' => $model ) ); ?>

<?php $this->widget( 'bootstrap.widgets.TbExtendedGridView',  array(
	'type' => 'striped bordered',
	'ajaxUpdate' => false,
	'dataProvider' => $model->search(),
	'columns' => array(
		array(
			'class' => 'bootstrap.widgets.TbEditableColumn',
			'name' => 'Name',
			'sortable' => true,
			'editable' => array(
				'url' => $this->createUrl( 'brand/update' ),
				'placement' => 'right',
				'inputclass' => 'span3'
			)
		),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template' => '{delete}',
			'deleteButtonUrl' => 'Yii::app()->createUrl( \'brand\delete\', array( \'id\' => $data->BrandID ) )',
		),
	),
)); ?>