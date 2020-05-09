docker build -t mysite -f docker/Dockerfile .
docker run -p 8080:80 -d mysite
