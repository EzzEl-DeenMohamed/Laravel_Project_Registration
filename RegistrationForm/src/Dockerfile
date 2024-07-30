FROM debian:12

# update packages
ARG TEST
RUN apt update && apt upgrade -y
RUN apt install -y supervisor curl unzip \
    php php-xml php-curl php-zip nano php-mbstring php-mysql

# install composer
RUN curl -sS https://getcomposer.org/installer | php \
    -- --install-dir=/usr/bin --filename=composer

# create server user
RUN groupadd laravel
RUN useradd laravel -u 1000 -g laravel
RUN mkdir -p /home/app
RUN chown -R laravel:laravel /home/app


# add app commands
WORKDIR /home/app
COPY . .
RUN composer update

RUN php artisan octane:install
RUN chmod o+w /home/app/storage/ -R


# run the docker
CMD ["/usr/bin/supervisord", "-c", "/home/app/supervisor.conf"]
