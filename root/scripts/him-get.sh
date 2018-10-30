#!/bin/bash

help="
him-get: script executer from him-nyit.ddns.net
usage: ./him-get.sh [OPTIONS] SCRIPTS

OPTIONS:
    -h --help   : bring this help topic
    -s --sudo   : run with elevated priviledge
    -u --update : update him-get script
    -k --keep   : keep the script after execution
    -p --pass   : pass all following but except next argument as parameter of next argument

The options will be parsed in entered order.
"
pass=false
keep=false
sudo=false

while [[ $# > 0 ]]
do
    if [[ $1 == "--help" || $1 == "-h" ]]
    then
        echo "$help"
        exit
        
    elif [[ $1 == "--sudo" || $1 == "-s" ]]
    then
        if [[ $(id -u) -ne 0 ]]
        then
            shift
            sudo ./$0 $@
            shift $#
        fi
        exit
        
    elif [[ $1 == "--update" || $1 == "-u" ]]
    then
        cd $(dirname "$0")
        wget him-nyit.ddns.net/scripts/him-get.sh -O him-get.sh
        chmod +x him-get.sh
        exit
        
    elif [[ $1 == "--keep" || $1 == "-k" ]]
    then
        keep=true
        
    elif [[ $1 == "--pass" || $1 == "-p" ]]
    then
        pass=true
        
    else
        current=$1
        shift
        
        wget him-nyit.ddns.net/scripts/$current.sh -O $current.sh
        chmod +x $current.sh
        
        if [[ $pass == false ]]
        then
            ./$current.sh
        else
            ./$current.sh $*
            shift $#
        fi
        
        if [[ $keep == false ]]
        then
            rm $current.sh
        fi
    fi
    shift
done

