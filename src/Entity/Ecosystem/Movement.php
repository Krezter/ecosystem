<?php

namespace App\Entity\Ecosystem;

/**
 * Interface Movement
 * Отслеживание движения сущностей
 * @package App\Application\Struct\Entity
 */
abstract class Movement
{
    private $isMove;
    /**
     * Запись события перемещения
     * @param bool $entityMove Двигалась ли сущность
     */
    public function move(bool $entityMove) : void
    {
        $this->isMove = $entityMove;
    }

    /**
     * Проверка на перемещение сущности
     * @return bool Было ли движение
     */
    public function getMove() : bool
    {
        return $this->isMove;
    }
}