<?php

namespace App\Application\Logging;

/**
 * Class ConsoleLog
 * @package App\Application\Logging
 */
class ConsoleLog implements LoggerInterface
{

    /**
     * @param $message
     */
    public function print(string $message): void
    {
        echo $message.PHP_EOL;
    }
}