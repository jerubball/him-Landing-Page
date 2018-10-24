#!/bin/bash


if [[ $(id -u) -ne 0 ]]
then
    sudo ./$0
else
    wget him-nyit.ddns.net/scripts/proxy.sh
    wget him-nyit.ddns.net/scripts/install.sh
    wget him-nyit.ddns.net/scripts/mysql.sql
    
    chmod +x proxy.sh install.sh mysql.sql
    
    ./proxy.sh
    ./install.sh
    mysql < mysql.sql
    
    rm proxy.sh install.sh mysql.sql
fi

