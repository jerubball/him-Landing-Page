#!/bin/bash

version="
him-apache version 1.6
    script to set apache folder permission from him-nyit.ddns.net
"
help="
Usage: ./apache.sh [OPTIONS]

OPTIONS:
    -h --help
        : bring this help topic
    -v --version
        : display script version
    -g --group name
        : desired group name
          Default is adm.
    -p --permission code
        : desired permission code
          Default is 775.

The options will be processed in entered order.
"
cont=1
grps=1
name=""
perm=1
code=""
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
            
        # set group name
        elif [[ $1 == "--group" || $1 == "-g" ]]
        then
            grps=0
            shift
            name="$1"
            shift
            
        # set permission code
        elif [[ $1 == "--permission" || $1 == "-p" ]]
        then
            perm=0
            shift
            code="$1"
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
            if [[ $grps != 1 ]]
            then
                args="$args-g $name "
            fi
            if [[ $perm != 1 ]]
            then
                args="$args-p $code "
            fi
            
            sudo ./$0 $args$@
            shift $#
            exit
            
        else
            if [[ $grps == 1 ]]
            then
                name="adm"
            fi
            if [[ $perm == 1 ]]
            then
                code="775"
            fi
            
            chmod -R $code /etc/apache2
            chgrp -R $name /etc/apache2

            chmod -R $code /var/www
            chgrp -R $name /var/www

            chmod -R $code /usr/lib/apache2
            chgrp -R $name /usr/lib/apache2

            chmod -R $code /var/lib/apache2
            chgrp -R $name /var/lib/apache2

            chmod -R $code /usr/share/apache2
            chgrp -R $name /usr/share/apache2
        fi
    fi
done
