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
    ],
];
