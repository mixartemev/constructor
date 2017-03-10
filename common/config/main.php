<?php
$config = [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];
if (!YII_ENV_TEST) {
	// configuration adjustments for 'dev' environment
	$config['bootstrap'][] = 'gii';
	//php yii gii/construct --template=const
	$config['modules']['gii'] = [
		'class' => 'yii\gii\Module',
		'generators' => [
			// Имя генератора
			'construct' => [
				// Класс генератора
				'class'     => 'yii\gii\generators\crud\Generator',
				// Настройки шаблонов
				'templates' => [
					// Имя шаблона => путь к шаблону
					'const' => '@common/components/generators/crud/construct',
				]
			],
		],
	];
}

return $config;
