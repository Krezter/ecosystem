<?php

namespace App\Application\Factory;

use App\Entity\Ecosystem\Animal;
use App\Entity\Ecosystem\EntityId;
use App\Entity\Ecosystem\Predator;
use App\Entity\Ecosystem\Herbivorous;
use App\Entity\Ecosystem\LargePredator;
use App\Entity\Ecosystem\BaseEntity;
use App\Entity\Ecosystem\Observer;
use App\Entity\Ecosystem\Plant;


/**
 * Class EcosystemFactory
 * Фабрика для создания сущностей
 * @package App\Application\Factory
 */
class EcosystemFactory
{
    /**
     * Создание сущности по номеру
     * @param int $entity Номер создаваемой сущности
     * @return BaseEntity Созданная сущность
     */
    public function createEntity(int $entity) : BaseEntity
    {
        switch ($entity) {
            case EntityId::OBSERVER:
                return $this->createObserver();
                break;
            case EntityId::ANIMAL:
                return $this->createAnimal();
                break;
            case EntityId::PLANT:
                return $this->createPlant();
                break;
        }
        return null;
    }

    /**
     * Создание наблюдателя
     * @return Observer Объект наблюдатель
     */
    private function createObserver() : Observer
    {
        $id = EntityId::getRandInt(1, 10);
        return new Observer($id);
    }

    /**
     * Создание случайного животного
     * @return Animal Объект животного
     */
    private function createAnimal() : Animal
    {
        $power = EntityId::getRandInt(1, 300);

        if ($power < 100) {
            return new Herbivorous('Herbivorous', $power);
        }
        if ($power < 200) {
            return new Predator('Predator', $power);
        }
        return new LargePredator('Large Predator', $power);
    }

    /**
     * Создание растения
     * @return Plant Объект растения
     */
    private function createPlant() : Plant
    {
        $nutritious = EntityId::getRandInt(1, 10);

        return new Plant('Plant', $nutritious);
    }
}