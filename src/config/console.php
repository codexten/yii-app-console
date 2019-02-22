<?php
/**
 * Created by PhpStorm.
 * User: jomon
 * Date: 8/5/18
 * Time: 8:45 PM
 */

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
            'class' => \codexten\yii\console\controllers\MessageController::class,
        ],
        'cron' => [
            'class' => '\codexten\yii\console\controllers\CronController',
        ],
        'seed' => [
            'class' => \codexten\yii\console\controllers\SeedController::class,
        ],
    ],
];