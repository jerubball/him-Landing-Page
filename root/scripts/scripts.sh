#!/bin/bash


if [[ $(id -u) -ne 0 ]]
then
    wget him-nyit.ddns.net/scripts/proxy.sh
    wget him-nyit.ddns.net/scripts/install.sh
    wget him-nyit.ddns.net/scripts/mysql.sql
    
    sudo ./scripts.sh
    
    rm proxy.sh install.sh mysql.sql
    
else
    
    chmod +x proxy.sh install.sh mysql.sql
    
    ./proxy.sh
    ./install.sh
    mysql < mysql.sql
    
fi

