<?php
return CMap::mergeArray(
	require(dirname( __FILE__ ) . '/main.php'), array(
		'components' => array(
			'fixture' => array(
				'class' => 'system.test.CDbFixtureManager',
			),
			'db' => array(
				'connectionString' => 'mysql:host=localhost;dbname=uwc2012_test',
				'emulatePrepare' => true,
				'username' => 'uwc2012',
				'password' => 'uwc2012',
				'charset' => 'utf8',
			),
		),
	)
);
