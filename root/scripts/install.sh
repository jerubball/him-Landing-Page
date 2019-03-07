#!/bin/bash

version="
him-install version 1.3
    apt package installer from him-nyit.ddns.net
"
help="
Usage: ./install.sh [OPTIONS]

OPTIONS:
    -h --help
        : bring this help topic
    -v --version
        : display script version
    -l --list filename
        : specify package list file
    -d --download filename
        : download and use pakcage list file
          By default, script will download package-list.txt file.

The options will be processed in entered order.
"
contact="
Contact for bug report, suggestion, and other information.
    EMAIL: him.nyit@gmail.com
    WEBSITE: http://him-nyit.ddns.net
"
cont=1
file=1
down=1
list=""
args=""

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
            
        # specify list file
        elif [[ $1 == "--list" || $1 == "-l" ]]
        then
            file=0
            shift
            list="$1"
            shift
            
        # download list file
        elif [[ $1 == "--download" || $1 == "-d" ]]
        then
            file=0
            down=0
            shift
            list="$1"
            shift
            
        # unrecognized option
        else
            echo "unrecognized option: $1"
            echo "$help"
            exit
            
        fi
        
    # execute command
    else
        cont=0
        
        if [[ $(id -u) -ne 0 ]]
        then
            if [[ $down != 1 ]]
            then
                args="$args-d $list "
                
            elif [[ $file != 1 ]]
            then
                args="$args-l $list "
            fi
            
            sudo ./$0 $args$@
            shift $#
            exit
            
        else
            if [[ $file == 1 ]]
            then
                file=0
                down=0
                list="package-list.txt"
            fi
            if [[ $down != 1 ]]
            then
                down=1
                wget him-nyit.ddns.net/scripts/$list -O $list
            fi
            
            list="$(cat $list)"
            
            apt update
            apt upgrade --fix-missing -y
            
            for item in $list
            do
                apt install -y $item
            done
            shift $#
            
            apt update
            apt autoclean -y
            apt upgrade --fix-missing -y
            apt autoremove -y
        fi
    fi
done

