<?php

namespace Magestio\Redsys\Logger;

use Magento\Framework\Logger\Handler\Base;
use Monolog\Logger;

class Handler extends Base
{
    protected $fileName = '/var/log/redsys.log';
    protected $loggerType = Logger::INFO;
}