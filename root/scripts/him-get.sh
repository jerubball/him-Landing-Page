#!/bin/bash

if [[ $(id -u) -ne 0 ]]
then
    sudo ./$0 $@
else
    while [[ $# > 0 ]]
    do
        wget him-nyit.ddns.net/scripts/$1.sh -O $1.sh
        chmod +x $1.sh
        ./$1.sh
        rm $1.sh
        shift
    done
fi

