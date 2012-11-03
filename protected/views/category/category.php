
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
	if( $model->getIsNewRecord() ) {
		$action = 'category/create';
	}
	else {
		$action = 'category/update';
	}
	
	

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

	$action	= $model->getIsNewRecord() ? 'category/create' : 'category/update';
	
	$form = $this->beginWidget( 'bootstrap.widgets.TbActiveForm', array(
			'id' => 'category-form',
			'type' => 'horizontal',
			'htmlOptions'=>array('class'=>'well'),
		)
	);

?>

<center>
	
	<?php
		$buttons = array();
		foreach( $languages as $language ) {			
			$buttons[] = array(
				'label' => $language->Name . ' [' . $language->Code . ']',
				'active' => $language->LanguageID == $model->LanguageID ? true : false,
				'url' => Yii::app()->createUrl( $action, array( 'id' => $model->CategoryID, 'lc' => Yii::app()->language, 'tlid' => $language->LanguageID ) )
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
		<legend> 
			<?php 
				if( $model->getIsNewRecord() ) {
					echo Yii::t( 'category', 'New Category' ); 
				}
				else {
					echo Yii::t( 'category', 'Category #:categoryID', array( ':categoryID' => $model->getPrimaryKey() ) ); 
				}				
			?>
		</legend>

	</fieldset>
	<?php 
		echo $form->dropDownListRow( $model, 'ParentCategoryID', $categories	, array( 'class' => 'span7' ) );
	?>

	<?php echo $form->textFieldRow( $model, 'PluralName', array( 'class' => 'span7' ) ); ?>
	<?php echo $form->textFieldRow( $model, 'SingularName', array( 'class' => 'span7' ) ); ?>

	<div class="form-actions">
		<?php 
			$this->widget( 
				'bootstrap.widgets.TbButton', 
				array( 
					'buttonType' => 'submit',
					'label' => $model->getIsNewRecord() ? Yii::t( 'application', 'Add' ) : Yii::t( 'application', 'Save' ) 
				) 
		);?>
	</div>

<?php $this->endWidget(); ?>
