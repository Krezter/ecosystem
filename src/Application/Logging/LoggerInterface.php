<?php

namespace App\Application\Logging;

/**
 * Interface LoggerInterface
 * @package App\Application\Logging
 */
interface LoggerInterface
{
    /**
     * @param $message
     */
    public function print(string $message) : void;
}