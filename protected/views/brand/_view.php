<?php
/* @var $this BrandController */
/* @var $data Brand */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('BrandID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->BrandID), array('view', 'id'=>$data->BrandID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Name')); ?>:</b>
	<?php echo CHtml::encode($data->Name); ?>
	<br />


</div>