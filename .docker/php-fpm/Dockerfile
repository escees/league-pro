FROM php:7.3-fpm
WORKDIR "/var/www/html"
# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive
#RUN mkdir /usr/share/man/man1
# Install selected extensions and other general stuff
RUN apt-get update && apt-get install -y --no-install-recommends \
        apt-transport-https \
        wget \
        gnupg \
        libssh2-1 \
        libssh2-1-dev \
	libzip-dev 
RUN apt-get update && apt-get install -y --no-install-recommends \
        sudo \
        unzip \
        zlib1g-dev \
        libxml2-dev \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libicu-dev \
        g++ \
        libgd-dev \
        cron \
        supervisor \
        git \
        && apt-get clean && apt-get autoremove; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*
# Install selected php extensions
RUN docker-php-ext-install -j$(nproc) zip \
        pdo \
        pdo_mysql \
        mbstring \
        xml \
        intl \
        gd 
# Install composer
#RUN wget https://getcomposer.org/installer -O - -q | php -- --install-dir=/usr/local/bin --filename=composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
# Install nodejs, npm & yarn
RUN curl -sL https://deb.nodesource.com/setup_11.x  | bash -
RUN apt-get -y install nodejs
RUN npm install
RUN npm install -g gulp
RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | sudo apt-key add -
RUN echo "deb https://dl.yarnpkg.com/debian/ stable main" | sudo tee /etc/apt/sources.list.d/yarn.list
RUN apt-get update && apt-get install yarn
COPY php.ini /usr/local/etc/php/conf.d/php.ini
