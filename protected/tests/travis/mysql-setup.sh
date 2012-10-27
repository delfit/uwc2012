#!/bin/sh

mysql -u root -e 'CREATE SCHEMA `uwc2012` CHARACTER SET utf8 COLLATE utf8_general_ci; CREATE SCHEMA `uwc2012_test` CHARACTER SET utf8 COLLATE utf8_general_ci; GRANT ALL ON `uwc2012`.* TO uwc2012@localhost IDENTIFIED BY "uwc2012"; GRANT ALL ON `uwc2012_test`.* TO uwc2012@localhost; FLUSH PRIVILEGES;'
