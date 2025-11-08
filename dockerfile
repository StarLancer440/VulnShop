FROM php:8.2-fpm-alpine

# Install nginx and required extensions
RUN apk add --no-cache \
    nginx \
    supervisor \
    && docker-php-ext-install mysqli pdo pdo_mysql

# Configure PHP-FPM
RUN sed -i 's/listen = 127.0.0.1:9000/listen = 9000/g' /usr/local/etc/php-fpm.d/www.conf

# Configure nginx
COPY nginx.conf /etc/nginx/nginx.conf
COPY default.conf /etc/nginx/http.d/default.conf

# Create necessary directories
RUN mkdir -p /var/www/html /run/nginx /var/log/supervisor

# Set permissions
RUN chmod -R 777 /var/www/html

# Create supervisor config
COPY supervisord.conf /etc/supervisord.conf

EXPOSE 80

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]