#!/bin/sh

ROLE=${APP_ROLE:-app}

case "$ROLE" in
  app) exec php-fpm ;;
  worker) exec supervisord -c /etc/supervisor/supervisord.conf ;;
  scheduler) exec /usr/local/bin/php /var/www/html/artisan schedule:work ;;
  *) exit 1 ;;
esac
