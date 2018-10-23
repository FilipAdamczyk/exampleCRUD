<?php
return [
    'default' => [
        'type'       => 'MySQLi',
        'connection' => [
            'hostname'   => '10.0.2.2',
            'database'   => 'crud',
            'username'   => 'cruduser',
            'password'   => '#secure_user_pass#',
            'persistent' => FALSE,
            'ssl'        => NULL,
        ],
        'table_prefix' => '',
        'charset'      => 'utf8',
        'caching'      => FALSE,
    ]
];