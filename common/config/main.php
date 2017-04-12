<?php
$config = [
    'language'=>'ru-RU',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource'
                ],
            ],
        ],
    ],
];
if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    //php yii gii/construct
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'generators' => [
            'construct' => [
                'class' => 'common\components\generators\crud\Generator',
            ],
            'mod' => [
                'class' => 'common\components\generators\model\Generator',
            ],
        ],
    ];
}

return $config;
