#!/bin/bash
arg_1="$1"
arg_2="$2"
arg_3="$3"

# should add a start prod

if [ "$arg_1" == "start" ] ; then
  echo "Build webserver container"
	docker build -t livingmarkup -f docker/Dockerfile .
  if [ "$arg_2" == "prod" ] ; then
    echo "Run webserver for production"
  	docker run -p 80:80 -p 443:443 --name livingmarkup --volume $(pwd):/var/www -d livingmarkup
  else
    # mount local volume for rapid development
    echo "Run webserver for development"
  	docker run -p 80:80 -p 443:443 --name livingmarkup --volume $(pwd):/var/www -d livingmarkup
  fi
elif [ "$arg_1" == "stop" ] ; then
  echo "Stop webserver container"
  docker stop livingmarkup
  echo "Remove webserver container"
  docker rm livingmarkup
elif [ "$arg_1" == "shell" ]; then
  echo "Exec into webserver"
  docker exec -it livingmarkup bash,
else
  echo "Pass argument 'stop' or 'start'"
fi


