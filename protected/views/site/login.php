<?php
$this->pageTitle = Yii::app()->name . ' - ' . Yii::t( 'application', 'Login' );
$this->breadcrumbs = array(
	Yii::t( 'application', 'Login' ),
);
?>

<?php
$form = $this->beginWidget( 'bootstrap.widgets.TbActiveForm', array(
	'id' => 'login-form',
	'enableClientValidation' => true,
	'clientOptions' => array(
		'validateOnSubmit' => true,
	),
));
?>

<fieldset>
	<legend>
		<?php echo Yii::t( 'application', 'Login' ); ?>
	</legend>
	
	
	<?php echo $form->labelEx( $model, 'username' ); ?>
	<?php echo $form->textField( $model, 'username' ); ?>
	<?php echo $form->error( $model, 'username' ); ?>
	
	<?php echo $form->labelEx( $model, 'password' ); ?>
	<?php echo $form->passwordField( $model, 'password' ); ?>
	<?php echo $form->error( $model, 'password' ); ?>
	<p class="hint">
		<?php echo Yii::t( 'application', 'Hint: You may login with' ); ?> <kbd>admin</kbd>/<kbd>admin</kbd>.
	</p>
	
	<?php echo $form->checkBox( $model, 'rememberMe' ); ?>
	<?php echo $form->label( $model, 'rememberMe' ); ?>
	<?php echo $form->error( $model, 'rememberMe' ); ?>
</fieldset>

<div class="form-actions">
	<?php 
	$this->widget( 'bootstrap.widgets.TbButton', array(
		'label' => Yii::t( 'application', 'Login' ),
		'icon' => 'user white',
		'type' => 'primary',
		'buttonType' => 'submit',
	));
	?>
</div>

<?php $this->endWidget(); ?>
