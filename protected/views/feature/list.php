<?php
	$form = $this->beginWidget( 'bootstrap.widgets.TbActiveForm', array(
		'id' => 'category-form',
		'type' => 'horizontal',
		'htmlOptions'=>array('class'=>'well'),
		'action' => Yii::app()->createUrl( 'feature/create' )
	) );
?>

<center>
	
	<?php
		$buttons = array();
		foreach( $languages as $language ) {			
			$buttons[] = array(
				'label' => $language->Name . ' [' . $language->Code . ']',
				'active' => $language->LanguageID == $model->LanguageID ? true : false,
				'url' => Yii::app()->createUrl( 'feature/list', array( 'id' => $model->CategoryID, 'lc' => Yii::app()->language, 'tlid' => $language->LanguageID ) )
			);
		}

		$this->widget('bootstrap.widgets.TbButtonGroup', array(
			'type' => 'primary',
			'toggle' => 'radio',
			'buttons' => $buttons,
		));
	?>
	
</center>

<fieldset> 
	<legend> <?php echo Yii::t( 'category', 'New Feature' ); ?> </legend>
	<?php 
		echo $form->dropDownListRow( $model, 'CategoryID', $categories, array( 'class' => 'span7' ) );
	?>
	<?php echo $form->textFieldRow( Feature::model(), 'Name', array( 'class' => 'span7' ) ); ?>
	<?php echo $form->textAreaRow( Feature::model(), 'Description', array( 'class' => 'span7' ) ); ?>

</fieldset>

<div class="form-actions">
	<?php $this->widget( 'bootstrap.widgets.TbButton', array( 'buttonType' => 'submit', 'label' => Yii::t( 'application', 'Add' ) ) ); ?>
</div>


<?php $this->endWidget(); ?>

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
		)
	);

?>

<?php 
	$this->widget( 'bootstrap.widgets.TbExtendedGridView',  array(
		'type' => 'striped bordered',
		'ajaxUpdate' => false,
		'dataProvider' => $featuresDataProvider,
		'template' => "{items}",
		'columns' => array(
			'FeatureID',
			array(
				'class' => 'bootstrap.widgets.TbEditableColumn',
				'name' => 'Name',
				'sortable' => true,
				'editable' => array(
					'url' => $this->createUrl( 'feature/update' ),
					'placement' => 'right',
					'inputclass' => 'span3'
				)
			),
			array(
				'class' => 'bootstrap.widgets.TbEditableColumn',
				'name' => 'Description',
				'sortable' => true,
				'editable' => array(
					'url' => $this->createUrl( 'feature/update' ),
					'placement' => 'right',
					'inputclass' => 'span3'
				)
			),
			array(
				'class'=>'bootstrap.widgets.TbButtonColumn',
				'template' => '{delete}',
				'deleteButtonUrl' => 'Yii::app()->createUrl( \'feature\delete\', array( \'id\' => $data->FeatureID ) )',
			),
		),
	));
?>
