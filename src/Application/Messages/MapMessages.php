<?php

namespace App\Application\Messages;

use App\Application\Logging\LoggerInterface;
use App\Entity\Ecosystem\BaseEntity;
use App\Entity\Ecosystem\Movement;

/**
 * Class MapMessages
 * Сообщения действий на карте
 * @package App\Application\Messages
 */
class MapMessages
{

    private $logger;

    /**
     * MapMessages constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Информация о передвижении сущности
     * @param int $x Координата по х
     * @param int $y Координата по у
     * @param Movement $entity Объект перемещающейся сущности
     */
    public function entityMove(int $x, int $y, Movement $entity) : void
    {
        /** @var BaseEntity $entity */
        $entityInfo = 'Перемещение'.ObserverMessages::getEntityInfo($entity)." от ($x;$y)";
        $this->logger->print($entityInfo);
    }

    /**
     * Информация о создании новой сущности
     * @param BaseEntity $entity Создаваемая сущность
     */
    public function newEntity(BaseEntity $entity) : void
    {
        $entityInfo = 'Создание'.ObserverMessages::getEntityInfo($entity);
        $this->logger->print($entityInfo);
    }

    /**
     * Информация о съедания сущности животным
     * @param BaseEntity $entity Съедаемая сущность
     * @param BaseEntity $animal Животное, которое его ест
     */
    public function removeEntity(BaseEntity $entity, BaseEntity $animal) : void
    {
        $animalInfo = ObserverMessages::getEntityInfo($animal);
        $entityInfo = ObserverMessages::getEntityInfo($entity);
        $outInfo = 'Животное'.$animalInfo.' съел'.$entityInfo;
        $this->logger->print($outInfo);
    }

    /**
     * Информация о действии в локации
     * @param int $x По координате х
     * @param int $y По координате у
     * @param string $text Дополнительный текст до координат
     */
    public function onLocation(int $x, int $y, string $text = '') : void
    {
        $outInfo = "$text на ($x;$y)";
        if (!empty($text)) {
            $this->logger->print($outInfo);
        } else {
            $this->logger->print($outInfo);
        }
    }

    /**
     * Информация о завершении цикла
     * @param int $time Оставшееся время цикла
     */
    public function reportEndOfCycle(int $time) : void
    {
        $outInfo = '=Конец цикла!= #' .$time;
        $this->logger->print($outInfo);
    }

    /**
     * Информация о вымирании травоядных
     */
    public function herbivorousDie() : void
    {
        $outInfo = 'Травоядные вымерли...!';
        $this->logger->print($outInfo);
    }

    /**
     * Информация об окончании наболюдения
     */
    public function endProgram() : void
    {
        $outInfo = 'Время наблюдения истекло!';
        $this->logger->print($outInfo);
    }
}