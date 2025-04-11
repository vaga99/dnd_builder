FROM php:8.2-cli
COPY . /usr/src/myapp
WORKDIR /app
RUN install-php-extensions pdo_mysql
CMD [ "php", "./your-script.php" ]
