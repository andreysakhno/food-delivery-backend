<?php

return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost:3306;dbname=delivery_db',
            'username' => 'sakhno_andrii',
            'password' => 'Zw9j&8w31',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'messageConfig' => [
                'from' => ['a.sakhno@welesgard.com' => 'Delivery']
            ],
        ],
    ],
];
