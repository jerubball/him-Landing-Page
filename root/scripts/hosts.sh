#!/bin/bash

version="
him-hosts version 1.4
    intranet host name script from him-nyit.ddns.net
"
help="
Usage: ./hosts.sh [OPTIONS]

OPTIONS:
    -h --help
        : bring this help topic
    -v --version
        : display script version
    -h --host filename
        : specify file with hostnames
    -d --download filename
        : download and use remote hostnames
          By default, script will download ip-list-all.txt file.

The options will be processed in entered order.
"
cont=1
host=1
down=1
file=""
heading="# The following lines define named intranet hosts"

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
            exit
            
        # print script version
        elif [[ $1 == "--version" || $1 == "-v" ]]
        then
            echo "$version"
            exit
            
        # specify host file
        elif [[ $1 == "--host" || $1 == "-h" ]]
        then
            host=0
            shift
            file="$1"
            shift
            
        # download host file
        elif [[ $1 == "--download" || $1 == "-d" ]]
        then
            host=0
            down=0
            shift
            file="$1"
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
                $args="$args-d $file "
                
            elif [[ $host != 1 ]]
            then
                $args="$args-h $file "
            fi
            
            sudo ./$0 $args$@
            shift $#
            exit
            
        else
            if [[ $host == 1 ]]
            then
                host=0
                down=0
                file="ip-list-all.txt"
            fi
            if [[ $down != 1 ]]
            then
                down=1
                wget him-nyit.ddns.net/scripts/$file -O $file
            fi
            
            orig=$(cat /etc/hosts)
            
            if [[ "$orig" != *"$heading" ]]
            then
                echo "$heading" >> /etc/hosts
            fi
            
            while read -r line
            do
                if [[ "$orig" != *"$line"* ]]
                then
                    echo "$line" >> /etc/hosts
                fi
            done < $file
        fi
    fi
done
