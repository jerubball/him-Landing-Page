#!/bin/bash

host_names="
# The following lines define named intranet hosts
192.168.163.201 EGGC-603-01
192.168.163.202 EGGC-603-02
192.168.163.203 EGGC-603-03
192.168.163.204 EGGC-603-04
192.168.163.205 EGGC-603-05
192.168.163.206 EGGC-603-06
192.168.163.207 EGGC-603-07
192.168.163.208 EGGC-603-08
192.168.163.209 EGGC-603-09
192.168.163.210 EGGC-603-10
192.168.163.211 EGGC-603-11
192.168.163.212 EGGC-603-12
192.168.163.213 EGGC-603-13
192.168.163.214 EGGC-603-14
192.168.163.215 EGGC-603-15
192.168.163.216 EGGC-603-16
192.168.163.217 EGGC-603-17
192.168.163.218 EGGC-603-18
192.168.163.219 EGGC-603-19
192.168.163.220 EGGC-603-20
192.168.163.221 EGGC-603-21
192.168.163.222 EGGC-603-22
192.168.163.223 EGGC-603-23
192.168.163.224 EGGC-603-24
192.168.163.225 EGGC-603-25
192.168.163.226 EGGC-603-26
192.168.163.227 EGGC-603-27
192.168.163.228 EGGC-603-28
192.168.163.229 EGGC-603-29
"

if [[ $(id -u) -ne 0 ]]
then
    sudo ./$0
else
    echo "$host_names" >> /etc/hosts
fi

