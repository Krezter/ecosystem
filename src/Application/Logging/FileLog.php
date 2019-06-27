<?php

namespace App\Application\Logging;

/**
 * Class FileLog
 * @package App\Application\Logging
 */
class FileLog implements LoggerInterface
{

    /**
     * @param string $message
     */
    public function print(string $message): void
    {
        file_put_contents(__DIR__.'\..\..\..\var\log\log.txt', $message.PHP_EOL, FILE_APPEND);
    }
}