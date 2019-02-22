<?php
/**
 * @link https://entero.co.in/
 * @copyright Copyright (c) 2012 Entero Software Solutions Pvt.Ltd
 * @license https://entero.co.in/license/
 */

namespace codexten\yii\console\controllers;

use Ifsnop\Mysqldump\Mysqldump;
use Yii;
use yii\console\Controller;
use yii\helpers\Console;
use yii\helpers\FileHelper;

/**
 * Class DbController
 *
 * @package codexten\yii\console\controllers
 * @author Jomon Johnson <jomon@entero.in>
 */
class DbController extends Controller
{
    public $initFile = false;
    public $initFileWithData = false;
    public $repo = false;
    public $dbFolder = '@runtime/db-folder';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->dbFolder = Yii::getAlias($this->dbFolder);
        parent::init();
    }


    /**
     * @param bool $tables
     *
     * @throws \yii\db\Exception
     */
    public function actionDrop($tables = false)
    {
        $db = Yii::$app->db;
        $db->createCommand("SET foreign_key_checks = 0;")->execute();
        if ($tables) {

            foreach (explode(',', $tables) as $tableName) {
                $tableName = "{{%{$tableName}}}";

                $db->createCommand("DROP TABLE IF EXISTS `{$tableName}`")->execute();
            }

        } else {
            foreach ($db->schema->tableNames as $table) {
                Console::output("Dropping : {$table}");
                $db->createCommand("DROP TABLE `{$table}`")->execute();
            }
        }
        $db->createCommand("SET foreign_key_checks = 1;")->execute();
    }

    /**
     * function for backing up database
     *
     */
    public function actionBackup()
    {
        $dbUsername = env('DB_USERNAME');
        $dbPassword = env('DB_PASSWORD');
        $dbDsn = env('DB_DSN');
        $backupFolder = Yii::getAlias('@runtime/db/');
        FileHelper::createDirectory($backupFolder);
        $backupFile = $backupFolder . time() . '.sql';
        try {
            $dump = new Mysqldump($dbDsn, $dbUsername, $dbPassword);
            $dump->start($backupFile);
        } catch (\Exception $e) {
            echo 'mysqldump-php error: ' . $e->getMessage();
        }
    }

    /**
     * function for restoring the database
     *
     */
    public function actionRestore()
    {
        if (!file_exists($this->dbFile)) {
            Console::output("DB import failed. file {$this->dbFile} not found");

            return;
        }
        $sql = file_get_contents($this->dbFile);
        $this->runAction('drop', ['interactive' => $this->interactive]);
        Yii::$app->db->createCommand($sql)->execute();
    }

    public function actionInit()
    {
        if (!$this->repo) {
            return;
        }

        if (Yii::$app->db->createCommand("show tables")->execute() !== 0) {
            return;
        }

        $input = Console::prompt("Import DB With \n\t 1. With data\n\t 2. Without data\n  \t 3. Skip \n", [
            'required' => true,
            'validator' => function ($input, $error) {
                if ($input < 1 && $input > 3) {
                    return false;
                }

                return true;
            },
            'error' => "Please select 1 ,2 or 3\n",
        ]);

        if ($input == 3) {
            return;
        }

        $dbFile = $input == 1 ? $this->initFileWithData : $this->initFile;
        Console::output("Importing DB from {$dbFile} .......\n");

        $this->cloneRepo();

        $this->import($dbFile);
    }

    protected function cloneRepo()
    {
        if (!file_exists($this->dbFolder)) {
            Console::output("Cloning {$this->repo} ro {$this->dbFolder}");
            exec("git clone {$this->repo} {$this->dbFolder}");
        }

        if (file_exists($this->dbFolder)) {
            Console::output("Git pulling in {$this->dbFolder}");
            exec("git -C {$this->dbFolder} pull");
        }
    }

    /**
     * Import sql file to Db
     *
     * @param $file
     *
     * @throws \yii\db\Exception
     */
    protected function import($file)
    {
        $file = $this->dbFolder . DIRECTORY_SEPARATOR . $file;
        if (!file_exists($file)) {
            Console::output("DB import failed. file {$file} not found");

            exit();
        }
        $db = Yii::$app->db;
        $c = 1;
        Console::output("Importing {$file}");

        $db->createCommand("SET foreign_key_checks = 0;")->execute();

        $fp = fopen($file, 'r');

        // Temporary variable, used to store current query
        $templine = '';
        // Loop through each line
        while (($line = fgets($fp)) !== false) {
            // Skip it if it's a comment
            if (substr($line, 0, 2) == '--' || $line == '') {
                continue;
            }
            // Add this line to the current segment
            $templine .= $line;
            // If it has a semicolon at the end, it's the end of the query
            if (substr(trim($line), -1, 1) == ';') {

                $db->createCommand($templine)->execute();

                // Reset temp variable to empty
                $templine = '';
            }
        }
        //close the file
        fclose($fp);

        $db->createCommand("SET foreign_key_checks = 1;")->execute();
    }

//    protected function import($file)
//    {
//        $file = $this->dbFolder . DIRECTORY_SEPARATOR . $file;
//        if (!file_exists($file)) {
//            Console::output("DB import failed. file {$file} not found");
//
//            exit();
//        }
//
//        Console::output("Importing {$file}");
//
//        $sql = file_get_contents($file);
//
//        $db = Yii::$app->db;
//        $c = 1;
//
//        $db->createCommand("SET foreign_key_checks = 0;")->execute();
//        $items = explode('\n', $sql);
//        foreach ($items as $item) {
//            echo '<pre>';
//            var_dump($item);
//            echo '</pre>';
//            exit;
//            echo $c++ . ".\n";
//            $db->createCommand($item)->execute();
//        }
//
//        $db->createCommand("SET foreign_key_checks = 1;")->execute();
//
//    }
}