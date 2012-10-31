#!/bin/sh

sudo apt-get install apache2 libapache2-mod-php5 curl
sudo a2enmod rewrite
echo "$(curl -fsSL https://raw.github.com/gist/3964572/6fcdf09a83a9079f141892f07d080ade450057b3/uwc2012_virtualhost)" | sed -e "s,PATH,`pwd`,g" | sudo tee -a /etc/apache2/sites-available/default > /dev/null
echo "$(curl -fsSL https://raw.github.com/gist/3964586/eec75dbd04c3f9cdf7342a5616a2069f9e86edbd/uwc2012_hosts)" | sudo tee -a /etc/hosts > /dev/null
sudo service apache2 restart