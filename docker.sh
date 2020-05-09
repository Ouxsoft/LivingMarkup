#!/bin/bash
arg_1="$1"
arg_2="$2"
arg_3="$3"

if [ "$arg_1" == "start" ] ; then
	docker build -t livingmarkup -f docker/Dockerfile .
	docker run -p 80:80 -p 443:443 --name livingmarkup --volume $(pwd):/var/www -d livingmarkup
elif [ "$arg_1" == "stop" ] ; then
  docker stop livingmarkup
  docker rm livingmarkup
elif [ "$arg_1" == "shell" ]; then
  docker exec -it livingmarkup bash
else
  echo "Pass argument 'stop' or 'start'"
fi


