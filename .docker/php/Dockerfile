FROM php:7.4-alpine

RUN docker-php-ext-install pdo pdo_mysql \
  && docker-php-ext-enable pdo_mysql

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/bin --filename=composer \
    && php -r "unlink('composer-setup.php');"