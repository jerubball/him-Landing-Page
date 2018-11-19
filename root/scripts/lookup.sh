#!/bin/bash

for (( num=1; num < 255; num++ ))
do
    nslookup 64.35.176.$num | head -n 1 | grep --color=never ^[^*]
    nslookup 10.10.32.$num | head -n 1 | grep --color=never ^[^*]
done
