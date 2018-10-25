#!/bin/bash

pass=false
keep=false

if [[ $(id -u) -ne 0 ]]
then
    sudo ./$0 $@
else
    while [[ $# > 0 ]]
    do
        if [[ $1 == "--help"     ]]
        then
            echo "
him-get: script executer from him-nyit.ddns.net
usage: ./him-get.sh [OPTIONS] SCRIPTS
"
            exit
        elif [[ $1 == "--pass" ]]
        then
        else
            wget him-nyit.ddns.net/scripts/$1.sh -O $1.sh
            chmod +x $1.sh
            ./$1.sh
            rm $1.sh
        fi
        shift
    done
fi

