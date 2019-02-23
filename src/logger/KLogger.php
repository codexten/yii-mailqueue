<?php
/**
 * Created by PhpStorm.
 * User: jomon
 * Date: 5/17/18
 * Time: 4:22 PM
 */

namespace codexten\yii\mailqueue\logger;

use Katzgrau\KLogger\Logger;
use Psr\Log\LogLevel;

/**
 * Class KLogger
 *
 * @package codexten\yii\mailqueue\logger
 */
class KLogger extends \codexten\yii\mailqueue\Logger
{
    public $logFolder = '@console/runtime/process-logs';
    public $fileName;
    /**
     * @var Logger
     */
    protected $logger;

    public function init()
    {
        parent::init();
        $this->logFolder = \Yii::getAlias($this->logFolder);
        $options = [
            'filename' => $this->fileName,
        ];
        $this->logger = new Logger($this->logFolder, LogLevel::DEBUG, $options);
    }

    public function info($message)
    {
        $this->logger->info($message);
    }

    public function error($message)
    {
        $this->logger->error($message);
    }

    /**
     * @inheritdoc
     */
    public function clean()
    {
        file_put_contents($this->logger->getLogFilePath(), '');
    }

}