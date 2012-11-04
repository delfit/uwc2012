
<?php
$form = $this->beginWidget( 'bootstrap.widgets.TbActiveForm', array(
	'id' => 'brand-form',
	'action' => Yii::app()->createUrl( 'brand/create', array( 'lc' => Yii::app()->language ) )
) );
?>

<?php echo $form->errorSummary( $model ); ?>

<fieldset>
	<legend>
		<?php echo Yii::t( 'brand', 'New brand' ); ?>
	</legend>
	<?php echo $form->textFieldRow( $model, 'Name', array( 'class' => 'span12' ) ); ?>
	<?php echo $form->error( $model, 'Name' ); ?>
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
