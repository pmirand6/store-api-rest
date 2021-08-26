<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => $_ENV['DSN'],
    'username' => $_ENV['USER_DB'],
    'password' => $_ENV['PASSWORD_DB'],
    'charset' => 'utf8',
    'on afterOpen' => function($event) {
        $event->sender->createCommand("SET SESSION time_zone = '-3:00';")->execute();
    }

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];