<?php
/**
 * Created by PhpStorm.
 * User: sreenath
 * Date: 9/20/18
 * Time: 11:41 AM
 */

namespace codexten\yii\console;


class Application extends \yii\console\Application
{

    public function getSession()
    {
        return $this->get('session');
    }

//    public function getUser()
//    {
//        return $this->get('user');
//    }
}