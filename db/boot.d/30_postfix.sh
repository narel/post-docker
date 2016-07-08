#!/bin/bash
set -x
echo "Running `basename "$0"`"

CONFIG_FILE=/mail_settings/config.json

DB_PASSWORD=$(jq -r '.settings.db_password' $CONFIG_FILE)

sleep 5
export PGUSER=postgres
echo "CREATE USER postfix" | psql
echo "CREATE DATABASE postfix" | psql
echo "ALTER ROLE postfix WITH PASSWORD '$DB_PASSWORD'" 
echo "ALTER ROLE postfix WITH PASSWORD '$DB_PASSWORD'" | psql
echo "GRANT ALL PRIVILEGES ON DATABASE postfix TO postfix" | psql
