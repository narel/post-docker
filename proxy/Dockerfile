FROM poczta_core
MAINTAINER narel@utumno.pl

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
    openssl \
    jq \
    vim-tiny \
    && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* && \
    echo "#!/bin/sh\nexit 0" > /usr/sbin/policy-rc.d

# Nice place for your settings
VOLUME ["/mail_settings"]

# forward request and error logs to docker log collector
RUN ln -sf /dev/stdout /var/log/nginx/access.log \
    && ln -sf /dev/stderr /var/log/nginx/error.log

RUN mkdir -p /var/www/cache/tmp \
    && chown -R www-data: /var/www/cache \
    && openssl dhparam -out /etc/nginx/dhparam.pem 2048

ADD nginx.conf /etc/nginx/nginx.conf

EXPOSE 80 443

# Copy boot scripts
COPY boot.d/* /boot.d/
RUN chmod 755 /boot.d/*


CMD /boot; nginx -g "daemon off;"
