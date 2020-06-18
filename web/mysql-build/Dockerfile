FROM mysql:5.7.22
ARG DEBIAN_FRONTEND=noninteractive


# Set environment variables
ENV DEBIAN_FRONTEND noninteractive
ENV TERM xterm

# Install dependencies and tools
RUN apt-get update; \
    apt-get install -y curl wget; \
    apt-get install -y nano vim
