#!/bin/bash

NUM="$1"

[ -z "$NUM" ] && echo "Please provide a number argument" && exit 1

while sleep 0.1; do
    response=$(curl -s -b cookie${NUM}.txt -c cookie${NUM}.txt "http://127.0.0.1:8081/test?client=${NUM}")

    if [ "${#response}" -lt 130 ]; then
        echo "$response"
    else
        echo -e "EXCEPTION\n"
        echo "$response" | tail -n 1
    fi
done