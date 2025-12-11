# Use an official PHP runtime as a parent image
FROM php:8.2-apache

# Install required system packages and dependencies
RUN apt-get update && apt-get install -y \
  libpq-dev \
  && rm -rf /var/lib/apt/lists/*

# Set the working directory in the container
WORKDIR /var/www/html

# Copy the current directory contents into the container at /var/www/html
COPY . /var/www/html

# Install PHP extensions for PostgreSQL and MySQL
RUN docker-php-ext-install pdo_pgsql pdo_mysql

# Copy custom Apache configuration
COPY apache.config /etc/apache2/sites-available/000-default.conf

# Enable Apache modules
RUN a2enmod rewrite

# Create uploads directory with proper permissions
RUN mkdir -p /var/www/html/uploads && chmod 755 /var/www/html/uploads

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html

# Expose port 8080 for Render
EXPOSE 8080

# Update Apache to listen on 8080
RUN sed -i 's/Listen 80/Listen 8080/g' /etc/apache2/ports.conf
