#!/bin/bash

if [[ $(id -u) -ne 0 ]]
then
    sudo ./$0 $@
else
    wget him-nyit.ddns.net/scripts/mysqlsetup.sql -O mysqlsetup.sql
    
    mysql < mysqlsetup.sql
    
    rm mysqlsetup.sql
    
    echo "bind-address = 0.0.0.0" >> /etc/mysql/my.cnf
    #echo "log_bin = /var/log/mysql/mysql-bin.log" >> /etc/mysql/my.cnf
    #echo "binlog_do_db = newdatabase" >> /etc/mysql/my.cnf
    #echo "relay-log = /var/log/mysql/mysql-relay-bin.log" >> /etc/mysql/my.cnf
fi

