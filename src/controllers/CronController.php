<?php
/**
 * @link https://entero.co.in/
 * @copyright Copyright (c) 2012 Entero Software Solutions Pvt.Ltd
 * @license https://entero.co.in/license/
 */

namespace codexten\yii\console\controllers;

use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Console;

/**
 * Class CronController
 *
 * @package codexten\yii\console\controllers
 * @author Jomon Johnson <jomon@entero.in>
 */
class CronController extends Controller
{
    // events
    const EVENT_ON_EVERY_MINUTE_RUN = "cronEveryMinute";
    const EVENT_ON_EVERY_FIVE_MINUTE_RUN = "cronEveryFiveMinute";
    const EVENT_ON_HOURLY_RUN = "cronHourly";
    const EVENT_ON_DAILY_RUN = "cronDaily";

    /**
     * Executes every minute cron tasks.
     */
    public function actionEveryMinute()
    {
        $this->stdout("Executing every minute tasks:\n\n", Console::FG_YELLOW);

        $this->trigger(self::EVENT_ON_EVERY_MINUTE_RUN);

//        Yii::$app->settings->set('cronLastHourlyRun', time());

        return ExitCode::OK;
    }

    /**
     * Executes every five minute cron tasks.
     */
    public function actionEveryFiveMinute()
    {
        $this->stdout("Executing every five minute tasks:\n\n", Console::FG_YELLOW);

        $this->trigger(self::EVENT_ON_EVERY_FIVE_MINUTE_RUN);

//        Yii::$app->settings->set('cronLastHourlyRun', time());

        return ExitCode::OK;
    }

    /**
     * Executes hourly cron tasks.
     */
    public function actionHourly()
    {
        $this->stdout("Executing hourly tasks:\n\n", Console::FG_YELLOW);

        $this->trigger(self::EVENT_ON_HOURLY_RUN);

//        Yii::$app->settings->set('cronLastHourlyRun', time());

        return ExitCode::OK;
    }

    /**
     * Executes daily cron tasks.
     */
    public function actionDaily()
    {
        $this->stdout("Executing daily tasks:\n\n", Console::FG_YELLOW);

        $this->trigger(self::EVENT_ON_DAILY_RUN);

//        Yii::$app->settings->set('cronLastDailyRun', time());

        return ExitCode::OK;
    }

}
