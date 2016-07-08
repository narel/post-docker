FROM postgres:latest


# Prerequisites
ENV DEBIAN_FRONTEND noninteractive
RUN apt-get update \
    && \
    apt-get install -y locales jq vim-tiny && \
    printf "pl_PL.UTF-8 UTF-8\nen_US.UTF-8 UTF-8" > /etc/locale.gen && dpkg-reconfigure locales \
    && \
    apt-get clean \
    && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*


ENV POSTGRES_PASSWORD=gaipoYaihahx1no9wule
#RUN locale-gen en_US.UTF-8 en_us pl_PL.UTF-8 pl_PL && printf "pl_PL.UTF-8\nen_US.UTF-8" > /etc/locale.gen && dpkg-reconfigure locales
RUN localedef -i pl_PL -c -f UTF-8 -A /usr/share/locale/locale.alias pl_PL.UTF-8
ENV LANG pl_PL.UTF8
VOLUME ["/mail_settings"]
ADD boot.d /docker-entrypoint-initdb.d

