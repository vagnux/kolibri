# Dockerfile
FROM nimmis/apache-php5

MAINTAINER Vagner Rodrigues <vagnux@gmail.com>

ADD . /var/www/html

EXPOSE 80
EXPOSE 443
CMD ["/bin/chmod 777 /var/www/html/config"]
CMD ["/bin/chmod 777 /var/www/html/media"]
CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]