
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

<center>
	<?php
	$buttons = array();
	foreach( $languages as $language ) {			
		$buttons[] = array(
			'label' => $language->Name . ' [' . $language->Code . ']',
			'active' => $language->LanguageID == $model->LanguageID ? true : false,
			'url' => Yii::app()->createUrl( 'feature/list', array( 'tlid' => $language->LanguageID, 'cid' => $model->CategoryID, 'lc' => Yii::app()->language ) )
		);
	}

	$this->widget( 'bootstrap.widgets.TbButtonGroup', array(
		'type' => 'primary',
		'toggle' => 'radio',
		'buttons' => $buttons,
	));
	?>
</center>

<?php
$form = $this->beginWidget( 'bootstrap.widgets.TbActiveForm', array(
	'id' => 'category-form',
	'type' => 'horizontal',
	'action' => Yii::app()->createUrl( 'feature/create' )
));
?>

<fieldset> 
	<legend> 
		<?php echo Yii::t( 'feature', 'New Feature' ); ?>
	</legend>
	
	<?php 
	$baseUrl = Yii::app()->getBaseUrl( true );
	$actionParams = $this->getActionParams();
	if( key_exists( 'cid', $actionParams ) ) {
		unset( $actionParams[ 'cid' ] );
	}
	
	$routeUrl = Yii::app()->createUrl( $this->getRoute(), $actionParams );

	echo $form->dropDownListRow( 
		$model, 
		'CategoryID',
		$categories,
		array(
			// перезагрузить страницу при выборе категории
			'onChange' => 'window.location="' . $baseUrl . $routeUrl . '/" + this.value',
			'class' => 'span7',
			'prompt' => Yii::t( 'category', 'Select category...' )
		)
	);
	?>
	
	<?php echo $form->textFieldRow( $model, 'Name', array( 'class' => 'span7' ) ); ?>
	<?php echo $form->textAreaRow( $model, 'Description', array( 'class' => 'span7' ) ); ?>
	<?php echo $form->hiddenField( $model, 'LanguageID' ); ?>
	<?php echo CHtml::hiddenField( 'tlid', $model->LanguageID ); ?>
	<?php echo CHtml::hiddenField( 'cid', $model->CategoryID ); ?>
	<?php echo DHtml::actionLanguageCode(); ?>
</fieldset>

<div class="form-actions">
	<?php
	$this->widget( 'bootstrap.widgets.TbButton', array(
		'label' => Yii::t( 'application', 'Add' ),
		'icon' => 'plus white',
		'type' => 'primary',
		'buttonType' => 'submit',
	));
	?>
</div>

<?php $this->endWidget(); ?>

<?php 
if( count( $featuresDataProvider ) > 0 ) {
	$this->widget( 'bootstrap.widgets.TbExtendedGridView',  array(
		'dataProvider' => $featuresDataProvider,
		
		'ajaxUpdate' => false,
		'template' => "{items}",
		'type' => 'striped bordered',
		
		'columns' => array(
			'FeatureID',
			array(
				'class' => 'bootstrap.widgets.TbEditableColumn',
				'name' => 'Name',
				'sortable' => true,
				'editable' => array(
					'title' => Yii::t( 'feature', 'Name' ),
					'url' => $this->createUrl( 'feature/update', array( 'tlid' => $model->LanguageID  ) ),
					'placement' => 'right',
					'inputclass' => 'span3'
				)
			),
			array(
				'class' => 'bootstrap.widgets.TbEditableColumn',
				'name' => 'Description',
				'sortable' => true,

				'editable' => array(
					'title' => Yii::t( 'feature', 'Description' ),
					'type' => 'textarea',
					'url' => $this->createUrl( 'feature/update', array( 'tlid' => $model->LanguageID, 'cid' => $model->CategoryID, 'lc' => Yii::app()->language ) ),
					'placement' => 'right',
					'inputclass' => 'span3'
				)
			),
			array(
				'class'=>'bootstrap.widgets.TbButtonColumn',
				'template' => '{delete}',
				'deleteButtonUrl' => 'Yii::app()->createUrl( \'feature/delete\', array( \'id\' => $data->FeatureID, \'tlid\' => ' . $model->LanguageID . ', \'cid\' => ' . $model->CategoryID . ', \'lc\' => \'' . Yii::app()->language . '\' ) )',
			),
		),
	));
}
?>
