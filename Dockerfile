FROM debian
COPY install.sh /
RUN chmod +x /install.sh
RUN /install.sh
COPY . /var/www/html/
#ENTRYPOINT ["/etc/init.d/apache2","start"]
ENTRYPOINT ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]
