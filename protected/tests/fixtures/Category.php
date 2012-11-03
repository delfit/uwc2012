<?php
return array(
	// корневые категории
	'notebooksAndComputers' => array(
		'CategoryID' => 1,
		'ParentCategoryID' => null
	),
	'tvPhotoAndVideo' => array(
		'CategoryID' => 2,
		'ParentCategoryID' => null
	),
	
	// категории второго уровня
	'notebooksAndMobile' => array(
		'CategoryID' => 3,
		'ParentCategoryID' => 1
	),
	'components' => array(
		'CategoryID' => 4,
		'ParentCategoryID' => 1
	),
	
	// категории третьего уровня
	'notebooks' => array(
		'CategoryID' => 5,
		'ParentCategoryID' => 3
	),
	'tablets' => array(
		'CategoryID' => 6,
		'ParentCategoryID' => 3
	),
);