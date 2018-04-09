#1/bin/bash
myPath=`pwd`

echo "Stopping Conainer if run"
docker ps -a | grep kolibriDEV | awk -F" " '{print "docker stop "$1 }' | sh
echo "Deleting previus docker"
docker ps -a | grep kolibriDEV | awk -F" " '{print "docker rm "$1 }' | sh
echo "create new container"
docker run --name kolibriDEV -p 80:80 -v $myPath:/var/www/html  -itd nimmis/apache-php5  /usr/sbin/apache2ctl -D FOREGROUND
