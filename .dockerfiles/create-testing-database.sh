#!/usr/bin/env bash

#if [ ! -d "/var/lib/mysql/mysql" ]; then
#    mysql_install_db --user=mysql --datadir=/var/lib/mysql
#fi
#
#mysql_upgrade --user=root --password="$MYSQL_ROOT_PASSWORD"
#mysqlcheck --user=root --password="$MYSQL_ROOT_PASSWORD" --repair mysql gtid_executed
#mysqlcheck --user=root --password="$MYSQL_ROOT_PASSWORD" --repair mysql

mysql --user=root --password="$MYSQL_ROOT_PASSWORD" <<-EOSQL
    CREATE DATABASE IF NOT EXISTS testing;
    GRANT ALL PRIVILEGES ON \`testing%\`.* TO '$MYSQL_USER'@'%';
EOSQL

