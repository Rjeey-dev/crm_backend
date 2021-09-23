FROM nginx:latest

ADD nginx.conf /etc/nginx/

ADD app.template /etc/nginx/sites-available/

RUN rm /etc/nginx/conf.d/default.conf

RUN echo "upstream php-upstream { server php_service:9000; }" > /etc/nginx/conf.d/upstream.conf

RUN usermod -u 1000 www-data

COPY server_run.sh /var/www/

CMD sh /var/www/server_run.sh