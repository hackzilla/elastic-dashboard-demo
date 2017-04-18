#!/bin/bash

echo 'Defaults   env_keep += "MYSQL_DATABASE MYSQL_USER MYSQL_PASS"' > /etc/sudoers.d/database

sudo -u www-data /var/www/html/bin/console cache:clear --env=prod
sudo -u www-data /var/www/html/bin/console cache:clear --env=dev

sudo -u www-data /var/www/html/bin/console doctrine:migrations:migrate --no-interaction
sudo -u www-data /var/www/html/bin/console app:elastic:create-index
sudo -u www-data /var/www/html/bin/console app:elastic:create-pipeline
sudo -u www-data /var/www/html/bin/console app:elastic:create-mapping

/usr/local/bin/apache2-foreground
