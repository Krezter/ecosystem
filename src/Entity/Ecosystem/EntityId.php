<?php

namespace App\Entity\Ecosystem;

use DateTime;
use DateTimeZone;
use Exception;

/**
 * Class EntityId
 * Содержит номера сущностей и рандомайзер
 */
class EntityId
{
    public const OBSERVER = 1;
    public const ANIMAL   = 2;
    public const PLANT    = 3;

    /**
     * Получить целое рандомное число в некотором диапозоне
     * @param int $min Минимальное значение
     * @param int $max Максимальное значение
     * @return int Случайное целое число
     */
    public static function getRandInt(int $min, int $max) : int
    {
        try {
            return random_int($min, $max);
        } catch (Exception $e) {
            die('Ошибка при создании случайного числа: '.  $e->getMessage(). "\n");
        }
    }

    /**
     * Генерация текущего времени
     * @return string Время в виде строки
     */
    public static function getTime() : string
    {
        try {
            $dt = new DateTime('now', new DateTimeZone('+0400'));
            return $dt->format('d.m.y, время: H:i:s');
        } catch (Exception $e) {
            die('Ошибка при генерации времени: '.  $e->getMessage(). "\n");
        }
    }
}