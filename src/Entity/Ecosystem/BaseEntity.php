<?php

namespace App\Entity\Ecosystem;

/**
 * Interface BaseEntity
 * Интерфейси базовой сущности
 * @package App\Application\Struct\Entity
 */
interface BaseEntity
{
    /**
     * Информация о сущности в виде массива
     * @return array Массив с данными о сущности
     */
    public function getInfo() : array;
}