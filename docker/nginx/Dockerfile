FROM nginx:latest

# Set timezone
RUN rm /etc/localtime \
    && ln -s /usr/share/zoneinfo/UTC /etc/localtime

# Tools
RUN apt-get update && apt-get install -y --no-install-recommends \
    vim \
    mc \
    htop

# User setup
RUN mkdir /home/www-data \
    && usermod -u 1000 -G root -d /home/www-data www-data \
    && groupmod -g 1000 www-data \
    && echo 'alias ll="ls -la"' >> /home/www-data/.bashrc \
    && chown www-data:www-data /home/www-data -R

# Nginx configs
ADD nginx.conf /etc/nginx/
ADD ./sites/*.conf /etc/nginx/conf.d/

# Clean
RUN apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*