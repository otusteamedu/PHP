<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'sqlite:/app/db.sq3',
    //'dsn' => 'mysql:host='.getenv('DB_HOST').';dbname='.getenv('DB_DATABASE'),
    //'username' => getenv('DB_USER'),
    //'password' => getenv('DB_PASS'),
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
