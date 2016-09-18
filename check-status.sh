#!/bin/bash
# Ejecuta el comando que actualiza los estados
DIR=/home/fcontreras2/proyecto/DigitalSignage-Facyt
php $DIR/app/console ds_facyt:check-status 2> $DIR/cron/check-status.log

exit 0