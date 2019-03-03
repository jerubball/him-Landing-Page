#!/bin/bash

version="
him-ssh version 1.16
    ssh command executer from him-nyit.ddns.net
"
help="
Usage: ./ssh.sh [OPTIONS] COMMAND

OPTIONS:
    -h --help
        : bring this help topic
    -v --version
        : display script version
    -s --sudo
        : run with elevated priviledge
    -c --copy-id
        : adds this machine as authroized host to all servers
    -u --user name
        : specify login username
    -o --host filename
        : specify file with hostnames
    -d --download filename
        : download and use remote hostnames
          By default, script will download host-list-mint.txt file.

The options will be processed in entered order.
"
cont=1
copy=1
host=1
down=1
list=""
name=""
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
            
        # specify username
        elif [[ $1 == "--user" || $1 == "-u" ]]
        then
            shift
            name="$1@"
            shift
            
        # specify host file
        elif [[ $1 == "--host" || $1 == "-o" ]]
        then
            host=0
            shift
            list="$1"
            shift
            
        # download host file
        elif [[ $1 == "--download" || $1 == "-d" ]]
        then
            host=0
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
        
        if [[ $host == 1 ]]
        then
            host=0
            down=0
            list="host-list-mint.txt"
        fi
        if [[ $down != 1 ]]
        then
            down=1
            wget him-nyit.ddns.net/scripts/$list -O $list
        fi
        
        list="$(cat $list)"
        
        if [[ $copy == 1 ]]
        then
            for host in $list
            do
                #todo. add hash comment
                echo "Connecting to $name$host"
                ssh -t $name$host $@
            done
            shift $#
        else
            copy=1
            for host in $list
            do
                ssh-copy-id $name$host
            done
        fi
    fi
done
