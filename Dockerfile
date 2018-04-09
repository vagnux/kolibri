# Dockerfile
FROM nimmis/apache-php5

MAINTAINER SemaphoreCI <dev@semaphoreci.com>

ADD . /var/www/html
RUN chmod 777 -R /var/www/html/config
RUN chmod 777 -R /var/www/html/media

EXPOSE 80
EXPOSE 443

CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]