<?php

use codexten\yii\console\controllers\GitController;
use codexten\yii\console\controllers\MessageController;
use codexten\yii\console\controllers\SeedController;

/* @var $migrationNamespaces array */

return [
    'id' => 'console',
    'runtimePath' => '@root/runtime/console',
    'controllerNamespace' => 'codexten\yii\console\controllers',
    'controllerMap' => [
        'app' => [
            'class' => '\codexten\yii\console\controllers\AppController',
        ],
        'migrate' => [
            'class' => '\codexten\yii\console\controllers\MigrateController',
            'migrationPath' => null,
            'migrationNamespaces' => $migrationNamespaces,
        ],
        'rbac-migrate' => [
            'class' => '\yii\console\controllers\MigrateController',
        ],
        'db' => [
            'class' => '\codexten\yii\console\controllers\DbController',
            'initFile' => $params['db.emptyDb'],
            'initFileWithData' => $params['db.initDb'],
            'repo' => $params['db.repo'],
        ],
        'message' => [
            'class' => MessageController::class,
        ],
        'cron' => [
            'class' => '\codexten\yii\console\controllers\CronController',
        ],
        'seed' => [
            'class' => SeedController::class,
        ],
        'git' => [
            'class' => GitController::class,
        ],
    ],
];
