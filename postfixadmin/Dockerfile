FROM poczta_base

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
    nginx \
    php5-fpm php5-cli php5-json php5-mcrypt php5-pgsql php5-gd php5-curl php5-imap \
    dovecot-core \
    postgresql-client-9.4 \
    && \
    apt-get clean \
    && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* \
    && \
    printf "#!/bin/sh\nexit 0" > /usr/sbin/policy-rc.d

ADD config/nginx.site /etc/nginx/sites-available/default
RUN rm -f /etc/nginx/sites-enabled/default && ln -s /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default

COPY postfixadmin-2.93.tar.gz /postfixadmin.tar.gz
RUN mkdir /www && tar zxfv /postfixadmin.tar.gz -C /www/ --strip-components=1 && rm -f /postfixadmin.tar.gz && chown -R www-data: /www/

ADD config/config.inc.php /www/config.inc.php
ADD password.php /password.php

ADD ./config/supservisor.conf /etc/supervisor/conf.d/docker.conf

# Copy boot scripts
COPY boot.d/* /boot.d/
RUN chmod 755 /boot.d/*

EXPOSE 8081
CMD /boot; /etc/init.d/supervisor start; rsyslogd -n
