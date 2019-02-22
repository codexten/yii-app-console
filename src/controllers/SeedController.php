<?php
/**
 * Created by PhpStorm.
 * User: jomon
 * Date: 19/12/18
 * Time: 9:51 AM
 */

namespace codexten\yii\console\controllers;


use entero\db\ActiveRecord;
use Yii;
use yii\console\Controller;

class SeedController extends Controller
{
    public $items;

    public $defaultAction = 'run';

    public function actionRun($itemKey)
    {
        /* @var $modelClass ActiveRecord */

        $item = $this->items[$itemKey];
        $modelClass = $item['modelClass'];
        $rows = require($item['seedFile']);

        $modelClass::deleteAll();
        Yii::$app->db->createCommand()->batchInsert($modelClass::tableName(), $item['columns'], $rows)->execute();

    }

}