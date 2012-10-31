#!/bin/sh

wget -O /tmp/selenium-server-standalone.jar http://selenium.googlecode.com/files/selenium-server-standalone-2.25.0.jar
java -jar /tmp/selenium-server-standalone.jar &

export DISPLAY=:99.0
sudo sh -e /etc/init.d/xvfb start
sleep 3