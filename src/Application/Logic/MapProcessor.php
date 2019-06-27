<?php

namespace App\Application\Logic;

use App\Application\Messages\MapMessages;
use App\Entity\Ecosystem\BaseEntity;
use App\Entity\Ecosystem\EntityId;
use App\Entity\Ecosystem\Movement;
use App\Entity\Ecosystem\Observer;

use App\Entity\Ecosystem\Map;

/**
 * Class MapProcessor
 * Класс логики карты и взаимодействия на ней
 * @package App\Application\Logic
 */
class MapProcessor
{
    private $tileProcessor;
    private $mapMessages;

    /**
     * MapProcessor constructor.
     * @param $logger
     */
    public function __construct($logger)
    {
        $this->tileProcessor = new TileProcessor($logger);
        $this->mapMessages   = new MapMessages($logger);

    }

    /**
     * Движение сущностей по карте
     * @param Map $map Объект карты, на которой находятся сущности
     * @param int $size Размер карты
     * @param int $entityId Номер передвигаемой сущности
     */
    public function entityMove(Map $map, int $size, int $entityId) : void
    {
        for ($x = 0; $x <= $size; $x++) {
            for ($y = 0; $y <= $size; $y++) {
                $tile = $map->getTile($x, $y);
                $entities = $tile->getEntity($entityId);
                if (count($entities)) {
                    foreach ($entities as $key => $entity) {
                        /** @var Movement $entity */
                        if (!$entity->getMove()) {
                            $this->mapMessages->entityMove($x, $y, $entity);
                            if ($entity instanceof Observer) {
                                $newX = $newY = -1;
                            } else {
                                $newX = $this->getAnimalLocation($size, $x);
                                $newY = $this->getAnimalLocation($size, $y);
                            }
                            $this->addRandomLocation($entity, $size, $map, $newX, $newY);
                            $entity->move(true);
                            $tile->deleteEntity($entityId, $key);
                        }
                    }
                }
            }
        }
    }

    /**
     * Новая координата для животного
     * @param int $size Размер карты
     * @param int $coordinate Текущая координата
     * @return int Новая координата
     */
    private function getAnimalLocation(int $size, int $coordinate) : int
    {
        do {
            $newCoordinate = $coordinate + EntityId::getRandInt(-1, 1);
            if ($newCoordinate < 0) {
                $newCoordinate += $size;
            }
            if ($newCoordinate > $size) {
                $newCoordinate -= $size;
            }
        } while ($newCoordinate === $coordinate);

        return $newCoordinate;
    }

    /**
     * Добавление сущности в случайные координаты, если не были переданны координаты
     * @param BaseEntity $entity Объект добавляемой сущности
     * @param int $size Размер карты
     * @param Map $map Объект изменяемой карты
     * @param int $x Координата по х для добавления
     * @param int $y Координата по у для добавления
     */
    public function addRandomLocation(BaseEntity $entity, int $size, Map $map, int $x = -1, int $y = -1) : void
    {
        if ($x < 0 && $y < 0) {
            $x = EntityId::getRandInt(0, $size);
            $y = EntityId::getRandInt(0, $size);
        }
        $this->mapMessages->onLocation($x, $y);
        $tile = $map->getTile($x, $y);
        $this->tileProcessor->addEntity($tile, $entity);
    }

    /**
     * Взаимодействие сущностей на карте
     * @param Map $map Объект изменяемой карты
     * @param int $size Размер карты
     * @return int Количество уничтоженных цветов на карте
     */
    public function entityInteraction(Map $map, int $size) : int
    {
        for ($x = 0; $x <= $size; $x++) {
            for ($y = 0; $y <= $size; $y++) {
                $tile = $map->getTile($x, $y);
                if ($this->tileProcessor->interaction($tile)) {
                    $this->mapMessages->onLocation($x, $y, 'Действие');
                }
            }
        }

        return $this->tileProcessor->getUnsetPlants();
    }

    /**
     * Проверка травоядных по карте
     * @param Map $map объект проверяемой карты
     * @param int $size Размер карты
     * @return bool Остался ли хоть один травоядный
     */
    public function checkHerbivorous(Map $map, int $size) : bool
    {
        for ($x = 0; $x <= $size; $x++) {
            for ($y = 0; $y <= $size; $y++) {
                $tile = $map->getTile($x, $y);
                if ($this->tileProcessor->getHerbivorous($tile)) {
                    return true;
                }
            }
        }

        $this->mapMessages->herbivorousDie();
        return false;
    }
}