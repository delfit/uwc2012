<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle = Yii::app()->name . ' - ' . Yii::t( 'application', 'Login' );
$this->breadcrumbs = array(
	Yii::t( 'application', 'Login' ),
);
?>

<h1><?php echo Yii::t( 'application', 'Login' ); ?></h1>

<div class="form">
	<?php
	$form = $this->beginWidget( 'CActiveForm', array(
		'id' => 'login-form',
		'enableClientValidation' => true,
		'clientOptions' => array(
			'validateOnSubmit' => true,
		),
	));
	?>
	
	<div class="row">
		<?php echo $form->labelEx( $model, 'username' ); ?>
		<?php echo $form->textField( $model, 'username' ); ?>
		<?php echo $form->error( $model, 'username' ); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx( $model, 'password' ); ?>
		<?php echo $form->passwordField( $model, 'password' ); ?>
		<?php echo $form->error( $model, 'password' ); ?>
		<p class="hint">
			Hint: You may login with <kbd>admin</kbd>/<kbd>admin</kbd>.
		</p>
	</div>

	<div class="row rememberMe">
		<?php echo $form->checkBox( $model, 'rememberMe' ); ?>
		<?php echo $form->label( $model, 'rememberMe' ); ?>
		<?php echo $form->error( $model, 'rememberMe' ); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton( Yii::t( 'application', 'Login' ) ); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
