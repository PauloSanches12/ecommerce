FROM php:8.4-fpm

# Modifica o usuário www-data para usar UID e GID 1000
RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

# Definir o diretório de trabalho
WORKDIR /var/www

# Instalar dependências
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libonig-dev \
    libzip-dev

# Limpar cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar extensões PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar código-fonte e definir permissões
COPY . /var/www
RUN chown -R www-data:www-data /var/www
RUN chmod -R 775 /var/www

# Alternar para o usuário www-data
USER www-data

# Expor a porta 9000
EXPOSE 9000

# Iniciar o PHP-FPM
CMD ["php-fpm"]