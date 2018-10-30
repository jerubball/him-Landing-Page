#!/bin/bash

help="
him-ssh: 
"
sudo=false
next=false

while [[ $next == false && $# > 0 ]]
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
    else
        next=true
    fi
done

    ssh ieee@EGGC-603-14 $@
    ssh ieee@EGGC-603-15 $@
    ssh ieee@EGGC-603-16 $@
    ssh ieee@EGGC-603-17 $@
    ssh ieee@EGGC-603-18 $@
    ssh ieee@EGGC-603-19 $@

