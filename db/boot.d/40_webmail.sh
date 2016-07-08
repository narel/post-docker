#!/bin/bash
echo "Running `basename "$0"`"

CONFIG_FILE=/mail_settings/config.json

DB_PASSWORD=$(jq -r '.webmail.db_password' $CONFIG_FILE)

export PGUSER=postgres
echo "CREATE USER webmail;" | psql
echo "CREATE DATABASE webmail;" | psql
echo "ALTER ROLE webmail WITH PASSWORD '$DB_PASSWORD';" | psql
echo "GRANT ALL PRIVILEGES ON DATABASE webmail TO webmail;" | psql
