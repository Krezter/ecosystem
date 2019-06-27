<?php

namespace App\Entity\Ecosystem;

/**
 * Class Tile
 * Класс отдельной клетки
 * @package App\Application\Struct
 */
class Tile
{
    private $observers = [];
    private $animals   = [];
    private $plants    = [];

    /**
     * Добавление сущности на текущую клетку
     * @param BaseEntity $entity Записываемая сущность
     */
    public function setEntity(BaseEntity $entity) : void
    {
        if ($entity instanceof Animal) {
            $this->animals[] = $entity;
        }

        if ($entity instanceof Plant) {
            $this->plants[] = $entity;
        }

        if ($entity instanceof Observer) {
            $this->observers[] = $entity;
        }
    }

    /**
     * Взятие сущности из клетки по его номеру
     * @param int $entityId Номер сущности
     * @return array Пустой, или содержаший сущность массив
     */
    public function getEntity(int $entityId) : array
    {
        switch ($entityId) {
            case EntityId::OBSERVER:
                return $this->observers;
                break;
            case EntityId::ANIMAL:
                return $this->animals;
                break;
            case EntityId::PLANT:
                return $this->plants;
                break;
        }

        return [];
    }

    /**
     * Удаление сущности из клетки по его номеру в массиве
     * @param int $entityId Номер сущности
     * @param int $entityKey Порядковый номер в массиве
     */
    public function deleteEntity(int $entityId, int $entityKey) : void
    {
        switch ($entityId) {
            case EntityId::OBSERVER:
                unset($this->observers[$entityKey]);
                break;
            case EntityId::ANIMAL:
                unset($this->animals[$entityKey]);
                break;
            case EntityId::PLANT:
                unset($this->plants[$entityKey]);
                break;
        }
    }
}