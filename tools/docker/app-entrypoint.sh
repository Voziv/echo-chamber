#!/usr/bin/env sh

set -e

role="app"
env="production"
[ -n "${CONTAINER_ROLE}" ] && role=${CONTAINER_ROLE}
[ -n "${APP_ENV}" ] && env=${APP_ENV}

echo "[${env}] Server is configured to be '${CONTAINER_ROLE}' or defaults to ${role}"
if [ "$env" != "local" ]; then
    echo "[${env}] Caching configuration..."
    (
      cd /var/www/app \
      && php artisan config:cache \
      && php artisan view:cache
    )
fi

# Run

if [ "$role" = "app" ]; then

    exec php-fpm

elif [ "$role" = "queue" ]; then

    echo "Running the queue..."
    exec php /var/www/app/artisan queue:work --verbose --tries=3 --timeout=90

elif [ "$role" = "scheduler-background-loop" ]; then

    while true; do
      php /var/www/app/artisan schedule:run --verbose --no-interaction &
      sleep 60
    done

elif [ "$role" = "scheduler" ]; then

      exec php /var/www/app/artisan schedule:run --verbose --no-interaction

else

    echo "Could not match the container role \"$role\""
    exit 1

fi
