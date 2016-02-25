#!/bin/bash

rm -rf composer.lock config templates vendor web
php composer.phar install
