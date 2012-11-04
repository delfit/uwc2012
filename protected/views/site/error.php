<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle = Yii::app()->name . ' - ' . Yii::t( 'application', 'Error' );
$this->breadcrumbs = array(
	Yii::t( 'application', 'Error' ),
);
?>

<h2><?php echo Yii::t( 'application', 'Error' ) . ' ' . $code; ?></h2>

<div class="error">
	<?php echo CHtml::encode( $message ); ?>
</div>