<?php

class SiteTest extends WebTestCase
{

	public function testIndex() {
		$this->open( '' );
		$this->assertTextPresent( 'UWC2012' );
	}

}
