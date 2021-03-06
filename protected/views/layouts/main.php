<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html lang="<?php echo Yii::app()->language; ?>">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="language" content="<?php echo Yii::app()->language; ?>" />

		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
		
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/slimbox2.css" media="screen" />
		
		<?php Yii::app()->clientScript->registerScriptFile( Yii::app()->request->baseUrl . '/js/app.js', CClientScript::POS_END ) ?>
		<?php Yii::app()->clientScript->registerScriptFile( Yii::app()->request->baseUrl . '/js/slimbox2.js', CClientScript::POS_END ) ?>

		<title><?php echo CHtml::encode( $this->pageTitle ); ?></title>
	</head>

	<body>
		<div class="container" id="page">
			<div id="header">
				<?php
				
				// создать меню для выбора языков
				$languageMenuItem = array(
					'icon' => 'globe',
					'items' => array()
				);
				
				foreach( $this->languagesMenu as $language ) {
					$languageMenuItem[ 'items' ][] = array( 
						'label' => $language->Code, 
						'url' => Yii::app()->createUrl( $this->getRoute(), array_merge( $this->getActionParams(), array( 'lc' => $language->Code ) ) ) 
					);
				}
				
				
				// создать меню управления
				if( Yii::app()->user->isGuest ) {
					$configMenuItem = array(
						'icon' => 'cog',
						'items' => array(
							array( 'label' => Yii::t( 'application', 'Login' ), 'url' => Yii::app()->createUrl( '/site/login', array( 'lc' => Yii::app()->language ) ), 'icon' => 'user' ),
						)
					);
				}
				else {
					$configMenuItem = array(
						'icon' => 'cog',
						'items' => array(
							array( 'label' => Yii::t( 'category', 'Add category' ), 'url' => Yii::app()->createUrl( 'category/create', array( 'lc' => Yii::app()->language ) ), 'icon' => 'plus' ),
							array( 'label' => Yii::t( 'product', 'Add product' ), 'url' => Yii::app()->createUrl( 'product/create', array( 'lc' => Yii::app()->language ) ), 'icon' => 'plus' ),
							array( 'label' => Yii::t( 'product', 'Export products' ), 'url' => Yii::app()->createUrl( 'product/export', array( 'lc' => Yii::app()->language ) ), 'icon' => 'share' ),
							'---',
							array( 'label' => Yii::t( 'brand', 'Brands' ), 'url' => Yii::app()->createUrl( 'brand/list', array( 'lc' => Yii::app()->language ) ), 'icon' => 'list' ),
							array( 'label' => Yii::t( 'feature', 'Features' ), 'url' => Yii::app()->createUrl( 'feature/list', array( 'lc' => Yii::app()->language ) ), 'icon' => 'list' ),
							'---',						
							array( 'label' => Yii::t( 'application', 'Logout' ), 'url' => Yii::app()->createUrl( 'site/logout', array( 'lc' => Yii::app()->language ) ), 'icon' => 'off' ),
						)
					);
				}
				
				
				// отрисовать главное меню
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
						
						array(
							'class' => 'bootstrap.widgets.TbMenu',
							'htmlOptions' => array(
								'class' => 'pull-right'
							),
							'items' => array( 
								$languageMenuItem, 
								$configMenuItem 
							),
						),
						
						'<form class="navbar-search form-search pull-right" action="' . Yii::app()->createUrl( 'product/search', array( 'lc' => Yii::app()->language ) ) . '">
							<div class="input-append">
								<input name="q" type="text" class="search-query" placeholder="' . Yii::t( 'application', 'Searсh' ) . '" />
								<button type="submit" class="btn"><i class="icon-search"></i></button>
							</div>
						</form>',
					)
				) );
				?>
		
				<?php 
				// хлебные крошки
				if( isset( $this->breadcrumbs ) ) {
					$this->widget( 'bootstrap.widgets.TbBreadcrumbs', array(
						'links' => $this->breadcrumbs,
					) );
				}
				?>
				
				<?php
				// кнопка "Наверх"
				$this->widget( 'bootstrap.widgets.TbButton',array(
					'label' => Yii::t( 'application', 'Back to top' ),
					'icon' => 'arrow-up white',
					'type' => 'inverse',
					'htmlOptions' => array(
						'class' => 'top-link',
						'onClick' => 'scroll(0,0); return false;'
					)
				));
				?>
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
