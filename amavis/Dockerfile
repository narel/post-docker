FROM poczta_base

ENV DEBIAN_FRONTEND noninteractive
RUN sed -i "s/jessie main$/jessie main contrib non-free/" /etc/apt/sources.list

# Prerequisites
RUN printf "#!/bin/sh\nexit 101" > /usr/sbin/policy-rc.d && chmod a+x /usr/sbin/policy-rc.d \
    && \
    apt-get update \
    && \
    apt-get install -y --no-install-recommends \
    amavisd-new \
    libdbd-pg-perl \
    spamassassin \
    libnet-dns-perl \
    libmail-spf-perl \
    pyzor \
    razor \
    clamav clamav-daemon clamav-freshclam \
    unrar p7zip unzip rpm arj zoo p7zip-full cabextract lzop lrzip nomarch unrar-free \
    && \
    apt-get clean \
    && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* \
    && \
    echo "#!/bin/sh\nexit 0" > /usr/sbin/policy-rc.d

# Set up razor and pyzor
RUN adduser clamav amavis && adduser amavis clamav \
    && chmod -R 775 /var/lib/amavis/tmp \
    && su - amavis -s /bin/bash && razor-admin -create && razor-admin -register && pyzor discover

COPY ./config/conf.d /etc/amavis/conf.d
COPY ./config/clamd.conf /etc/clamav/clamd.conf
COPY ./config/freshclam.conf /etc/clamav/freshclam.conf
COPY ./config/supservisor.conf /etc/supervisor/conf.d/docker.conf

# Nice place for your settings
VOLUME ["/mail_settings"]

# persistent storage
#VOLUME ["/var/lib/amavis"]
#VOLUME ["/var/lib/clamav"]

# Copy boot scripts
COPY boot.d/* /boot.d/
RUN chmod 755 /boot /boot.d/*

ENV AMAVIS=true

EXPOSE 10024
CMD /boot; /etc/init.d/supervisor start; rsyslogd -n
