<?php

$container->setParameter('database_host', 'database');
$container->setParameter('database_name', $_ENV['MYSQL_DATABASE']);
$container->setParameter('database_user', $_ENV['MYSQL_USER']);
$container->setParameter('database_pass', $_ENV['MYSQL_PASS']);
