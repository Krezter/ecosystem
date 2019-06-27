<?php

namespace App\Application;

use App\Application\Factory\EcosystemFactory;
use App\Application\Logging\FileLog;
use App\Application\Logic\MapProcessor;
use App\Application\Messages\MapMessages;
use App\Entity\Ecosystem\EntityId;
use App\Entity\Ecosystem\Map;

/**
 * Class Main
 * Модуль взаимодействия структуры с логикой
 * @package App\Application
 */

class Main
{
    private $map;
	private $mapProcessor;
	private $mapMessages;
    private $ecosystemFactory;

    public function __construct()
	{
	    $logger    = new FileLog();
        $this->map = new Map();
        $this->mapMessages      = new MapMessages($logger);
        $this->mapProcessor     = new MapProcessor($logger);
        $this->ecosystemFactory = new EcosystemFactory();
	}

    /**
     * Генерация и запуск жизни в карте
     * @param int $size Размер карты
     */
    public function createNewMap(int $size) : void
	{
	    $size--;
        $this->map->addMap($size);
        $this->createEntities($size);
	}

    /**
     * @param Map $map
     * @return int
     */
    public function loadGame(Map $map) : int
    {
        $this->map = $map;
        return $this->map->getSize();
	}

    /**
     * @param int $size Размер карты
     * @param int $time Время наблюдения
     */
    public function continue(int $size, int $time) : void
    {
        /**
         * Для корректной работы логики, размер карты с учетом 0 элемента, должен быть на 1 меньше
         */
        $size--;

        while ($time > 0 && $this->continueSimulation($size)) {
            $this->mapMessages->reportEndOfCycle($time);
            $time--;
        }

        $this->mapMessages->endProgram();
	}

    /**
     * Продолжения наблюдения за картой
     * @param int $size Размер карты
     * @return bool Возможно ли дальнейшее взаимодействие
     */
    private function continueSimulation(int $size) : bool
    {
        if (!$this->mapProcessor->checkHerbivorous($this->map, $size)) {
            return false;
        }
        $addPlants = $this->mapProcessor->entityInteraction($this->map, $size);
        $this->addEntities(EntityId::PLANT, $addPlants, $size);

        $this->mapProcessor->entityMove($this->map, $size, EntityId::OBSERVER);
        $this->mapProcessor->entityMove($this->map, $size, EntityId::ANIMAL);
        return true;
	}

    /**
     * Создание всех сущностей
     * @param int $size Размер карты
     */
    private function createEntities(int $size) : void
    {
        /**
         * Параметры количества сущностей, в зависимости от размера карты
         */
        $animals = $size*4;
        $plants = $size*2.5;

        $this->addEntities(EntityId::OBSERVER, 1, $size);
        $this->addEntities(EntityId::ANIMAL, $animals, $size);
        $this->addEntities(EntityId::PLANT, $plants, $size);
	}

    /**
     * Добавление сущности в случайное место на карте
     * @param int $entityId Номер сущности
     * @param int $countEntity Количество создаваемых сущностей
     * @param int $size Размер карты
     */
    private function addEntities(int $entityId, int $countEntity, int $size) : void
    {
        while ($countEntity > 0) {
            $entity = $this->ecosystemFactory->createEntity($entityId);
            $this->mapMessages->newEntity($entity);
            $this->mapProcessor->addRandomLocation($entity, $size, $this->map);
            $countEntity--;
        }
    }
}