export USER_ID=$(id -u)
export GROUP_ID=$(id -g)

docker-compose build --build-arg UID=$(id -u) --build-arg GID=$(id -g) app

if [ $? -eq 0 ]; then
    echo "The APP build process was successfulL!";
    docker-compose up -d
    docker exec -it demo-app bash -c 'cd /var/www && composer install && npm install && php artisan key:generate';
    echo "DONE";
else
    echo "The build process was fail!"
fi
