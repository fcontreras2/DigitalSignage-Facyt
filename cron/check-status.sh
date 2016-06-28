#!/bin/bash

# Define el directorio actual
APP_DIR="$( cd "$( dirname "$OLDPWD" )" && pwd )"

# Define log file and folder
LOG_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
LOG_FILE=check-status.log

# Ejecuta el comando que actualiza los estados
php $APP_DIR/FC/DigitalSignage-Facyt/app/console ds_facyt:check-status >> $LOG_DIR/$LOG_FILE

exit 0