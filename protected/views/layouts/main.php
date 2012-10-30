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
						'<form class="navbar-search pull-right" action="">				
							<input type="text" class="search-query" placeholder="Поиск">
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
