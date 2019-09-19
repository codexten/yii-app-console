<?php
/**
 * Created by PhpStorm.
 * User: jomon
 * Date: 29/7/18
 * Time: 5:38 PM
 */

namespace codexten\yii\console\controllers;

/**
 * Class AdminAppController
 *
 * @package entero\admin\console
 * @author Jomon Johnson <jomon@entero.in>
 */
class ConsoleAppController extends \hidev\base\Controller
{
    public $defaultAction = 'deploy';

    public function actionDeploy()
    {
        return $this->take('consoleApp')->save();
    }
}