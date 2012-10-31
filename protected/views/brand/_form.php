<?php
/* @var $this BrandController */
/* @var $model Brand */
/* @var $form CActiveForm */
?>

<div class="form">

	<?php
		$form = $this->beginWidget( 'CActiveForm', array(
			'id' => 'brand-form',
			'enableAjaxValidation' => false,
			'action' => Yii::app()->createUrl( 'brand/create' )
		) );
	?>

	<?php echo $form->errorSummary( $model ); ?>

	<div class="row">
		<?php echo $form->labelEx( $model, 'Name' ); ?>
		<?php echo $form->textField( $model, 'Name', array( 'size' => 60, 'maxlength' => 100 ) ); ?>
		<?php echo $form->error( $model, 'Name' ); ?>

		<?php echo CHtml::submitButton( $model->isNewRecord ? 'Create' : 'Save'  ); ?>
	</div>

	<?php $this->endWidget(); ?>

</div><!-- form -->