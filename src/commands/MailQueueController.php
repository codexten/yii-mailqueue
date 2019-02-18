<?php

/**
 * Mail Command Controller
 *
 * @author Rochdi B. <rochdi80tn@gmail.com>
 */

namespace codexten\yii\mailqueue\commands;

use yii\console\Controller;

/**
 * This command processes the mail queue
 */
class MailQueueController extends Controller
{

    public $defaultAction = 'process';

    /**
     * This command processes the mail queue
     */
    public function actionProcess()
    {
        \Yii::$app->mailer->process();
    }
}
