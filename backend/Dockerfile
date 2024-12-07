# Usa la imagen oficial de PHP con FPM y Composer
FROM php:8.2-fpm

# Instalar dependencias necesarias para Laravel
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install zip pdo_mysql

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establecer el directorio de trabajo
WORKDIR /var/www

# Copiar los archivos del proyecto al contenedor
COPY . .

# Instalar las dependencias de Laravel
RUN composer install

# Establecer permisos
RUN chown -R www-data:www-data /var/www && chmod -R 755 /var/www

# Expone el puerto 9000
EXPOSE 9000

# Comando para iniciar el servidor PHP
CMD ["php-fpm"]
