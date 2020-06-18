FROM nanoninja/php-fpm:7.3.8
ARG DEBIAN_FRONTEND=noninteractive
RUN apt-get update  -y
RUN apt-get upgrade -y
RUN apt-get install --assume-yes apt-utils && pear install Cache_Lite

# Set environment variables
#ENV DEBIAN_FRONTEND noninteractive
#ENV TERM xterm

# Install dependencies and tools
RUN apt-get update; \
    apt-get install -y apt-utils apt-transport-https; \
    apt-get install -y curl wget; \
    apt-get install -y libnss-mdns avahi-discover libavahi-compat-libdnssd-dev libkrb5-dev; \
    apt-get install -y nano vim; \
    apt-get install -y imagemagick

#Install Cron
RUN apt-get -y install cron

RUN touch /etc/cron.d/crontab

# Give execution rights on the cron job
RUN chmod 0644 /etc/cron.d/crontab



# Create the log file to be able to run tail
RUN touch /var/log/cron.log


# Run the command on container startup
#CMD /usr/sbin/cron -f

