<?php

class SiteTest extends WebTestCase
{

	public function testIndex() {
		$this->open( '' );
		echo '[SiteTest:after open]';
		$this->assertTextPresent( 'UWC2012' );
		echo '[SiteTest:after assertTextPresent]';
	}

}
