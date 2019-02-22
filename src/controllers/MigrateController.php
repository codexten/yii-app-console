<?php
/**
 * Created by PhpStorm.
 * User: jomon
 * Date: 8/6/18
 * Time: 9:52 PM
 */

namespace codexten\yii\console\controllers;


use yii\helpers\ArrayHelper;

class MigrateController extends \yii\console\controllers\MigrateController
{
    /**
     * @var array
     */
    public $skippedMigrations = [];

    /**
     * @inheritdoc
     */
    protected function getNewMigrations()
    {
        $migrations = parent::getNewMigrations();

        foreach ($this->skippedMigrations as $version) {
            ArrayHelper::removeValue($migrations, $version);
        }

        return $migrations;
    }


    protected function isExist($version)
    {

    }

}