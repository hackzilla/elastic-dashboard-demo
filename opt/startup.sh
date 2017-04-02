#!/bin/bash

sudo -u www-data /var/www/html/bin/console cache:clear --env=prod
sudo -u www-data /var/www/html/bin/console cache:clear --env=dev

sudo -u www-data /var/www/html/bin/console doctrine:migrations:migrate --no-interaction

/usr/local/bin/apache2-foreground
