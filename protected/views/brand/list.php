
<?php
$this->widget( 'bootstrap.widgets.TbAlert', array(
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

<h2><?php echo $this->pageTitle; ?></h2>

<?php echo $this->renderPartial( '_form', array( 'model' => $model ) ); ?>

<?php 
$this->widget( 'bootstrap.widgets.TbGroupGridView',  array(
	'dataProvider' => $model->search(),
	
	'ajaxUpdate' => false,
	'type' => 'striped bordered',
	'extraRowColumns' => array( 'firstLetter' ),
	// FIXME исправить отображение русских названий производителей
	'extraRowExpression' => 'mb_substr( $data->Name, 0, 1 )', // function( $data ){ return $data->Name{0};}
	
	'columns' => array(
		array(
			'name' => 'firstLetter',
			'value' => 'mb_substr( $data->Name, 0, 1 )',
			'headerHtmlOptions' => array( 'class' => 'hidden' ),
			'htmlOptions' => array( 'class' => 'hidden' )
		),
		array(
			'class' => 'bootstrap.widgets.TbEditableColumn',
			'name' => 'Name',
			'sortable' => true,
			'editable' => array(
				'title' => Yii::t( 'brand', 'Name' ),
				'url' => $this->createUrl( 'brand/update' ),
				'placement' => 'right',
				'inputclass' => 'span3'
			)
		),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template' => '{delete}',
			'deleteButtonUrl' => 'Yii::app()->createUrl( \'brand/delete\', array( \'id\' => $data->BrandID, \'lc\' => \'' . Yii::app()->language . '\' ) )',
		),
	),
)); ?>