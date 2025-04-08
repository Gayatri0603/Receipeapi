FROM quay.io/hellofresh/php70:7.1

ADD ./docker/nginx/default.conf /etc/nginx/sites-available/default

RUN sed -i -e "s/;clear_env\s*=\s*no/clear_env = no/g" /etc/php/7.1/fpm/pool.d/www.conf

ENV APP_DIR /server/http

ADD . ${APP_DIR}

WORKDIR ${APP_DIR}

RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

EXPOSE 80
