<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="language" content="ru" />

		<!-- blueprint CSS framework -->
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
		<!--[if lt IE 8]>
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
		<![endif]-->

		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
		
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/slimbox2.css" media="screen" />
		
		
		<?php Yii::app()->clientScript->registerScriptFile( Yii::app()->request->baseUrl . '/js/slimbox2.js', CClientScript::POS_END ) ?>
		

		<title><?php echo CHtml::encode( $this->pageTitle ); ?></title>
	</head>

	<body>
		<div class="container" id="page">
			<div id="header">
				<?php
				$this->widget( 'bootstrap.widgets.TbNavbar', array(
					'brand' => CHtml::encode( Yii::app()->name ), 
					'brandUrl' => Yii::app()->homeUrl, 
					'collapse' => true, 
					'fluid' => true,
					'items' => array(
						array(
							'class' => 'bootstrap.widgets.TbMenu',
							'items' => $this->mainMenu,
						),
						'<form class="navbar-search form-search pull-right" action="' . Yii::app()->request->baseUrl . '/search' . '">
							<div class="input-append">
								<input name="q" type="text" class="search-query" placeholder="Поиск">
								<button type="submit" class="btn"><i class="icon-search"></i></button>
							</div>
						</form>',
					)
				) );
				?>
		
				<?php if( isset( $this->breadcrumbs ) ): ?>
					<?php
					$this->widget( 'bootstrap.widgets.TbBreadcrumbs', array(
						'links' => $this->breadcrumbs,
					) );
					?><!-- breadcrumbs -->
				<?php endif ?>
			</div>
			

			<?php echo $content; ?>
			

			<div class="clear"></div>
			
			<div id="footer">
				&copy; Delfit <?php echo date( 'Y' ); ?><br/>
				<?php echo Yii::powered(); ?>
			</div><!-- footer -->

		</div><!-- page -->
		
	</body>
</html>
