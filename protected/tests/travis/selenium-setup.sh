#!/bin/sh

sudo wget -O /tmp/selenium-server-standalone.jar http://selenium.googlecode.com/files/selenium-server-standalone-2.25.0.jar
sudo java -jar /tmp/selenium-server-standalone.jar &

export DISPLAY=:99.0
sh -e /etc/init.d/xvfb start
sleep 3