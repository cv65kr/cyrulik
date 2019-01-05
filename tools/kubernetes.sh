#!/bin/bash

set -e

kubectl create secret generic cyrulik-secrets --from-file=../.docker.env

kubectl apply -f 0-redis-service.yaml

kubectl apply -f 1-zookeeper-service.yaml