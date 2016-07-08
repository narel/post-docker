#!/usr/bin/env python
#encoding: utf-8

from fabric.api import hosts, env, run, put
from fabric.contrib.project import rsync_project
from fabric.context_managers import cd
from fabric.operations import local as lrun
import os


REMOTE_DIR = '/srv/home/poczta'
SETTINGS_DIR = '/srv/mail/settings'

def prepare_debian8():
    env.user = 'root'
    run('apt-get -y install apt-transport-https ca-certificates')
    run('apt-key adv --keyserver hkp://p80.pool.sks-keyservers.net:80 --recv-keys 58118E89F3A912897C070ADBF76221572C52609D')
    run('echo "deb https://apt.dockerproject.org/repo debian-jessie main" > /etc/apt/sources.list.d/docker.list')
    run('apt-get update')
    run('apt-get -y install docker-engine')
    run('systemctl enable docker')
    run('service docker start')
    run('which pip || apt-get -y install python-pip --no-install-recommends && pip install docker-compose')
    # /lib/systemd/system/docker.service
    # ExecStart=/usr/bin/docker daemon -H fd:// --userland-proxy=false
    print (u"TODO: Modify /lib/systemd/system/docker.service, set:\nExecStart=/usr/bin/docker daemon -H fd:// --userland-proxy=false")

def only_one(name):
    env.user = 'root'
    prod_prepare()
    prod_sync()
    with cd(REMOTE_DIR):
        run('docker-compose build {0}'.format(name))
        run('docker-compose up -d --no-deps {0}'.format(name))

def syslog():
    only_one('syslog')
def core():
    only_one('core')
def amavis():
    only_one('amavis')
def db():
    only_one('db')
def postfixadmin():
    only_one('postfixadmin')
def imapproxy():
    only_one('imapproxy')
def webmail():
    only_one('webmail')
def proxy():
    only_one('proxy')


def prod_prepare():
    env.user = 'root'
    run('mkdir -p {0} {1}'.format(REMOTE_DIR, SETTINGS_DIR))

def prod_sync():
    env.user  = 'root'
    rsync_project(local_dir='.', remote_dir=REMOTE_DIR, exclude=['.git', 'local'], extra_opts='-l --delete')

def prod_start():
    env.user = 'root'
    with cd(REMOTE_DIR):
        run('docker-compose up')

def build():
    env.user = 'root'
    prod_sync()
    with cd(REMOTE_DIR):
        run('docker pull debian:jessie')
        run('docker build -t poczta_base base')
        run('docker-compose build')

def prod():
    env.user = 'root'
    prod_prepare()
    prod_sync()
    prod_start()

def stop():
    env.user = 'root'
    with cd(REMOTE_DIR):
        run('docker-compose down')

def reload():
    env.user = 'root'
    build()
    prod()


def config(directory):
    env.user = 'root'
    lrun('test -d {0}'.format(directory))
    run('mkdir -p {0}'.format(SETTINGS_DIR))
    rsync_project(local_dir='{0}/'.format(directory), remote_dir=SETTINGS_DIR)
    run('chown -R root: {0}'.format(SETTINGS_DIR))

