#!/bin/sh

sudo apt-get install php-pear
sudo pear channel-discover pear.symfony.com
sudo pear channel-discover pear.phpunit.de
sudo pear install pear.symfony.com/Yaml
sudo pear install phpunit/PHP_CodeCoverage
sudo pear install --alldeps phpunit/PHPUnit
sudo pear install --alldeps phpunit/PHPUnit_Selenium
