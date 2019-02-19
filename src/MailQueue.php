<?php

/**
 * MailQueue.php
 *
 * @author Saranga Abeykoon http://nterms.com
 */

namespace codexten\yii\mailqueue;

use codexten\yii\mailqueue\logger\KLogger;
use entero\models\Queue;
use Yii;
use yii\base\InvalidConfigException;
use yii\di\Instance;
use yii\swiftmailer\Mailer;

/**
 * MailQueue is a sub class of [yii\switmailer\Mailer](https://github.com/yiisoft/yii2-swiftmailer/blob/master/Mailer.php)
 * which intends to replace it.
 *
 * Configuration is the same as in `yii\switmailer\Mailer` with some additional properties to control the mail queue
 *
 * ~~~
 *    'components' => [
 *        ...
 *        'mailqueue' => [
 *            'class' => 'nterms\mailqueue\MailQueue',
 *            'table' => '{{%mail_queue}}',
 *            'mailsPerRound' => 10,
 *            'maxAttempts' => 3,
 *            'transport' => [
 *                'class' => 'Swift_SmtpTransport',
 *                'host' => 'localhost',
 *                'username' => 'username',
 *                'password' => 'password',
 *                'port' => '587',
 *                'encryption' => 'tls',
 *            ],
 *        ],
 *        ...
 *    ],
 * ~~~
 *
 * @see http://www.yiiframework.com/doc-2.0/yii-swiftmailer-mailer.html
 * @see http://www.yiiframework.com/doc-2.0/ext-swiftmailer-index.html
 *
 * This extension replaces `yii\switmailer\Message` with `nterms\mailqueue\Message'
 * to enable queuing right from the message.
 *
 */
class MailQueue extends Mailer
{
    const NAME = 'mailqueue';

    /**
     * @var string message default class name.
     */
    public $messageClass = 'codexten\yii\mailqueue\Message';

    /**
     * @var string the name of the database table to store the mail queue.
     */
    public $table = '{{%mail_queue}}';

    /**
     * @var integer the default value for the number of mails to be sent out per processing round.
     */
    public $mailsPerRound = 10;

    /**
     * @var integer maximum number of attempts to try sending an email out.
     */
    public $maxAttempts = 3;


    /**
     * @var boolean Purges messages from queue after sending
     */
    public $autoPurge = true;

    public $logFolder = '@runtime/mail-queue-logs';
    /**
     * @var Logger|array
     * It can be either logger class name or an array with configuration
     * Example for array
     * `````````````
     * 'logger' => [
     *      'class' => KLogger::class,
     *      'fileName" => 'filename'
     * ]
     * ````````````
     */
    public $logger = KLogger::class;

    /**
     * Initializes the MailQueue component.
     */
    public function init()
    {
        parent::init();
        if (is_string($this->logger)) {
            $this->logger = [
                'class' => $this->logger,
                'fileName' => 'Mail-Queue-log',
            ];
        } else {
            if (!isset($this->logger['class'])) {
                throw new InvalidConfigException('Logger Class Name must be specified');
            }
        }
        $this->logger['logFolder'] = Yii::getAlias($this->logFolder);
        $this->logger = Instance::ensure($this->logger, LoggerInterface::class);
    }

    /**
     * @return bool
     * @throws \yii\base\InvalidConfigException
     */
    public function process()
    {
        if (Yii::$app->db->getTableSchema($this->table) == null) {
            throw new \yii\base\InvalidConfigException('"' . $this->table . '" not found in database. Make sure the db migration is properly done and the table is created.');
        }

        $success = true;

        while (true) {
            $items = \codexten\yii\mailqueue\models\MailQueue::find()->where([
                'and',
                ['sent_time' => null],
                ['<', 'attempts', $this->maxAttempts],
                ['<=', 'time_to_send', date('Y-m-d H:i:s')],
            ])->orderBy(['created_at' => SORT_ASC])->limit($this->mailsPerRound);
            foreach ($items->each() as $item) {
                /* @var Queue $item */

                if ($message = $item->toMessage()) {
                    $attributes = ['attempts', 'last_attempt_time'];
                    try {
                        if ($this->send($message)) {
                            $item->sent_time = time();
                            $attributes[] = 'sent_time';
                            $item->delete();
                        } else {
                            $success = false;
                        }

                        $item->attempts++;
                        $item->last_attempt_time = time();

                        $item->updateAttributes($attributes);
                    } catch (\Exception $exception) {
                        $this->logger->info($exception);
                    }
                }
            }
            sleep(1);
        }

        return $success;
    }
}
