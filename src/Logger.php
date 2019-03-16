<?php

namespace codexten\yii\mailqueue;

use yii\base\Component;

/**
 * Class Logger
 *
 * @package codexten\yii\mailqueue
 */
abstract class Logger extends Component implements LoggerInterface
{
    /**
     * @var string
     */
    public $logFolder = '@_runtime/console';
    /**
     * @var string
     */
    public $fileName;
    /**
     * @var Logger
     */
    protected $logger;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->logFolder = \Yii::getAlias($this->logFolder);
    }

    /**
     * to clean logs
     */
    abstract public function clean();
}
