#!/bin/bash

version="
him-get version 1.23
    script executer from him-nyit.ddns.net
"
help="
Usage: ./him-get.sh [OPTIONS] SCRIPTS

OPTIONS:
    -h --help
        : bring this help topic
    -v --version
        : display script version
    -s --sudo
        : run with elevated priviledge
    -u --update
        : update him-get script
    -e --execute
        : execute as script
          This is default option when -e or -n is not specified.
    -n --nothing
        : do not execute script
    -r --remove
        : remove files
          This is default option when -k or -r is not specified.
    -k --keep
        : keep files
    -c --script
        : assume .sh extension
          This is default option when -c or -l is not specified.
    -l --literal
        : do not assume any file extension
    --http
        : download using http
          This is default option when --http or --https is not specified.
    --https
        : download using https
    -p --pass
        : pass all following but except next argument as parameter of next argument

The options will be processed in entered order.
"
contact="
Contact for bug report, suggestion, and other information.
    EMAIL: him.nyit@gmail.com
    WEBSITE: http://him-nyit.ddns.net
"
cont=1
exec=1
keep=1
literal=1
https=1
pass=1

while [[ $cont == 1 || $# > 0 ]]
do
    # print help for no argument
    if [[ $# == 0 ]]
    then
        echo "$version"
        echo "$help"
        echo "$contact"
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
            
        # do update and exit
        elif [[ $1 == "--update" || $1 == "-u" ]]
        then
            cd $(dirname "$0")
            wget him-nyit.ddns.net/scripts/him-get.sh -O him-get.sh
            chmod +x him-get.sh
            exit
            
        # execute script
        elif [[ $1 == "--execute" || $1 == "-e" ]]
        then
            exec=1
            shift
            
        # do not execute script
        elif [[ $1 == "--nothing" || $1 == "-n" ]]
        then
            exec=0
            shift
            
        # remove file
        elif [[ $1 == "--remove" || $1 == "-r" ]]
        then
            keep=1
            shift
            
        # keep file
        elif [[ $1 == "--keep" || $1 == "-k" ]]
        then
            keep=0
            shift
            
        # assume .sh extension
        elif [[ $1 == "--script" || $1 == "-c" ]]
        then
            literal=1
            shift
            
        # do not assume file extension
        elif [[ $1 == "--literal" || $1 == "-l" ]]
        then
            literal=0
            shift
            
        # download as http
        elif [[ $1 == "--http"]]
        then
            https=1
            shift
            
        # download as https
        elif [[ $1 == "--https"]]
        then
            https=0
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
        
        if [[ $exec != 1 ]]
        then
            if [[ $https == 1 ]]
            then
                wget him-nyit.ddns.net/scripts/$current -O $current
            else
                wget https://him-nyit.ddns.net/scripts/$current -O $current
            fi
            
        else
            if [[ $literal == 1 ]]
            then
                current="$current.sh"
            fi
            
            if [[ $https == 1 ]]
            then
                wget him-nyit.ddns.net/scripts/$current -O $current
            else
                wget https://him-nyit.ddns.net/scripts/$current -O $current
            fi
            chmod +x $current
            
            if [[ $pass == 1 ]]
            then
                ./$current
            else
                ./$current $*
                shift $#
            fi
        fi
        
        if [[ $keep == 1 ]]
        then
            rm $current
        fi
    fi
done

