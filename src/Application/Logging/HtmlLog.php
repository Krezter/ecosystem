<?php

namespace App\Application\Logging;

/**
 * Class HtmlLog
 * @package App\Application\Logging
 */
class HtmlLog implements LoggerInterface
{

    /**
     * @param $message
     */
    public function print(string $message): void
    {
        echo '<p style="margin-left: 30px">'.$message.'</p>';
    }
}