#!/bin/bash

DIR=`dirname $0`
cd $DIR/..

composer install --no-interaction --prefer-source

$DIR/../vendor/bin/phpunit -c $DIR/phpunit.xml $@
