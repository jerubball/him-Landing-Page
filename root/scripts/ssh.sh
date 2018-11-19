#!/bin/bash

help="
him-ssh version 1.7
    ssh command executer from him-nyit.ddns.net

usage: ./ssh.sh [OPTIONS] COMMAND

OPTIONS:
    -h --help    : bring this help topic
    -s --sudo    : run with elevated priviledge
    -c --copy-id : adds this machine as authroized host to all servers

The options will be processed in entered order.
"
copy=1

while true
do
    # print help topic
    if [[ $1 == "--help" || $1 == "-h" ]]
    then
        echo "$help"
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
        
    #
    elif [[ $1 == "--copy-id" || $1 == "-c" ]]
    then
        copy=0
        shift
        
    # execute command
    else
        if [[ copy == 1 ]]
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
    
    # do-while condition
    [[ $# > 0 ]] || exit
done
