
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
	
	$action	= $model->getIsNewRecord() ? 'category/create' : 'category/update';
	
	$buttons = array();
	foreach( $languages as $language ) {			
		$buttons[] = array(
			'label' => $language->Name . ' [' . $language->Code . ']',
			'active' => $language->LanguageID == $model->LanguageID ? true : false,
			'url' => Yii::app()->createUrl( $action, array( 'id' => $model->CategoryID, 'lc' => Yii::app()->language, 'tlid' => $language->LanguageID ) )
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
));
?>

<fieldset> 
	<legend> 
		<?php echo $this->pageTitle; ?>
	</legend>

	<?php 
	echo $form->dropDownListRow(
		$model, 'ParentCategoryID', 
		$categories, 
		array( 
			'class' => 'span7',
			'prompt' => Yii::t( 'category', '[Root]' ),
			'disabled' => !$model->getIsNewRecord()
		)
	);
	?>

	<?php echo $form->textFieldRow( $model, 'PluralName', array( 'class' => 'span7' ) ); ?>
	<?php echo $form->textFieldRow( $model, 'SingularName', array( 'class' => 'span7' ) ); ?>
	<?php echo DHtml::actionLanguageCode(); ?>
</fieldset>

<div class="form-actions">
	<?php 
	$this->widget( 'bootstrap.widgets.TbButton', array(
		'label' => ( $model->getIsNewRecord() ? Yii::t( 'application', 'Add' ) : Yii::t( 'application', 'Save' ) ),
		'icon' => ( $model->getIsNewRecord() ? 'plus' : 'ok' ) . ' white',
		'type' => 'primary',
		'buttonType' => 'submit',
	));
	?>
</div>

<?php $this->endWidget(); ?>
