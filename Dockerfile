# Use PHP 8 image with Apache
FROM php:8.0-apache

# Install necessary PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copy the app files to the web root
COPY . /var/www/html

# Set permissions for Apache
RUN chown -R www-data:www-data /var/www/html

# Enable Apache rewrite module
RUN a2enmod rewrite
