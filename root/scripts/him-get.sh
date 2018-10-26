#!/bin/bash

help-topic="
him-get: script executer from him-nyit.ddns.net
usage: ./him-get.sh [OPTIONS] SCRIPTS
"
pass=false
keep=false

while [[ $# > 0 ]]
do
    curren=$1
    shift
    
    if [[ $current == "--help" || $current == "-h" ]]
    then
        echo "$help-topic"
        exit
        
    elif [[ $current == "--update" || $current == "-u" ]]
    then
        wget him-nyit.ddns.net/scripts/him-get.sh -O him-get.sh
        exit
        
    elif [[ $current == "--pass" || $current == "-p" ]]
    then
        pass=true
        
    elif [[ $current == "--keep" || $current == "-k" ]]
    then
        keep=true
        
    else
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
done

