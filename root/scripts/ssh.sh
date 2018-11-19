#!/bin/bash

version="
him-ssh version 1.10
    ssh command executer from him-nyit.ddns.net
"
help="
Usage: ./ssh.sh [OPTIONS] COMMAND

OPTIONS:
    -h --help    : bring this help topic
    -v --version : display script version
    -s --sudo    : run with elevated priviledge
    -c --copy-id : adds this machine as authroized host to all servers

The options will be processed in entered order.
"
cont=1
copy=1

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
            
        # copy identity to all other
        elif [[ $1 == "--copy-id" || $1 == "-c" ]]
        then
            copy=0
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
        if [[ $copy == 1 ]]
        then
            ssh -t ieee@EGGC-603-14 $@
            ssh -t ieee@EGGC-603-15 $@
            ssh -t ieee@EGGC-603-16 $@
            ssh -t ieee@EGGC-603-17 $@
            ssh -t ieee@EGGC-603-18 $@
            ssh -t ieee@EGGC-603-19 $@
            shift $#
        else
            ssh-copy-id ieee@EGGC-603-14
            ssh-copy-id ieee@EGGC-603-15
            ssh-copy-id ieee@EGGC-603-16
            ssh-copy-id ieee@EGGC-603-17
            ssh-copy-id ieee@EGGC-603-18
            ssh-copy-id ieee@EGGC-603-19
        fi
    fi
done
