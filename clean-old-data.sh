#!/bin/bash

# Ejecuta el comando que actualiza los estados
DIR=/home/fcontreras2/proyecto/DigitalSignage-Facyt
php $DIR/app/console ds_facyt:clean-old-data 2> $DIR/cron/clean-old-data.log

exit 0