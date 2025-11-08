FROM nginx:alpine

# Install PHP and required extensions
RUN apk add --no-cache \
    php82 \
    php82-fpm \
    php82-mysqli \
    php82-json \
    php82-openssl \
    php82-curl \
    php82-session \
    php82-dom \
    php82-xml \
    supervisor

# Configure PHP-FPM to listen on 127.0.0.1:9000
RUN sed -i 's/listen = 127.0.0.1:9000/listen = 127.0.0.1:9000/g' /etc/php82/php-fpm.d/www.conf && \
    sed -i 's/listen = \/run\/php-fpm.sock/listen = 127.0.0.1:9000/g' /etc/php82/php-fpm.d/www.conf

# Configure nginx
COPY nginx.conf /etc/nginx/nginx.conf
COPY default.conf /etc/nginx/conf.d/default.conf

# Create web directory
RUN mkdir -p /var/www/html /var/log/supervisor

# Set permissions (intentionally insecure for training)
RUN chmod -R 777 /var/www/html

# Create supervisor config
RUN echo '[supervisord]' > /etc/supervisord.conf && \
    echo 'nodaemon=true' >> /etc/supervisord.conf && \
    echo 'logfile=/var/log/supervisor/supervisord.log' >> /etc/supervisord.conf && \
    echo '' >> /etc/supervisord.conf && \
    echo '[program:php-fpm]' >> /etc/supervisord.conf && \
    echo 'command=php-fpm82 -F' >> /etc/supervisord.conf && \
    echo 'autostart=true' >> /etc/supervisord.conf && \
    echo 'autorestart=true' >> /etc/supervisord.conf && \
    echo '' >> /etc/supervisord.conf && \
    echo '[program:nginx]' >> /etc/supervisord.conf && \
    echo 'command=nginx -g "daemon off;"' >> /etc/supervisord.conf && \
    echo 'autostart=true' >> /etc/supervisord.conf && \
    echo 'autorestart=true' >> /etc/supervisord.conf

# Start both services with supervisor
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]