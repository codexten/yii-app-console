<?php
/**
 * @link https://entero.co.in/
 * @copyright Copyright (c) 2012 Entero Software Solutions Pvt.Ltd
 * @license https://entero.co.in/license/
 */

namespace codexten\yii\console\controllers;

use Yii;
use yii\console\Controller;
use yii\helpers\ArrayHelper;

/**
 * Class AppController
 * For application set up
 *
 * @package codexten\yii\console\controllers
 * @author Jomon Johnson <jomon@entero.in>
 */
class AppController extends Controller
{
    // events
    const EVENT_BEFORE_SETUP = 'beforeSetup';
    const EVENT_AFTER_SETUP = 'afterSetup';
    const EVENT_ACTION_TEST = 'actionTest';

    /**
     * @throws \yii\base\InvalidRouteException
     * @throws \yii\console\Exception
     */
    public function actionSetup()
    {
        $this->trigger(self::EVENT_BEFORE_SETUP);
        Yii::$app->runAction('db/init', ['interactive' => $this->interactive]);
        Yii::$app->runAction('migrate', ['interactive' => $this->interactive]);
        $this->trigger(self::EVENT_AFTER_SETUP);
    }

    public function actionTest()
    {
        $this->trigger(self::EVENT_ACTION_TEST);
//        echo (new Mailer([
//            'code' => 'company-carrier-enlisted',
//            'from' => ['info@transpoedge.com' => 'Transpoedge'],
//            'to' => 'cto@entero.co.in',
//            'params' => [
//                'firstName' => 'Jomon Johnson',
//                'companyCode' => 'companyCode',
//                'companyName' => 'companyName',
//                'carrierCompany' => 'carrierCompany',
//            ],
//        ]))->send();
//       echo Yii::$app->mailer->compose()
//            ->setFrom('info@giventake.world')
//            ->setTo('cto@entero.co.in')
//            ->setSubject('Message subject test')
//            ->setTextBody('Plain text content')
//            ->setHtmlBody('<b>HTML content</b>')
//            ->send()?'ok':'error';
    }

    public function actionRbac()
    {
        \hiqdev\composer\config\Builder::rebuild();
        $rbac = require \hiqdev\composer\config\Builder::path('rbac');

        $roles = ArrayHelper::getValue($rbac, 'roles', []);
        $permissions = ArrayHelper::getValue($rbac, 'permissions', []);

        $authManager = Yii::$app->authManager;

        foreach ($roles as $roleName) {
            $role = $authManager->getRole($roleName);
            if ($role === null) {
                $role = $authManager->createRole($roleName);
                $authManager->add($role);
            }
        }

        foreach ($authManager->getRoles() as $role) {
            $authManager->removeChildren($role);
        }

        foreach ($permissions as $permission => $roles) {
            $permission = $this->getPermission($permission);
            foreach ($roles as $role) {
                $role = $this->getRole($role);
                if ($authManager->canAddChild($role, $permission)) {
                    $authManager->addChild($role, $permission);
                }
            }
        }
    }


    protected function getRole($name)
    {
        $authManager = Yii::$app->authManager;
        $role = $authManager->getRole($name);
        if ($role === null) {
            $role = $authManager->createRole($name);
            $authManager->add($role);
        }

        return $role;
    }

    /**
     * @param $name
     *
     * @return null|\yii\rbac\Permission
     * @throws \Exception
     */
    protected function getPermission($name)
    {
        $authManager = Yii::$app->authManager;
        $permission = $authManager->getPermission($name);
        if ($permission === null) {
            $permission = $authManager->createPermission($name);
            $authManager->add($permission);
        }

        return $permission;
    }

    public function actionCmd()
    {
        $cmd = 'ping google.com';
        while (@ ob_end_flush()) {
            ;
        } // end all output buffers if any

        $proc = popen($cmd, 'r');
        echo '<pre>';
        while (!feof($proc)) {
            echo "\t\t";
            echo fread($proc, 4096);
            @ flush();
        }
        echo '</pre>';
    }
}
