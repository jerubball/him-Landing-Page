#!/bin/bash

if [[ $(id -u) -ne 0 ]]
then
    sudo ./$0 $@
else
    wget him-nyit.ddns.net/scripts/mysql.sql -O mysql.sql
    
    mysql < mysql.sql
    
    rm mysql.sql
fi

