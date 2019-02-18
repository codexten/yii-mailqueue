<?php
/**
 * @link https://entero.co.in/
 * @copyright Copyright (c) 2012 Entero Software Solutions Pvt.Ltd
 * @license https://entero.co.in/license/
 */

namespace codexten\mailqueue;


interface LoggerInterface
{
    public function info($message);

//    public function debug($message);
//
//    public function notice($message);
//
//    public function warning($message);

    public function error($message);

//    public function critical($message);
//
//    public function alert($message);
//
//    public function emergency($message);
}