# Dockerfile
FROM nimmis/apache-php5

MAINTAINER SemaphoreCI <dev@semaphoreci.com>

ADD . /var/www/html

EXPOSE 80
EXPOSE 443

CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]