#1/bin/bash
myPath=`pwd`

echo "Verify image"
docker image list | grep litrix || docker build . -t litrix
echo "Stopping Conainer if run"
docker ps -a | grep kolibriDEV2 | awk -F" " '{print "docker stop "$1 }' | sh
echo "Deleting previus docker"
docker ps -a | grep kolibriDEV2 | awk -F" " '{print "docker rm "$1 }' | sh
echo "create new container"
docker run --name kolibriDEV2 -p 80:80 -p 443:443 -v $myPath:/var/www/html  -itd litrix  
