#! /bin/bash

# install on ubuntu 12.04

read -p 'Are you sure to install on ubuntu[y/n]:' option

if [ $option != 'y' ];
then
    return;
fi

# do install
mv index.php index.php_bak
mv index_ubuntu.php index.php

mv ../wrca_server ../v1
