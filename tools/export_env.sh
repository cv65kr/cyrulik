#!/bin/bash

cat ../.env | while read line; do
    if [ -n "$line" ]; then
        export $line
    fi
done