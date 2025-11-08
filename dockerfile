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
    php82-xml

# Configure nginx
COPY nginx.conf /etc/nginx/nginx.conf
COPY default.conf /etc/nginx/conf.d/default.conf

# Create web directory
RUN mkdir -p /var/www/html

# Set permissions (intentionally insecure for training)
RUN chmod -R 777 /var/www/html

# Start PHP-FPM and nginx
CMD php-fpm82 && nginx -g 'daemon off;'