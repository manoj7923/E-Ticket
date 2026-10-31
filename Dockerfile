# Production Dockerfile for Western Railway E-Ticket Portal
FROM php:8.2-apache

# Install required PHP extensions for MySQL and SQLite
RUN apt-get update && apt-get install -y \
    libsqlite3-dev \
    sqlite3 \
    && docker-php-ext-install mysqli pdo pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

# Enable Apache mod_rewrite for clean URLs
RUN a2enmod rewrite

# Copy project files to Apache root
COPY . /var/www/html/

# Set working directory & permissions
WORKDIR /var/www/html
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && mkdir -p /var/www/html/db \
    && chmod -R 777 /var/www/html/db

# Configure Apache port (supports Render, Railway, Cloud Run $PORT)
ENV PORT=80
EXPOSE 80

CMD sed -i "s/80/$PORT/g" /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf && apache2-foreground
