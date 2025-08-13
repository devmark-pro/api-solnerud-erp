FROM php:8.4-fpm AS builder

WORKDIR /var/www

RUN ln -snf /usr/share/zoneinfo/Europe/Moscow /etc/localtime 
RUN echo Europe/Moscow > /etc/timezone 
RUN dpkg-reconfigure tzdata 
RUN apt-get update 
RUN apt-get install -y vim git
RUN apt-get install -y wget g++ zlib1g-dev curl libicu-dev libmagickwand-dev libpq-dev libzip-dev libmemcached-dev curl libbz2-dev libpng-dev gettext libfreetype6-dev libmcrypt-dev libjpeg-dev libjpeg62-turbo-dev libldap2-dev pngquant optipng pngcrush libjpeg-progs jpegoptim gifsicle libimage-exiftool-perl libwebp-dev pngnq advancecomp imagemagick libpq-dev && rm -rf /var/lib/apt/lists/* 

RUN mkdir -p /usr/src/php/ext/imagick 
RUN curl -fsSL https://github.com/Imagick/imagick/archive/06116aa24b76edaf6b1693198f79e6c295eda8a9.tar.gz | tar xvz -C "/usr/src/php/ext/imagick" --strip 1 

RUN pecl install redis  


RUN apt-get install -y \
    imagemagick libmagickwand-dev --no-install-recommends \
    && pecl install imagick \
    && docker-php-ext-enable imagick

RUN rm -rf /tmp/pear 
RUN docker-php-source extract 
RUN docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg --with-webp 
RUN docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu/ 
RUN docker-php-ext-configure intl 
RUN docker-php-ext-install -j$(nproc) intl ldap gd bz2 sockets bcmath gettext pdo_mysql pdo pdo_pgsql pgsql zip 
RUN docker-php-ext-enable redis  
RUN docker-php-source delete 
RUN touch /usr/local/etc/php/conf.d/tzone.ini 
RUN printf '[PHP]\ndate.timezone = "Europe/Moscow"\n' > /usr/local/etc/php/conf.d/tzone.ini 
RUN date 
RUN wget https://getcomposer.org/composer-stable.phar -O /usr/local/bin/composer && chmod +x /usr/local/bin/composer 
RUN date 



RUN composer global require laravel/installer
