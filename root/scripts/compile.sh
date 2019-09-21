#!/bin/bash

version="
him-compile version 1.0
    quick edit and compiler from him-nyit.ddns.net
"
help="
Usage: ./compile.sh [OPTIONS] [FILENAME] [EDITOR ARGS] [COMPILER ARGS] [PROGRAM ARGS]
OPTIONS:
    -h --help
        : bring this help topic
    -v --version
        : display script version
    -s --sudo
        : run with elevated priviledge
    -e --editor
        : use specified editor
          Default editor is nano
    -c --compiler
        : use specified compiler
          Default compiler is detected from file extension
    -p --program
        : use specified program to execute output
          Default program is detected from file extension

The options will be processed in entered order.
"
contact="
Contact for bug report, suggestion, and other information.
    EMAIL: him.nyit@gmail.com
    WEBSITE: http://him-nyit.ddns.net
"
cont=1
edit="nano"
comp=1
prog=1


args=$(getopt -q -s bash -l "help,version,sudo,editor,compiler,program" "?hvsecp" "$@")
if [[ $? == 1 ]]
then
    echo "$version"
    echo "$help"
    echo "$contact"
    exit
fi
eval set -- "$args"


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
            
        # define editor
        elif [[ $1 == "--edit" || $1 == "-e" ]]
        then
            shift
            edit="$1"
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
    fi
done
