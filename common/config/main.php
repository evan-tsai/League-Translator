<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language' => 'en_US',
    'sourceLanguage' => 'en_US',
    'components' => [
        'i18n' => [
            'translations' => [
                'app' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    'sourceLanguage' => 'en_US',
                    'fileMap' => [
                        'app' => 'app.php',
                        'app/error' => 'error.php',
                    ],
                ],
            ],
        ],
        'urlManager'=>[
            'enablePrettyUrl'=>true,
            'showScriptName'=>false,
            'rules' => [
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];
