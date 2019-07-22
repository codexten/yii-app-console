<?php


namespace codexten\yii\console\controllers;


use yii\console\Controller;

class GitController extends Controller
{

    public function actionIndex($command)
    {
        $currentDir = getcwd();
        $vendorDir = $currentDir . '/vendor';
        if (is_link($vendorDir)) {
            $vendorDir = readlink($vendorDir);
        }

        $projectPath = rtrim($vendorDir, '/vendor');
        chdir($projectPath);
        exec("git {$command}");
        chdir($currentDir);
        echo "\n";
    }

}
