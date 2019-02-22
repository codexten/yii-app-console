<?php

return [
    'controllerMap' => [
        'console-app' => [
            'class' => \codexten\yii\console\controllers\ConsoleAppController::class,
        ],
    ],
    'components' => [
        'include' => [
            __DIR__ . '/goals.yml',
        ],
        'consoleApp' => [
            'class' => \codexten\yii\console\components\ConsoleApp::class,
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@hidev/views' => ['@codexten/yii/console/views'],
                ],
            ],
        ],
        'vcsignore' => [
            'runtime/console/*' => 'Console directories',
            'runtime/logs/cron*' => 'Console directories',
        ],
    ],
];
