<?php

namespace App\Application\Messages;

/**
 * Class WebLogs
 * Вывод сообщений
 * @package App\Application\Messages
 */
class OutputInfo
{
    public const MODE = true;
    /**
     * Простой вывод информации
     * @param string $text Выводимый текст
     */
    public static function simpleOutput(string $text) : void
    {
        echo $text;
    }

    /**
     * Вывод информации с переносом строки
     * @param string $text Выводимый текст
     */
    public static function lineFeedOutput(string $text) : void
    {
        echo $text;
        echo self::MODE ? "\n" : '<br>';
    }

    /**
     * Вывод информации через консоль
     * @param string $text Выводимый текст
     */
    public static function indentOutput(string $text) : void
    {
        echo self::MODE ? "\t".$text."\n" : '<p style="margin-left: 30px">'.$text.'</p>';
    }


}