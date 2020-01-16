#!/bin/bash

filename=""
if [[ "$filename" == "" ]]
then
    read -p "Enter file name: " filename
fi

editor=""
if [[ "$editor" == "" ]]
then
    if [[ "$EDITOR" != "" ]]
    then
        editor="$EDITOR"
    else
        editor="nano"
    fi
fi

if [[ ! -f $filename ]]
then
    touch $filename
fi

while true
do
    $editor $filename
    while [[ $? -eq 147 ]]
    do
        fg
    done
    sleep 1
done
