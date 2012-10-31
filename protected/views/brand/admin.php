<?php
/* @var $this BrandController */
/* @var $model Brand */

$this->breadcrumbs=array(
//	'Brands'=>array('index'),
	'Manage',
);

?>

<h1>Create Brand</h1>

<?php echo $this->renderPartial( '_form', array( 'model' => $model ) ); ?>

<h1>Manage Brands</h1>

<?php $this->widget('bootstrap.widgets.TbGridView',  array(
	'type' => 'striped bordered',
	'dataProvider' => $model->search(),
//	'template' => "{items}",

	'columns' => array(
		array(
			'class' => 'bootstrap.widgets.TbEditableColumn',
			'name' => 'Name',
			'sortable'=>false,
			'editable' => array(
				'url' => $this->createUrl('brand/update'),
				'placement' => 'right',
				'inputclass' => 'span3'
			)
		),
		array(
			'htmlOptions' => array('nowrap'=>'nowrap'),
			'template' => '{delete}',
            //'class'=>'bootstrap.widgets.TbButtonColumn',
			'class'=>'CButtonColumn'
		),
	),
)); ?>