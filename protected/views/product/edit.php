<h2><?php echo $this->pageTitle; ?></h2>

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
));
?>


<center>
	
	<?php
		if( $product->getIsNewRecord() ) {
			$action = 'product/create';
		}
		else {
			$action = 'product/update';
		}
		// TODO вынести в DHtml заменить <center>
		$buttons = array();
		foreach( $languages as $language ) {			
			$buttons[] = array(
				'label' => $language->Name . ' [' . $language->Code . ']',
				'active' => $language->LanguageID == $product->LanguageID ? true : false,
				'url' => Yii::app()->createUrl( $action, array( 'id' => $product->ProductID, 'lc' => Yii::app()->language, 'tlid' => $language->LanguageID ) )
			);
		}

		$this->widget('bootstrap.widgets.TbButtonGroup', array(
			'type' => 'primary',
			'toggle' => 'radio',
			'buttons' => $buttons,
		));
	?>
	
</center>
<br />


<?php 
	$form = $this->beginWidget( 
		'bootstrap.widgets.TbActiveForm', 
		array(
			'id' => 'product-form',
			'enableAjaxValidation' => false,
			'htmlOptions' => array( 
				'enctype' => 'multipart/form-data'
			) 
		) 
	); 
?>

<div class="row">
	<div class="span3">
		<?php
			
			if( $product->getIsNewRecord() ) {
				$baseUrl = Yii::app()->getBaseUrl( true );
				$actionParams = $this->getActionParams();
				if( key_exists( 'cid', $actionParams ) ) {
					unset( $actionParams[ 'cid' ] );
				}
				$routeUrl = Yii::app()->createUrl( $this->getRoute(), $actionParams );
			
				$htmlOptions = array(
					'disabled' => false,
					'onChange' => 'window.location="' . $baseUrl . $routeUrl . '&cid=" + this.value',
				);
			}
			else {
				$htmlOptions = array( 
					'disabled' => true
				);
			}
	
			echo $form->dropDownListRow( 
				$product, 
				'CategoryID',
				$categories,
				$htmlOptions
			);
		?>
	</div>
	<div class="span3">
		<?php echo $form->dropDownListRow( $product, 'BrandID', $brands ); ?>
	</div>
	<div class="span6">
		<?php echo $form->textFieldRow( $product, 'Name', array( 'class' => 'input-xlarge' ) ); ?>
	</div>
</div>

<div class="row">
	<div class="span6">
		<h4><?php echo Yii::t( 'product', 'Images' ) ?></h4>
		
		<?php 		
			echo $form->fileFieldRow( $product, 'Image' );
		?>

		<?php
		if( !$product->getIsNewRecord() ) {
			if( ( $productImagesDataProvider->itemCount > 0 ) ) {
				// таблица изображений
				$this->widget( 'bootstrap.widgets.TbExtendedGridView', array(
					'dataProvider' => $productImagesDataProvider,

					'afterSortableUpdate' => 'js:function(){}',
					'ajaxUpdate' => false,
					'sortableRows' => true,
					'template' => '{items}',
					'type' => 'striped bordered',

					'columns' => array(
						array( 
							'class' => 'CDataColumn',
							'headerHtmlOptions' => array( 'style' => 'display:none' ),
							'htmlOptions' => array( 'style' => 'display:none' ),
							'type' => 'raw',
							'value' => '\'<input type="hidden" name="ProductHasImagesID[]" value="\' . $data->ProductHasImagesID . \'" />\'',
						),
						array(
							'class' => 'bootstrap.widgets.TbImageColumn',
							'imagePathExpression' => 'Yii::app()->request->baseUrl . \'/\' . Yii::app()->params[ \'imagesFolder\' ] . \'/\' . $data->FileName',
							'imageOptions' => array(
								'width' => 100
							)
						),
						array( 
							'class' => 'CLinkColumn',
							'header' => Yii::t( 'product', 'File Name' ), 
							'labelExpression' => '$data->FileName',
							'urlExpression' => 'Yii::app()->request->baseUrl . \'/\' . Yii::app()->params[ \'imagesFolder\' ] . \'/\' . $data->FileName',
							'linkHtmlOptions' => array(
								'rel' => 'lightbox'
							)
						),
						array(
							'class' => 'bootstrap.widgets.TbButtonColumn',
							'template' => '{delete}',
							'buttons' => array(
								'delete' => array(
									// удалить строку таблицы
									'click' => 'function(){$(this).parent().parent().remove();}',
									'url' => null
								)
							)
						)
					),
				));
			}
		}
		?>		
	</div>
	
	<div class="span6">
		<h4><?php echo Yii::t( 'product', 'Features' ) ?></h4>
		
		<?php	
		foreach( $features as $feature ) {
			echo CHtml::openTag( 'div', array( 'class' => 'row' ) );
			
			echo CHtml::openTag( 'div', array( 'class' => 'span2' ) );
			echo CHtml::label( $feature[ 'Name' ], 'Feature_' . $feature[ 'FeatureID' ] );
			echo CHtml::closeTag( 'div' );
			
			echo CHtml::openTag( 'div', array( 'class' => 'span4' ) );
			echo CHtml::textField( 'FeatureValues[]', $feature[ 'Value' ], array( 'id' => 'Feature_' . $feature[ 'FeatureID' ], 'class' => 'input-xlarge' ) );
			echo CHtml::hiddenField( 'FeatureIDs[]', $feature[ 'FeatureID' ] );
			echo CHtml::closeTag( 'div' );
			
			echo CHtml::closeTag( 'div' );
		}
	?>
	</div>
</div>

<?php echo $form->redactorRow( $product, 'Description', array( 'rows' => 5 ) ); ?>

<div class="row" style="padding-top: 20px;">
	<div class="pull-right">
		<?php 
		$this->widget( 'bootstrap.widgets.TbButton', array(
			'label' => Yii::t( 'application', 'Save' ),
			'icon' => 'ok white',
			'type' => 'primary',
			'buttonType' => 'submit',
		));
	?>
	</div>
</div>

<?php $this->endWidget(); ?>
