#!/bin/bash

version="
him-get version 1.18
    script executer from him-nyit.ddns.net
"
help="
Usage: ./him-get.sh [OPTIONS] SCRIPTS

OPTIONS:
    -h --help    : bring this help topic
    -v --version : display script version
    -s --sudo    : run with elevated priviledge
    -u --update  : update him-get script
    -n --nothing : do not execute script
    -k --keep    : keep the script after execution
    -p --pass    : pass all following but except next argument as parameter of next argument

The options will be processed in entered order.
"
cont=1
none=1
keep=1
pass=1

while [[ $cont == 1 || $# > 0 ]]
do
    # print help for no argument
    if [[ $# == 0 ]]
    then
        echo "$version"
        echo "$help"
        exit 
    fi
    cont=0
    
    # option processing
    if [[ $1 == -* ]]
    then
        # print help topic
        if [[ $1 == "--help" || $1 == "-h" ]]
        then
            echo "$version"
            echo "$help"
            exit
            
        # print script version
        elif [[ $1 == "--version" || $1 == "-v" ]]
        then
            echo "$version"
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
            
        # do update and exit
        elif [[ $1 == "--update" || $1 == "-u" ]]
        then
            cd $(dirname "$0")
            wget him-nyit.ddns.net/scripts/him-get.sh -O him-get.sh
            chmod +x him-get.sh
            exit
            
        # do not execute script
        elif [[ $1 == "--nothing" || $1 == "-n" ]]
        then
            none=0
            shift
            
        # keep script after execution
        elif [[ $1 == "--keep" || $1 == "-k" ]]
        then
            keep=0
            shift
            
        # pass remaining argument
        elif [[ $1 == "--pass" || $1 == "-p" ]]
        then
            pass=0
            shift
            
        # unrecognized option
        else
            echo "unrecognized option: $1"
            echo "$help"
            exit
            
        fi
        
    # execute script
    else
        current=$1
        shift
        
        wget him-nyit.ddns.net/scripts/$current.sh -O $current.sh
        chmod +x $current.sh
        
        if [[ $none == 1 ]]
        then
            if [[ $pass == 1 ]]
            then
                ./$current.sh
            else
                ./$current.sh $*
                shift $#
            fi
        fi
        
        if [[ $keep == 1 ]]
        then
            rm $current.sh
        fi
    fi
done
