#!/bin/bash


if [[ $(id -u) -ne 0 ]]
then
    sudo ./$0 $@
else
    ufw enable
    ufw default deny
    ufw allow from 192.168.0.0/16
    ufw allow to 192.168.0.0/16
    ufw allow 21
    ufw allow 22
    ufw allow 23
    ufw allow 80
    ufw allow 443
    ufw allow 3306
    ufw allow 3389
    ufw allow 6881
    ufw allow 7777
fi

