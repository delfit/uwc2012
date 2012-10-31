<?php
/* @var $this BrandController */
/* @var $model Brand */
/* @var $form CActiveForm */
?>

<div class="form">
	

	<?php
//		$form = $this->beginWidget( 'CActiveForm', array(
//			'id' => 'brand-form',
//			'enableAjaxValidation' => false,
//			'action' => Yii::app()->createUrl( 'brand/create' )
//		) );
	
		$form = $this->beginWidget( 'bootstrap.widgets.TbActiveForm', array(
			'id' => 'brand-form',
			'htmlOptions' => array( 'class' => 'well' ),
			'action' => Yii::app()->createUrl( 'brand/create' )
		) );

	?>

	<?php echo $form->errorSummary( $model ); ?>

	<div class="row">
		<?php echo $form->label( $model, Yii::t( 'brand', 'Name' ) ); ?>
		<?php echo $form->textField( $model, 'Name', array( 'class' => 'span10' ) ); ?>
		<?php echo $form->error( $model, 'Name' ); ?>
		<?php $this->widget( 'bootstrap.widgets.TbButton', array( 'buttonType' => 'submit', 'label' => Yii::t( 'brand', 'Add' ) ) ); ?>
	</div>

	<?php $this->endWidget(); ?>

</div><!-- form -->