FROM debian:jessie

ENV DEBIAN_FRONTEND noninteractive

# Prerequisites
RUN printf "#!/bin/sh\nexit 101" > /usr/sbin/policy-rc.d && chmod a+x /usr/sbin/policy-rc.d \
    && \
    apt-get update \
    && \
    apt-get install -y locales && \
    printf "pl_PL.UTF-8 UTF-8\nen_US.UTF-8 UTF-8" > /etc/locale.gen && dpkg-reconfigure locales \
    && \
    apt-get install -y --no-install-recommends \
    syslog-ng \
    jq \
    vim-tiny \
    less \
    lnav \
    && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* && \
    echo "#!/bin/sh\nexit 0" > /usr/sbin/policy-rc.d

# locales
RUN printf "pl_PL.UTF-8 UTF-8\nen_US.UTF-8 UTF-8" > /etc/locale.gen && dpkg-reconfigure locales

VOLUME ["/var/log"]

ADD syslog-ng.conf /etc/syslog-ng/syslog-ng.conf
COPY lv /usr/local/bin/lv
RUN chmod 755 /usr/local/bin/lv

EXPOSE 514/tcp 514/udp
CMD /usr/sbin/syslog-ng -F -f /etc/syslog-ng/syslog-ng.conf --no-caps
