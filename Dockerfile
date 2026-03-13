# use an official PHP/Apache base image with mysqli enabled
FROM php:8.2-apache

# enable mysqli extension (needed by your Db class)
RUN docker-php-ext-install mysqli

# enable mod_rewrite for .htaccess
RUN a2enmod rewrite

# copy application code
WORKDIR /var/www/html
COPY . .

# make sure the web server can write if you ever use sessions/files
RUN chown -R www-data:www-data /var/www/html

# expose http port
EXPOSE 80

# Apache already uses CMD ["apache2-foreground"]