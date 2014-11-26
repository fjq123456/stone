<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language' => 'zh_CN',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'formatter' => [
	        'dateFormat' => 'yyyy/MM/dd',
	        // 'decimalSeparator' => ',',
	        // 'thousandSeparator' => ' ',
	        // 'currencyCode' => 'EUR',
            'nullDisplay' => ''
	   	],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=127.0.0.1;dbname=yii2advanced',
            'username' => 'yii',
            'password' => 'yii2014',
            'charset' => 'utf8',
            'tablePrefix' => ''
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ]
    ],
];
