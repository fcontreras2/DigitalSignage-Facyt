#!/bin/bash

# Define el directorio actual
APP_DIR="$( cd "$( dirname "$OLDPWD" )" && pwd )"

# Define log file and folder
LOG_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
LOG_FILE=clean-old-data.log

# Ejecuta el comando que actualiza los estados
php $APP_DIR/app/console ds_facyt:clean-old-data >> $APP_DIR/cron/$LOG_FILE

exit 0