#!/bin/bash

if [[ $(id -u) -ne 0 ]]
then
    sudo ./$0 $@
else
    ssh ieee@EGGC-603-14
    ssh ieee@EGGC-603-15
    ssh ieee@EGGC-603-16
    ssh ieee@EGGC-603-17
    ssh ieee@EGGC-603-18
    ssh ieee@EGGC-603-19
fi

