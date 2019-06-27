FROM debian:stretch

#Install extra packages for PHP repo
RUN apt update && apt -y install apt-transport-https ca-certificates gnupg
#Register PHP repo
COPY ./packages.sury.org.list /etc/apt/sources.list.d/
#Download and install PHP repo key
RUN apt-key adv --fetch-keys https://packages.sury.org/php/apt.gpg
#Install PHP packages - XML and ZIP extensions are required for Composer
RUN apt update && apt -y install php7.2-cli php7.2-xml php7.2-zip php7.2-mysql php7.2-xdebug
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php -r "if (hash_file('sha384', 'composer-setup.php') === '48e3236262b34d30969dca3c37281b3b4bbe3221bda826ac6a9a62d6444cdb0dcd0615698a5cbe587c3f0fe57a54d8f5') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" && \
    php composer-setup.php && \
    php -r "unlink('composer-setup.php');"
#RUN docker-php-ext-install pdo pdo_mysql
#Add XDebug extension configuration
COPY ./xdebug.ini /etc/php/7.2/mods-available/
RUN chmod 644 /etc/php/7.2/mods-available/xdebug.ini
ENV PHP_IDE_CONFIG="serverName=Docker"
#Create folder for PHP App
RUN mkdir -p /var/php_app
WORKDIR /var/php_app
VOLUME /var/php_app
#Setup development server for PHP App
EXPOSE 80
CMD mkdir -p ./public && php -S 0.0.0.0:80 -t ./public

#It is possible to make image thinner with '&& apt clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*' after each apt install.
#It will remove unnecessary cache and documentation files after package installation but it will make installation of new packages during development longer.
