#!/bin/bash


if [[ $(id -u) -ne 0 ]]
then
    sudo ./$0 $@
else
    ntpdate ntp.nyit.edu
    echo "NTP=ntp.nyit.edu" >> /etc/systemd/timesyncd.conf
    systemctl restart systemd-timesyncd.service
fi
