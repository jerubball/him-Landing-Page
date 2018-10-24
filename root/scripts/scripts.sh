#!/bin/bash


if [[ $(id -u) -ne 0 ]]
then
    sudo ./$0 $@
else
    wget him-nyit.ddns.net/scripts/him-get.sh -O him-get.sh
    chmod +x him-get.sh
    ./him-get.sh proxy install mysql
    rm him-get.sh
fi

