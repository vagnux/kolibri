#!/bin/bash

apt update
apt -y install apache2
apt -y install php-mbstring
apt -y install php-mysqli
apt -y install php-pdo
apt -y install libapache2-mod-php
apt -y install freetds-common freetds-bin unixodbc php-sybase
apt -y install php-memcache
apt -y install php-memcached
apt -y install php-curl
openssl req $@ -new -x509 -days 365 -nodes -out /etc/ssl/certs/ssl-cert-snakeoil.pem -keyout /etc/ssl/private/ssl-cert-snakeoil.key -subj "/C=BR/ST=Osasco/L=Osasco/O=Global Security/OU=IT Department/CN=exa"
chmod 600 /etc/ssl/certs/ssl-cert-snakeoil.pem
chmod 600 /etc/ssl/private/ssl-cert-snakeoil.key
a2ensite default-ssl
a2enmod ssl
apt-get autoclean
apt-get clean
