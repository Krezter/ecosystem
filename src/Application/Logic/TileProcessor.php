<?php

namespace App\Application\Logic;

use App\Application\Logging\LoggerInterface;
use App\Application\Messages\MapMessages;
use App\Entity\Ecosystem\EntityId;
use App\Entity\Ecosystem\Herbivorous;
use App\Entity\Ecosystem\Observer;
use App\Entity\Ecosystem\BaseEntity;
use App\Application\Messages\ObserverMessages;

use App\Entity\Ecosystem\Tile;

/**
 * Class TileProcessor
 * Класс логики взаимодействия на клетке
 * @package App\Application\Logic
 */
class TileProcessor
{
    private $observerMessages;
    private $mapMessages;
    /**
     * TileProcessor constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->observerMessages  = new ObserverMessages($logger);
        $this->mapMessages       = new MapMessages($logger);
    }

    private $unsetPlants = 0;
    /**
     * Добавить сущность в клетку
     * @param Tile $tile Объект клетки, для добавления в него
     * @param BaseEntity $entity Объект добавляемой сущности
     */
    public function addEntity(Tile $tile, BaseEntity $entity) : void
    {
        $tile->setEntity($entity);
    }

    /**
     * Запуск взаимодействия внутри клетки
     * @param Tile $tile Объект клетки для взаимодействия
     * @return bool Произошло ли взаимодействие внутри сущностей
     */
    public function interaction(Tile $tile) : bool
	{
		$observers = $tile->getEntity(EntityId::OBSERVER);
		$animals   = $tile->getEntity(EntityId::ANIMAL);
		$plants    = $tile->getEntity(EntityId::PLANT);
		$interact  = false;

        if ($this->observerInteract($observers, $animals, $plants, $tile)) {
            $interact = true;
        }
        if ($this->animalsInteract($animals, $plants, $tile)) {
            $interact = true;
        }
        $this->unsetMove($observers);
        $this->unsetMove($animals);

        return $interact;
	}

    /**
     * Действия наблюдателя
     * @param array $observers Массив наблюдателей
     * @param array $animals Массив животных
     * @param array $plants Массив растений
     * @param Tile $tile Объект наболюдаемой клетки
     * @return bool Сделал ли наблюдател ноые записи
     */
    private function observerInteract(array $observers, array $animals, array $plants, Tile $tile) : bool
    {
        if (count($observers) && (count($animals) || count($plants))) {
            foreach ($observers as $observer) {
                /**@var Observer $observer*/
                $observerInfo = $observer->getInfo();
                $date = EntityId::getTime();
                $this->observerMessages->observerInfo($observerInfo, $date);
                $this->observationRecord($animals);
                if ($this->observationRecord($plants)) {
                    $key = array_rand($plants);
                    $tile->deleteEntity(EntityId::PLANT, $key);
                    $this->observerMessages->removePlant();
                    $this->unsetPlants++;
                }
            }
            return true;
        }
        return false;
	}

    /**
     * Запись наболюдателя о сущности
     * @param array $entities Массив наблюдаемой сущности
     * @return bool Удалось ли добавить сущность
     */
    private function observationRecord(array $entities) : bool
    {
        if (count($entities)) {
            foreach ($entities as $entity) {
                $this->observerMessages->observationInfo($entity);
            }
            return true;
        }
        return false;
    }

    /**
     * Действия животных
     * @param array $animals Массив животных
     * @param array $plants Массив растений
     * @param Tile $tile Объект клетки с животными
     * @return bool Произошло ли взаимодействие
     */
    private function animalsInteract(array $animals, array $plants, Tile $tile) : bool
    {
        if (count($animals)) {
            foreach ($animals as $key => $animal) {
                if ($animal instanceof Herbivorous) {
                    if (count($plants)) {
                        $key = array_rand($plants);
                        $this->mapMessages->removeEntity($plants[$key], $animal);
                        $plantInfo = $plants[$key]->getInfo();
                        $animal->setPower($plantInfo['nutritious']);
                        $tile->deleteEntity(EntityId::PLANT, $key);
                        $this->unsetPlants++;
                        return true;
                    }
                } elseif (count($animals) > 1) {
                    return $this->predatorAction($key, $animals, $tile);
                }
            }
        }

        return false;
    }

    /**
     * Взаимодействие хищников
     * @param int $actualKey Позиция в массиве текущей сущности
     * @param array $animals Массив с животными
     * @param Tile $tile Объект клетки на которой животные
     * @return bool Произошло съедание
     */
    private function predatorAction(int $actualKey, array $animals, Tile $tile) : bool
    {
        $actualAnimal = $animals[$actualKey];
        foreach ($animals as $otherKey => $otherAnimal) {
            if ($actualKey !== $otherKey) {
                $otherAnimalInfo = $otherAnimal->getInfo();
                $actualAnimalInfo = $actualAnimal->getInfo();
                if ($actualAnimalInfo['power'] > $otherAnimalInfo['power']) {
                    $this->mapMessages->removeEntity($otherAnimal, $actualAnimal);
                    $actualAnimal->setPower(-$otherAnimalInfo['power']);
                    $tile->deleteEntity(EntityId::ANIMAL, $otherKey);
                    return true;
                }

                $this->mapMessages->removeEntity($actualAnimal, $otherAnimal);
                $otherAnimal->setPower(-$actualAnimalInfo['power']);
                $tile->deleteEntity(EntityId::ANIMAL, $actualKey);
                return true;
            }
        }
        return false;
    }

    /**
     * Отдых после передвижения сущности
     * @param array $entities Массив с сущностями
     */
    private function unsetMove(array $entities) : void
    {
        if (count($entities)) {
            foreach ($entities as $entity) {
                $entity->move(false);
            }
        }
    }

    /**
     * Информация об уничтоженных растениях
     * @return int Количество растений
     */
    public function getUnsetPlants() : int
    {
        $temp = $this->unsetPlants;
        $this->unsetPlants = 0;
        return $temp;
    }

    /**
     * Проверка существования травоядных
     * @param Tile $tile Объект клетки для проверки
     * @return bool Информация о существовании
     */
    public function getHerbivorous(Tile $tile) : bool
    {
        $animals = $tile->getEntity(EntityId::ANIMAL);
        if (count($animals)) {
            foreach ($animals as $animal) {
                /**@var BaseEntity $animal*/
                $animalInfo = $animal->getInfo();
                if ($animalInfo['power'] < 100) {
                    return true;
                }
            }
        }
        return false;
    }
}