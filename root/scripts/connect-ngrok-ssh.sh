#!/bin/bash

if [[ $# -gt 0 ]]
then
    response=$1
else
    read -p "Enter hostname: " response
fi


if [[ "${response^^}" == "EGGC-603-14" || "$response" == "603-14" || "$response" == "14" ]]
then
    port=0

elif [[ "${response^^}" == "EGGC-603-15" || "$response" == "603-15" || "$response" == "15" ]]
then
    port=0

elif [[ "${response^^}" == "EGGC-603-16" || "$response" == "603-16" || "$response" == "16" ]]
then
    port=0

elif [[ "${response^^}" == "EGGC-603-17" || "$response" == "603-17" || "$response" == "17" ]]
then
    port=0

elif [[ "${response^^}" == "EGGC-603-18" || "$response" == "603-18" || "$response" == "18" ]]
then
    port=0

elif [[ "${response^^}" == "EGGC-603-19" || "$response" == "603-19" || "$response" == "19" ]]
then
    port=0

elif [[ "${response^^}" == "EGGC-603-20" || "$response" == "603-20" || "$response" == "20" ]]
then
    port=0

elif [[ "${response^^}" == "EGGC-603-21" || "$response" == "603-21" || "$response" == "21" ]]
then
    port=0

elif [[ "${response^^}" == "EGGC-603-22" || "$response" == "603-22" || "$response" == "22" ]]
then
    port=0

elif [[ "${response^^}" == "EGGC-603-23" || "$response" == "603-23" || "$response" == "23" ]]
then
    port=0

elif [[ $response -gt 1023 ]]
then
    port=$response

else
    port=0
fi


if [[ $port -ne 0 ]]
then
        ssh -l ieee -p $port 0.tcp.ngrok.io
else
        echo "No hostname found."
fi
