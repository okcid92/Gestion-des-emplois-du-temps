FROM php:8.2-apache

# Installer les extensions PHP nécessaires pour Laravel & MySQL
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Activer le mod_rewrite d'Apache
RUN a2enmod rewrite

# Configurer le répertoire de travail
COPY . /var/www/html
WORKDIR /var/www/html

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# Ajuster les permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Exposer le port par défaut de Render
EXPOSE 80