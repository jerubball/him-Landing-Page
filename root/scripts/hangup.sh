#!/bin/bash

for (( i=0; i<20; i++ ))
do
    nohup ping -c 10 localhost & disown
done
