FROM node:11.3

# Set timezone
RUN rm /etc/localtime \
    && ln -s /usr/share/zoneinfo/UTC /etc/localtime

# Tools
RUN apt-get update && apt-get install -y --no-install-recommends \
    vim \
    mc \
    htop

# User setup
RUN usermod -a -G staff node \
    && echo 'alias ll="ls -la"' >> /home/node/.bashrc \
    && echo 'alias ..="cd .."' >> /home/node/.bashrc

# NPM
RUN npm install -g webpack webpack-cli

# Clean
RUN apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /var/cache/*