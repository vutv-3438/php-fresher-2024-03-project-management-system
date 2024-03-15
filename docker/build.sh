export USER_ID=$(id -u)
export GROUP_ID=$(id -g)

docker-compose build app

if [ $? -eq 0 ]; then
    echo "The APP build process was successfulL!";
    docker-compose up -d
    docker exec -it demo-app bash -c 'cd /var/www && chmod -R 777 storage && composer install && npm install && php artisan key:generate';
    echo "DONE";
else
    echo "The build process was fail!"
fi
