#!/bin/sh

sudo apt-get install mysql-server mysql-client
mysql -u root -e 'DROP SCHEMA IF EXISTS uwc2012; CREATE SCHEMA `uwc2012` CHARACTER SET utf8 COLLATE utf8_general_ci; DROP SCHEMA IF EXISTS uwc2012_test; CREATE SCHEMA `uwc2012_test` CHARACTER SET utf8 COLLATE utf8_general_ci; GRANT ALL ON `uwc2012`.* TO uwc2012@localhost IDENTIFIED BY "uwc2012"; GRANT ALL ON `uwc2012_test`.* TO uwc2012@localhost; FLUSH PRIVILEGES;'
mysql -u uwc2012 -puwc2012 uwc2012 < ./protected/data/schema.mysql.sql
mysql -u uwc2012 -puwc2012 uwc2012_test < ./protected/data/schema.mysql.sql
