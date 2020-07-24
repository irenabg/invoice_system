FROM nanoninja/php-fpm:7.3.8
ARG DEBIAN_FRONTEND=noninteractive
RUN apt-get update  -y
RUN apt-get upgrade -y
RUN apt-get install --assume-yes apt-utils && pear install Cache_Lite
RUN echo "America/New_York" > /etc/timezone

# Set environment variables
#ENV DEBIAN_FRONTEND noninteractive
#ENV TERM xterm

ARG ENV
# Install dependencies and tools
RUN apt-get update; \
    apt-get install -y apt-utils apt-transport-https; \
    apt-get install -y curl wget; \
    apt-get install -y libnss-mdns avahi-discover libavahi-compat-libdnssd-dev libkrb5-dev; \
    apt-get install -y ffmpeg; \
    apt-get install -y nano vim; \
    apt-get install -y git; \
    apt-get install -y imagemagick; \
    apt-get install -y gifsicle

#Install Cron
RUN apt-get -y install cron

RUN touch /etc/cron.d/crontab

# Give execution rights on the cron job test
RUN chmod 0644 /etc/cron.d/crontab

RUN echo "ENV=${ENV}"  >> /etc/cron.d/crontab
RUN echo "*/30   *        *	*	*	root  /usr/local/bin/php /usr/local/www/yeptext.protexting.com/bin/watchdogfatalerror.php " >> /etc/cron.d/crontab


# Create the log file to be able to run tail
RUN touch /var/log/cron.log


# Run the command on container startup
#CMD /usr/sbin/cron -f

