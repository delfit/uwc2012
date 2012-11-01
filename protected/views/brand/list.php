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

<?php $this->widget( 'bootstrap.widgets.TbGroupGridView',  array(
	'dataProvider' => $model->search(),
	
	'ajaxUpdate' => false,
	'type' => 'striped bordered',
	'extraRowColumns' => array( 'firstLetter' ),
	// FIXME исправить отображение русских названий производителей
	'extraRowExpression' => '"<b style=\"font-size: 3em; color: #333;\">" . substr( $data->Name, 0, 1 ) . "</b>"',
	'extraRowHtmlOptions' => array( 'style' => 'padding:10px' ),
	
	'columns' => array(
		array(
			'name' => 'firstLetter',
			'value' => 'substr( $data->Name, 0, 1 )',
			'headerHtmlOptions' => array( 'style' => 'display:none' ),
			'htmlOptions' => array( 'style' => 'display:none' )
		),
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