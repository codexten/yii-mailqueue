<?php
/**
 * @link https://entero.co.in/
 * @copyright Copyright (c) 2012 Entero Software Solutions Pvt.Ltd
 * @license https://entero.co.in/license/
 */

namespace codexten\mailqueue;

use yii\base\BaseObject;

/**
 * Class Logger
 *
 * @package entero\process
 */
abstract class Logger extends BaseObject implements LoggerInterface
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