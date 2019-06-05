<?php
/**
 * Created by PhpStorm.
 * User: jomon
 * Date: 8/6/18
 * Time: 9:52 PM
 */

namespace codexten\yii\console\controllers;


use yii\console\widgets\Table;
use yii\helpers\ArrayHelper;
use yii\helpers\Console;

class MigrateController extends \yii\console\controllers\MigrateController
{
    /**
     * @var array
     */
    public $skippedMigrations = [];

    /**
     * @inheritdoc
     * @throws \ReflectionException
     */
    protected function getNewMigrations()
    {
        $migrations = parent::getNewMigrations();

        foreach ($this->skippedMigrations as $version) {
            ArrayHelper::removeValue($migrations, $version);
        }

        $migrationHistory = $this->getMigrationHistory(null);

//        foreach ($migrations as $key => $migration) {
//            $migrationClass = new \ReflectionClass($migration);
//            if ($migrationClass->hasMethod('alternatives')) {
//                $alternatives = $migration::alternatives();
//                foreach ($alternatives as $key => $alternative) {
//                    if (is_array($alternative)) {
//
//                    } elseif (isset($migrationHistory[$alternative])) {
//                        unset($migrations[$key]);
//                    }
//
//                }
//            }
//
//        }

        return $migrations;
    }
}
