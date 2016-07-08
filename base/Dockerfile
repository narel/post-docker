FROM debian:jessie

MAINTAINER Karol Czachorowski <narel@utumno.pl>

ENV DEBIAN_FRONTEND noninteractive
RUN sed -i "s/jessie main$/jessie main contrib non-free/" /etc/apt/sources.list

# Prerequisites
RUN printf "#!/bin/sh\nexit 101" > /usr/sbin/policy-rc.d && chmod a+x /usr/sbin/policy-rc.d \
    && \
    apt-get update \
    && \
    apt-get install -y locales && \
    printf "pl_PL.UTF-8 UTF-8\nen_US.UTF-8 UTF-8" > /etc/locale.gen && dpkg-reconfigure locales \
    && \
    apt-get install -y --no-install-recommends \
    supervisor \
    rsyslog \
    jq \
    ssl-cert \
    vim-tiny \
    dnsutils \
    && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* && \
    echo "#!/bin/sh\nexit 0" > /usr/sbin/policy-rc.d && \
	printf "pl_PL.UTF-8 UTF-8\nen_US.UTF-8 UTF-8" > /etc/locale.gen && dpkg-reconfigure locales && \
    mkdir -p /boot.d

COPY boot /
RUN chmod 755 /boot

# Nice place for your settings
VOLUME ["/mail_settings"]

ADD ./rsyslog.conf /etc/rsyslog.conf

CMD /boot; /etc/init.d/supervisor start; rsyslogd -n
