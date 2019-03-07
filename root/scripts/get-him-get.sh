#!/bin/bash

version="
him-get-him-get version 1.0
    fix broken him-get script from him-nyit.ddns.net
"
help="
Usage: ./get-him-get.sh [OPTIONS]

OPTIONS:
    -h --help
        : bring this help topic
    -v --version
        : display script version
    -s --sudo
        : run with elevated priviledge

The options will be processed in entered order.
"
contact="
Contact for bug report, suggestion, and other information.
    EMAIL: him.nyit@gmail.com
    WEBSITE: http://him-nyit.ddns.net
"
cont=1

while [[ $cont == 1 || $# > 0 ]]
do
    # option processing
    if [[ $1 == -* ]]
    then
        # print help topic
        if [[ $1 == "--help" || $1 == "-h" ]]
        then
            echo "$version"
            echo "$help"
            echo "$contact"
            exit
            
        # print script version
        elif [[ $1 == "--version" || $1 == "-v" ]]
        then
            echo "$version"
            echo "$contact"
            exit
            
        # run as sudo
        elif [[ $1 == "--sudo" || $1 == "-s" ]]
        then
            if [[ $(id -u) -ne 0 ]]
            then
                shift
                sudo ./$0 $@
                shift $#
                exit
            fi
            
        # unrecognized option
        else
            echo "unrecognized option: $1"
            echo "$help"
            exit
            
        fi
        
    # execute command
    else
        cont=0
        wget him-nyit.ddns.net/scripts/him-get.sh -O him-get.sh
        chmod +x him-get.sh
        exit
    fi
done
