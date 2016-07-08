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
    postfix postfix-pgsql \
    postfix-policyd-spf-python \
    postgrey \
    dovecot-imapd dovecot-pgsql dovecot-sieve dovecot-managesieved dovecot-lmtpd dovecot-pop3d \
    jq \
    && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* \
    && \
    echo "#!/bin/sh\nexit 0" > /usr/sbin/policy-rc.d

ADD ./postfix.sh /postfix.sh
RUN chmod 755 /postfix.sh
ADD ./config/supservisor.conf /etc/supervisor/conf.d/docker.conf

# Postfix configuration
ADD ./config/postfix /etc/postfix/
ADD ./config/policyd-spf.conf /etc/postfix-policyd-spf-python/policyd-spf.conf

# Dovecot configuration
ADD ./config/dovecot /etc/dovecot/

# Copy boot scripts
COPY boot.d/* /boot.d/
RUN chmod 755 /boot.d/*

# Volume to store email
VOLUME ["/vmail"]

# Add user vmail that ownes mail
RUN groupadd -g 5000 vmail
RUN useradd -g vmail -u 5000 vmail -d /vmail -m

EXPOSE 25 143 587
CMD /boot; /etc/init.d/supervisor start; rsyslogd -n
