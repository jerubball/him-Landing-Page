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
    --editor-args
        : use additional arguments for editor
    --compiler-args
        : use additional arguments for compiler
    --program-args
        : use additional arguments for program

The options will be processed in entered order.
"
contact="
Contact for bug report, suggestion, and other information.
    EMAIL: him.nyit@gmail.com
    WEBSITE: http://him-nyit.ddns.net
"
edit=1
comp=1
prog=1
editarg=1
comparg=1
progarg=1

args=$(getopt -q -s bash -l "help,version,sudo,editor,compiler,program,editor-args,compiler-args,program-args" "?hvsecp" "$@")
if [[ $? == 1 || "$#" == 0 ]]
then
    echo "$version"
    echo "$help"
    echo "$contact"
    exit 1
fi
eval set -- "$args"
#eval args=($args)

while [[ $# > 0 ]]
do
    # option processing
    case $1 in
        # print help topic
        -h | --help | -\? )
            echo "$version"
            echo "$help"
            echo "$contact"
            exit
        ;;
        # print script version
        -v | --version )
            echo "$version"
            echo "$contact"
            exit
        ;;
        # run as sudo
        -s | --sudo )
            if [[ $(id -u) -ne 0 ]]
            then
                eval sudo $0 $args
                exit $?
            fi
        ;;
        # define editor
        -e | --editor )
            edit="$2"
            shift
        ;;
        # define compiler
        -c | --compiler )
            comp="$2"
            shift
        ;;
        # define program
        -p | --program )
            prog="$2"
            shift
        ;;
        # define editor arguments
        --editor-args )
            editarg="$2"
            shift
        ;;
        # define compiler arguments
        --compiler-args )
            comparg="$2"
            shift
        ;;
        # define program arguments
        --program-args )
            progarg="$2"
            shift
        ;;
        # escape option processing
        -- )
            shift
            break
        ;;
        # unrecognized option
        * )
            echo "unrecognized option"
            exit 1
        ;;
    esac
    shift
done

echo "$1"


